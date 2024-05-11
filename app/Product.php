<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'products';

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
