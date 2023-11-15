<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    protected $table = 'specialties';
    protected $fillable = ['nombre', 'descripcion', 'estado'];

    // Otras propiedades y métodos del modelo, si los tienes

    public function scopeActive($query)
    {
        return $query->where('estado', 1);
    }
}
