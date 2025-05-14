<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SalesOrderDetail extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'sales_order_detail';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'harga',
        'jumlah',
        'barang_id',
        'sales_order_id',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }
}