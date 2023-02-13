<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TKeluar extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Label(){
        return $this->belongsTo(Label::class);
    }
}
