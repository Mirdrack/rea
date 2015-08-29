<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Response as HttpResponse;
/*use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;
use Validator;

use Rea\Http\Requests;*/
use Rea\Http\Controllers\Controller;


class ApiController extends Controller
{
    protected $statusCode = 200;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatuscode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(HttpResponse::HTTP_NOT_FOUND)
                    ->respondWithError($message);
    }

    public function respondUnprocessable($message = 'Unprocessable Entity!')
    {
        return $this->setStatuscode(HttpResponse::HTTP_UNPROCESSABLE_ENTITY)
                    ->respondWithError($message);
    }

    public function respondWithError($message)
    {
        $response = [
            'data' => null, 
            'error' => $message, 
            'status_code' => $this->getStatusCode()
        ];
        return $this->respond($response);
    }

    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);   
    }
}
