<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $_request;
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }
    /**
     * @param $data
     * @param $code
     * @param $msg
     * @return array
     */
    public function responseData($data = [], $code = 0, $msg = 'success')
    {
        return response()->json([
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ]);
    }
}
