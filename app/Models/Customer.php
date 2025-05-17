<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'nama',
        'alamat',
        'noTelp',
    ];
    public $timestamps = false;

}