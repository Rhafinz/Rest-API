<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Film;

class kategori extends Model
{
    use HasFactory;
    public function  film(){
        return $this->hasMany(Film::class, 'id_kategori');
    }
}
