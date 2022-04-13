<?php

namespace App\Library;

use App\Exceptions\ApiException;
use App\Consts\SystemError;

class GoogleGeo
{
    /**
     * resolve coordinates
     * @param $address
     * @return string[]
     * @throws ApiException
     */
    public static function getCoordinateByAddress($address)
    {
        try {
            //todo Call the Google API to resolve the coordinates according to the address
        } catch (\Exception $e) {
            throw new ApiException(SystemError::GOOGLE_API_ERROR[0], SystemError::GOOGLE_API_ERROR[1]);
        }
        return [
            'latitude'   => "37.79092150726921",
            'longitude'  => "-122.41594524663745"
        ];
    }
}
