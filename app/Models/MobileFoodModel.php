<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Library\GoogleGeo;

class MobileFoodModel extends Model
{
    protected $primaryKey         = 'locationid';
    public $timestamps            = false;
    public $table                 = 'Mobile_Food_Facility_Permit';
    public $guarded               = [];

    const FACILITY_TYPE_TRUCK     = 'Truck';
    const FACILITY_TYPE_PUSH_CARt = 'Push Cart';


}
