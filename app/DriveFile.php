<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriveFile extends Model
{
    protected $table = 'drive_files';
    protected $fillable = [
        'file_id' , 'file'
    ];
}
