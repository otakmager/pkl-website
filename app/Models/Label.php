<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Label extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function TMasuk(){
        return $this->hasMany(TMasuk::class);
    }
    public function TKeluar(){
        return $this->hasMany(TKeluar::class);
    }
}
