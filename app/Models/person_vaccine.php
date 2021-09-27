<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class person_vaccine extends Model
{
    use HasFactory;

    protected $dateFormat  = 'Y/m/d H:i:s';

    // protected $timestamp = false;
    /*
    CREATE TABLE person_vaccine (
        id INT AUTO_INCREMENT NOT NULL,
        patient_id INT NOT NULL,
        staff INT NOT NULL,
        vaccine_id INT NOT NULL,
        date_taken DATETIME NOT NULL,
        expiration_date DATE NOT NULL,
        
        PRIMARY KEY (id),
        FOREIGN KEY (person_id) REFERENCES patient(personnumber),
        FOREIGN KEY (vaccine_id) REFERENCES vaccine(vaccine_id),
        FOREIGN KEY (staff_id) REFERENCES staff(id)
    );
    */
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'patient_id',
        'staff',
        'vaccine_id',
        'date_taken',
        'expiration_date',
    ];

}
