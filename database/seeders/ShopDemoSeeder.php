<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. clean tables -----------------------------------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ([
            'addresses','coupon_usages','order_items','order_status_histories',
            'orders','reviews','product_images','product_variants',
            'products','brands','categories','customers','coupons','settings'
        ] as $table) { DB::table($table)->truncate(); }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. customers --------------------------------------------------------
        $customers = Customer::factory()->count(50)->create();

        // 3. addresses --------------------------------------------------------
        foreach ($customers as $c) {
            Address::factory()->count(rand(1,3))->create(['customer_id' => $c]);
        }

        // 4. categories & brands ---------------------------------------------
        $categories = Category::factory()->count(10)->create();
        $brands     = Brand::factory()->count(8)->create();

        // 5. products ---------------------------------------------------------
        $products = Product::factory()
            ->count(60)
            ->recycle($categories)
            ->recycle($brands)
            ->create();

        // 6. variants ---------------------------------------------------------
        foreach ($products->random(20) as $p) {
            $p->update(['has_variants' => true]);
            ProductVariant::factory()->count(rand(2,5))->create(['product_id' => $p]);
        }

        // 7. product images ---------------------------------------------------
        foreach ($products as $p) {
            ProductImage::factory()->count(rand(3,6))->create(['product_id' => $p]);
        }

        // 8. coupons ----------------------------------------------------------
        $coupons = Coupon::factory()->count(6)->create();

        // 9. orders + items + status history + coupon usage ------------------
        foreach ($customers->random(30) as $customer) {
            $order = Order::factory()->recycle($customer)->create();

            // items
            $items = $products->random(rand(1,5));
            foreach ($items as $product) {
                $variant = $product->has_variants ? $product->variants->random() : null;
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_id'         => $product->id,
                    'product_variant_id' => $variant?->id,
                    'product_name'       => $product->name,
                    'product_sku'        => $product->sku,
                    'variant_name'       => $variant?->name,
                    'price'              => $variant?->price ?? $product->price,
                    'quantity'           => rand(1,3),
                    'subtotal'           => 0, // mutator
                ]);
            }

            // status history
            OrderStatusHistory::factory()->count(rand(2,4))->create(['order_id' => $order]);

            // coupon usage
            if (rand(0,1) && $coupons->isNotEmpty()) {
                CouponUsage::create([
                    'coupon_id'   => $coupons->random()->id,
                    'customer_id' => $customer->id,
                    'order_id'    => $order->id,
                ]);
            }
        }

        // 10. reviews (dynamic count) ----------------------------------------
        $deliveredItems = OrderItem::whereHas('order', fn($q) => $q->where('status', 'delivered'))->get();
        if ($deliveredItems->isNotEmpty()) {
            $reviewCount = min(40, $deliveredItems->count());
            foreach ($deliveredItems->random($reviewCount) as $oi) {
                Review::factory()->create([
                    'product_id'           => $oi->product_id,
                    'customer_id'          => $oi->order->customer_id,
                    'order_id'             => $oi->order_id,
                    'is_verified_purchase' => true,
                ]);
            }
        }

        // 11. settings --------------------------------------------------------
        Setting::insert([
            ['key'=>'shop_name',        'value'=>'Laravel Demo Shop','type'=>'string','group'=>'general'],
            ['key'=>'shop_email',       'value'=>'hello@demo.test',  'type'=>'string','group'=>'general'],
            ['key'=>'shop_phone',       'value'=>'+1-800-555-1234',  'type'=>'string','group'=>'general'],
            ['key'=>'tax_rate',         'value'=>'8.25',             'type'=>'number','group'=>'tax'],
            ['key'=>'shipping_enabled', 'value'=>'1',                'type'=>'boolean','group'=>'shipping'],
        ]);
    }
}