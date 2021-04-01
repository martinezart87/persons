<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    use HasFactory;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'surname',
    ];

    /**
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
