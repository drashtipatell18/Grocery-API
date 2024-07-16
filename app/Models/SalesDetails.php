<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesDetails extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'sales_details';
    protected $fillable = ['sales_master_id','product_id','quantity','amount','discount','total_amount'];

    public function salesMaster()
    {
        return $this->belongsTo(SalesMaster::class, 'sales_master_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
