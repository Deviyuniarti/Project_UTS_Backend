<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    use HasFactory;

    //mendeteksi kolom yang boleh di mass assignment
    protected $fillable = [
        'name',
        'gender',
        'phone',
        'address',
        'email',
        'status',
        'hired_on'
    ];
}
