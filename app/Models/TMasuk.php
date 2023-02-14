<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMasuk extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function Label(){
        return $this->belongsTo(Label::class);
    }
}
