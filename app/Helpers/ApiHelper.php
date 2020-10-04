<?php

namespace App\Helpers;

class ApiHelper {

  public static function buildResponse($success, $statusCode, $data = [], $message = null)
  {
    if ($success) {
      $response = [
        'success' => true,
        'code' => $statusCode,
        'message' => $message,
        'data' => $data,
      ];
    } else {
      $response = [
        'success' => false,
        'code' => $statusCode,
        'message' => $message,
        'errors' => $data,
      ];
    }

    return $response;
  }

}