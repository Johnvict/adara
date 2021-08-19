<?php

namespace App\Traits;

trait ResponseFormats
{
	public static $statusCodes = [
		"0000" => ["type" => "data", "status" => "OK",  "code" => "00", "message" => "successful"],
		"0001" => ["type" => "data", "status" => "OK",  "code" => "01", "message" => "successful, will be processed later"],
		"0002" => ["type" => "error", "status" => "FAIL",  "code" => "02", "message" => "request failed"],
		"0003" => ["type" => "data", "status" => "CREATED",  "code" => "03", "message" => "successfully created"],
		"0004" => ["type" => "error", "status" => "FAIL",  "code" => "04", "message" => "system error"],
		"0005" => ["type" => "error", "status" => "FAIL",  "code" => "05", "message" => "unauthorized access"],
		"0006" => ["type" => "error", "status" => "FAIL",  "code" => "06", "message" => "record not found"],
		"0007" => ["type" => "error", "status" => "FAIL",  "code" => "07", "message" => "invalid username or password"],
	];

	public static function formatResponse(array $status, $data = null, $message = null)
	{
		$response = [
			"status" => $status["status"],
			"code" => $status["code"],
			"message" => $message ?? $status["message"]
		];
		if ($data) $response[$status["type"]] = $data;
		return $response;
	}

	/**
	 * @param Array_Object $data	The data to be sent with the response
	 */
	public static function returnSuccess($data = null)
	{
		return response()->json(self::formatResponse(self::$statusCodes["0000"], $data, $data == null ? 'Successfull' : null), 200);
	}

	public static function returnSuccessLater($data)
	{
		return response()->json(self::formatResponse(self::$statusCodes["0001"], $data), 200);
	}
	public static function returnFailed($message = null)
	{
		return response()->json(self::formatResponse(self::$statusCodes["0002"], null, $message), 200);
	}

	public static function returnCreatedSuccessfully($data)
	{
		return response()->json(self::formatResponse(self::$statusCodes["0003"], $data), 200);
	}
	public static function returnSystemFailure($data = null)
	{
		return response()->json(self::formatResponse(self::$statusCodes["0004"], $data), 200);
	}
	public static function returnUnauthorized($message = null)
	{
		return response()->json(self::formatResponse(self::$statusCodes["0005"], null, $message), 200);
	}
	public static function returnNotFound($message = null)
	{
		return response()->json(self::formatResponse(self::$statusCodes["0006"], null, $message), 200);
	}
	public static function returnInvalidUsernamePassword($data = null)
	{
		return response()->json(self::formatResponse(self::$statusCodes["0007"], $data), 200);
	}
}
