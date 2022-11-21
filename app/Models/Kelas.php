<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function User(){
        return $this->hasMany(User::class, 'kelas_id');
    }
}
