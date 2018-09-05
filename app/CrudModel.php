<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrudModel extends Model
{
    protected $table = "cruds";
    protected $fillable = ["nama", "judul"];
}
