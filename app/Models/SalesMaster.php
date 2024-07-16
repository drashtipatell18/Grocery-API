<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesMaster extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'sales_masters';
    protected $fillable = ['user_id','coupon_id','user_address_id','order_date','sub_total','total_amount','discount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the coupon that is applied to the sales master.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the user address associated with the sales master.
     */
    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class);
    }
}
