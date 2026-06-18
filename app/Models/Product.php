<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];

    // Relasi Belongs-To: Banyak produk masuk ke satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi Many-to-Many ke tabel Orders melalui pivot order_items
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
