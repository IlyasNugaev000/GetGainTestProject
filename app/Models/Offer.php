<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Pivot
{
    use HasFactory, SoftDeletes;

    const COL_SELLER_ID = 'seller_id';
    const COL_PRODUCT_ID = 'product_id';
    const COL_PRICE = 'price';
    const COL_QUANTITY = 'quantity';

    public $incrementing = true;
    public $table = 'offers';
}
