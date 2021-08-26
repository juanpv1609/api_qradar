<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rules extends Model
{
    protected $table = 'rules';
    protected $fillable = ['qid',
                            'company_id',
                            'description',
                            'it_ot',
                            'is_deleted'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
