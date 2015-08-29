<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response as HttpResponse;
use Validator;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\User as User;

use Tymon\JWTAuth\JWTAuth;

class UserController extends ApiController
{
    private $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->middleware('jwt.auth');
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        $response = ['data' => $this->transformCollection($users), 'error' => null];
        return response()->json($response, HttpResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $credentials = Input::only('email', 'password');
        try 
        {
            $user = User::create($credentials);
            $response = ['data' => $this->transform($user), 'error' => null];
            return response()->json($response, HttpResponse::HTTP_CREATED);
        } 
        catch (QueryException $e) 
        {
            return response()->json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->respondNotFound('User not found');
        }

        $response = ['data' => $this->transform($user), 'error' => null ];
        return response()->json($response, HttpResponse::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->respondNotFound('User not found');
        }
        else
        {
            $inptus = Input::all();
            $rules = [
                'name' => 'min:3',
                'password' => 'min:6',
                'email' => 'email|unique:users'
            ];
            $validator = Validator::make($inptus, $rules);

            if($validator->fails())
            {
                return $this->respondUnprocessable('Invalid fields');
                /*$response = ['data' => null, 'error' => 'Invalid fields'];
                return response()->json($response, HttpResponse::HTTP_UNPROCESSABLE_ENTITY);*/
            }
            else
            {
                $user->fill($inptus)->save();
                $response = ['data' => ['message' => 'User updated'], 'error' => null ];
                return response()->json($response, HttpResponse::HTTP_OK);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->respondNotFound('User not found');
        }
        else
        {
            $user->delete();
            $response = ['data' => ['message' => 'User delete'], 'error' => null ];
            return response()->json($response, HttpResponse::HTTP_OK);
        }
    }

    public function profile()
    {
        try 
        {
            $this->auth->parseToken()->toUser();
            $token = $this->auth->getToken();
            $user = $this->auth->toUser($token);
        } 
        catch (Exception $e) 
        {
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }
        return ['data' => $user];
    }

    public function transformCollection($collection)
    {
        return array_map([$this, 'transform'], $collection->toArray());
    }

    private function transform($object)
    {
        return [
            'id' => $object['id'],
            'name' => $object['name'],
            'email' => $object['email'],
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object['created_at']))
        ];
    }

}
