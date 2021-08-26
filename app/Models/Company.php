<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    protected $fillable = ['description',
                            'domain',
                            'is_deleted'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    /* public function rules(){
        return $this->hasMany(Rules::class, 'product_id', 'id');
    } */
}
