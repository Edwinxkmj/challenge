<?php

namespace App\Service;

use App\Library\GoogleGeo;
use App\Models\MobileFoodModel;
use App\Exceptions\ApiException;
use App\Consts\SystemError;

class MobileFoodService
{
    public $mobileFoodModel;

    public function __construct(MobileFoodModel $mobileFoodModel)
    {
        $this->mobileFoodModel = $mobileFoodModel;
    }

    /**
     * @param $locationId
     * @return static|null
     */
    public static function getById($locationId)
    {
        $model = MobileFoodModel::where('locationid', $locationId)->first();
        if (!$model) {
            throw new ApiException(SystemError::DATA_NO_FOUND[0], SystemError::DATA_NO_FOUND[1]);
        }
        return new static($model);
    }

    /**
     * Initialize a new data
     * @return static
     */
    public static function create()
    {
        $mobile = new MobileFoodModel();
        return new static($mobile);
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address)
    {
        $this->mobileFoodModel->Address   = $address;
        $coordinate    = GoogleGeo::getCoordinateByAddress($address);
        $this->mobileFoodModel->latitude  = $coordinate['latitude'] ?? 0;
        $this->mobileFoodModel->longitude = $coordinate['longitude'] ?? 0;
        $this->mobileFoodModel->location  = "({$coordinate['latitude']}, {$coordinate['longitude']})";
        return $this;
    }


    /**
     * @param $mobileFoodData
     * @return bool
     */
    public function saveMobileFood(array $mobileFoodData = []) : bool
    {
        return $this->mobileFoodModel->fill($mobileFoodData)->save();
    }

    /**
     * @param $latitude
     * @param $longitude
     * @param $kiloMeter
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getNearbyMobileFood($latitude, $longitude, $kiloMeter)
    {
        $query = MobileFoodModel::query();
        $query->selectRaw(" a.*,
        (
        6371 * acos(
        cos( radians( a.latitude ) ) * cos( radians( $latitude ) ) * cos(
          radians( $longitude ) - radians( a.longitude )
      ) + sin( radians( a.latitude ) ) * sin( radians( $latitude ) )
        )
        ) AS distance");
        $query->fromRaw("Mobile_Food_Facility_Permit as a")
            ->having('distance', '<=', $kiloMeter);
        return $query->get();
    }
}
