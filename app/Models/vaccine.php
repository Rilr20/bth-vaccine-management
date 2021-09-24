<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vaccine extends Model
{
    use HasFactory;
    protected $timestamp = false;
    /*
    CREATE TABLE vaccine (
        vaccine_id INT NOT NULL,
        vaccine_name varchar(50),
        vaccine_type varchar(50),
        PRIMARY KEY (vaccine_id)
    );
    */
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'vaccine_id',
        'vaccine_name',
        'vaccine_type',
    ];
}
