<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = ['description',
                            'is_deleted'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}
