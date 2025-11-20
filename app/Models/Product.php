<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'sku',
        'is_active',
    ];

    // generate uniqu sku for product
    protected static function booted()
    {
        static::creating(function ($product) {
            if (!$product->sku) {
                $product->sku = 'SKU-' . strtoupper(uniqid());
            }
        });
    }


     // check the stock of the product
     public function checkStock()
     {
         if ($this->quantity <= 0) {
             throw new \Exception("Product {$this->name} is out of stock");
         }
     }
}

