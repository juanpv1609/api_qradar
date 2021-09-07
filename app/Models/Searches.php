<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Searches extends Model
{
    protected $table = 'Searches';
    protected $fillable = ['search_id',
                            'company_id',
                            'description',
                            'name',
                            'data',
                            'is_deleted'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
