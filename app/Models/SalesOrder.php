<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    protected $table = 'sales_order';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'status',
        'tanggal',
        'totalHarga',
        'pembayaran_id',
        'customer_id',
    ];

    public function details()
    {
        return $this->hasMany(SalesOrderDetail::class, 'sales_order_id', 'id');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}