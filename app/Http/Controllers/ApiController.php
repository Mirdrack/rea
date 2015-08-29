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

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respondOk($data, $message = 'Response Ok')
    {
        $response = [
            'data' => $data,
            'error' => null,
            'status_code' => $this->getStatusCode(),
            'message' => $message
        ];
        return $this->respond($response);
    }

    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(HttpResponse::HTTP_NOT_FOUND)
                    ->respondWithError($message);
    }

    public function respondUnprocessable($message = 'Unprocessable Entity!')
    {
        return $this->setStatusCode(HttpResponse::HTTP_UNPROCESSABLE_ENTITY)
                    ->respondWithError($message);
    }

    public function respondCreated($data, $message = 'Resource Created!')
    {
        $response = [
            'data' => $data,
            'error' => null,
            'status_code' => $this->getStatusCode(),
            'message' => $message
        ];
        return $this->setStatusCode(HttpResponse::HTTP_CREATED)
                    ->respond($response);
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
