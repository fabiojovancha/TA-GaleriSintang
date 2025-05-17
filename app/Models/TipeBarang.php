<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeBarang extends Model
{
    use HasFactory;
    protected $table = 'tipe_barang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'tipeBarang',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'tipe_barang_id');
    }
    public $timestamps = false;

}