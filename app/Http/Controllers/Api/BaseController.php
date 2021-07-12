<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\CustomEncrypt;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendOtpMail;

class BaseController extends Controller
{
	public function sendResponse($result = [])
	{
		$ecnrypter = new CustomEncrypt();
		return response()->json((request('env') != "local") ? $ecnrypter->encrypt($result) : $result, 200);
	}

	public function sendError($error, $code = 404, $errorMessages = [])
	{
		$response = [
			'message' => $error,
		];

		if(!empty($errorMessages)){
			$response['data'] = $errorMessages;
		}

		return response()->json($response, $code);
	}

	public function sendValidationError($field,$error, $code = 422, $errorMessages = [])
	{
		$response = [
			'errors' => [$field => $error],
			'message' => 'The given data was invalid.',
		];

		if(!empty($errorMessages)){
			$response['data'] = $errorMessages;
		}

		return response()->json($response, $code);
	}

/**
    * Get the guard to be used during authentication.
    *
    * @return \Illuminate\Contracts\Auth\Guard
    */
public function guard()
{
	return Auth::guard('api');
}
}
