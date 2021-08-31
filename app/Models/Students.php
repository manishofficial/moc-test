<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'university'
    ];

    public function university()
    {
        // return $this->hasOne(Universities::class);
        $university = $this->belongsTo(Universities::class, 'university', 'id')->get()->pluck('name')->toArray();
        if (!empty($university)) {
            return implode(',', $university);
        }else{
            return '';
        }
    }
}
