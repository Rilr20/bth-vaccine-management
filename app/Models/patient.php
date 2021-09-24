<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

    // protected $primaryKey = 'personnumber';
    // protected $keyType = 'string';
    // public $incrementing = false;
    protected $dateFormat = 'Y/m/d';

    /*
    CREATE TABLE patient (
        personnumber VARCHAR(12) NOT NULL,
        fullname varchar(50),
        phonenumber VARCHAR(15),
        age DATE,
        gender VARCHAR(1),
        journal TEXT,
        
        PRIMARY KEY (personnumber)
    );
    */
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'personnumber',
        'fullname',
        'phonenumber',
        'age',
        'gender',
        'journal',
    ];
}
