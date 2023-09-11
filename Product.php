<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PUBLISHED = 'publish';
    const PENDING = 'pending';
    const DRAFT = 'draft';
    const IN_STOCK = 'in_stock';
    const OUTOFSTOCK = 'out_of_stock';

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
