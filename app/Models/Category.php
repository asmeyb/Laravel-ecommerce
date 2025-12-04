<?php

namespace App\Models;

use Filament\Forms\Components\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description',
        'image','is_active','sort_order', 'meta_title',
        'meta_description'
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

        static::creating(function($category){
            if(empty($category->slug))
            {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function($category){
            if($category->isDirty('name') && empty($category->empty))
            {
                $category->slug = Str::slug($category->name);
            }
        });

    }
}
