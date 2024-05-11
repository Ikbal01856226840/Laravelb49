<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $table = 'sales_summary';

    public function saleDetails():HasMany
    {
        return $this->hasMany(SaleDetail::class, 'invoice_id', 'id');
    }
}
