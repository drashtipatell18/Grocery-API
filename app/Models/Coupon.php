<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'coupons';
    protected $fillable = ['name','coupon_code','coupon_description','discount','discount_type','image','start_date','expiry_date','minimum_order_amount'];
}
