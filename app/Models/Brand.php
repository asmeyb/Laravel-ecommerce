<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Filament\Forms\Components\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name', 'slug', 'description', 'logo', 'website', 'is_active', 'sort_order'
    ];

    #[Scope()]
    public function active(Builder $builder)
    {
        $builder->where('is_active', true);
    }

    #[Scope()]
    public function sorted(Builder $builder)
    {
        $builder->orderBy('sort_order', 'asc');
    }

    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($brand){
            if(empty($brand->slug))
            {
                $brand->slug = Str::slug($brand->name);
            }
        });

        static::updating(function($brand){
            if($brand->isDirty('name') && empty($brand->empty))
            {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

}
