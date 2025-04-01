<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'price',
        'compare_price',
        'options',
        'rating',
        'featured',
        'status'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }


    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $user = Auth::user(0);

            if ($user && $user->store_id) {
                $builder->where('store_id', '=', $user->store_id);
            }

        });
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, // النموذج المرتبط
            'product_tag', // اسم الجدول الوسيط
            'product_id', // المفتاح الأجنبي لهذا النموذج في الجدول الوسيط
            'tag_id', // المفتاح الأجنبي للنموذج الآخر في الجدول الوسيط
            'id', // المفتاح الأساسي لهذا النموذج
            'id' // المفتاح الأساسي للنموذج الآخر
        );
    }
}
