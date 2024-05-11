<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = [
        'expenditures', 'description', 'date', 'expense', 'user_id', 'parent_id',
    ];
}
