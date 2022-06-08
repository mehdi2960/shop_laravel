<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'type', 'unit', 'category_id','product_id','category_attribute_id','value'];


    public function attribute()
    {
        return $this->belongsTo(CategoryAttribute::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
