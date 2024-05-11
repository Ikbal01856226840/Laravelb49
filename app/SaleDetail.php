<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'sales_detail';

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
