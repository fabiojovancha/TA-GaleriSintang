<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga_beli',
        'harga_jual',
        'jumlah',
        'safety_stok',
        'lead_time',
        'tipe_barang_id',
    ];

    public function tipeBarang()
    {
        return $this->belongsTo(TipeBarang::class, 'tipe_barang_id');
    }
    public $timestamps = false;

}