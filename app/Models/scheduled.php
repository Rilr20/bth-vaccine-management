<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class scheduled extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $dateFormat  = 'Y/m/d H:i:s';
    
    /*
    CREATE TABLE scheduled(
        id INT AUTO_INCREMENT NOT NULL,
        person varchar(12) not NULL,
        staff INT NOT NULL,
        booked DATETIME NOT NULL,
        vaccine_id INT NOT NULL,
        
        PRIMARY KEY (id),
        FOREIGN KEY (person) REFERENCES patient(personnumber),
        FOREIGN KEY (staff) REFERENCES staff(id),
        FOREIGN KEY (vaccine_id) REFERENCES vaccine(vaccine_id)
    );
    */
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'person',
        'staff',
        'booked',
        'vaccine_id',
    ];
}
