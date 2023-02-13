<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function TMasuk(){
        return $this->hasMany(TMasuk::class);
    }
    public function TKeluar(){
        return $this->hasMany(TKeluar::class);
    }
}
