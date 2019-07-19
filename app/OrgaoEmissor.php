<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgaoEmissor extends Model
{
    protected $fillable = [
        'descricao', 
    ];

    public function profissionals()
    {
        return $this->hasMany('App\Profissional');
    }    
}
