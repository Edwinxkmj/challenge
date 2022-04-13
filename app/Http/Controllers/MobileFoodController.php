<?php

namespace App\Http\Controllers;

use App\Service\MobileFoodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Consts\SystemError;

class MobileFoodController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function addMobileFood(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'     => 'required',
            'cnn'         => 'required',
            'locationDescription' => 'required',
            'expiredDate' => 'required',
            'applicant'   => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseData([], SystemError::VALIDATOR_ERROR_CODE, $validator->errors()->first());
        }

        $address  = $request->input('address');
        $saveData = [
            'cnn'                 => $request->input('cnn'),
            'LocationDescription' => $request->input('locationDescription'),
            'Zip Codes'           => $request->input('zipCode'),
            'ExpirationDate'      => $request->input('expiredDate'),
            'Applicant'           => $request->input('applicant'),
        ];
        if (!MobileFoodService::create()->setAddress($address)->saveMobileFood($saveData)) {
            $this->responseData([], SystemError::DATA_SAVE_ERROR[1], SystemError::DATA_SAVE_ERROR[0]);
        }

        return $this->responseData();
    }

    /**
     * @param Request $request
     * @return array
     * @throws \App\Exceptions\ApiException
     */
    public function changeAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'   => 'required',
            'id'        => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseData([], SystemError::VALIDATOR_ERROR_CODE, $validator->errors()->first());
        }

        $id      = $request->input('id');
        $address = $request->input('address');
        if (!MobileFoodService::getById($id)->setAddress($address)->saveMobileFood()) {
            $this->responseData([], SystemError::DATA_SAVE_ERROR[1], SystemError::DATA_SAVE_ERROR[0]);
        }
        return $this->responseData();
    }

    /**
     * Search for mobile food within 1 kilometer
     * @param Request $request
     * @return array
     */
    public function getNearbyMobileFoods(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude'   => 'required',
            'longitude'  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseData([], SystemError::VALIDATOR_ERROR_CODE, $validator->errors()->first());
        }

        $latitude       = $request->input('latitude');
        $longitude      = $request->input('longitude');
        $mobileFoodList = MobileFoodService::getNearbyMobileFood($latitude, $longitude, 1);
        $data           = [];
        foreach ($mobileFoodList as $mobileFood) {
            $data[] = [
                'locationId'  => $mobileFood->locationid,
                'address'     => $mobileFood->Address,
                'applicant' => $mobileFood->Applicant,
            ];
        }
        return $this->responseData($data);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \App\Exceptions\ApiException
     */
    public function getMobileFoodDetail(Request $request)
    {
        $id         = $request->input('id');
        $mobileFood = MobileFoodService::getById($id)->mobileFoodModel;
        $info       = [
            'address'     => $mobileFood->Address,
            'foodItems'   => $mobileFood->FoodItems,
            'locationDes' => $mobileFood->LocationDescription,
            'status'      => $mobileFood->Status,
            'dayHours'    => $mobileFood->dayshours,
        ];
        return $this->responseData($info);
    }
}
