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
use Rea\Transformers\UserTransformer;

use Tymon\JWTAuth\JWTAuth;

class UserController extends ApiController
{
    private $auth;
    protected $userTransformer;

    public function __construct(JWTAuth $auth, UserTransformer $userTransformer)
    {
        $this->middleware('jwt.auth');
        $this->auth = $auth;
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        $response = ['data' => $this->userTransformer->transformCollection($users), 'error' => null];
        return $this->respondOk($response);
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
            return $this->respondCreated($this->userTransformer->transform($user), 'User Created');
        } 
        catch (QueryException $e) 
        {
            // Maybe this should be wrapped in another method
            return $this->setStatusCode(HttpResponse::HTTP_CONFLICT)
                        ->respondWithError('User already exists.');
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
        return $this->respondOk($this->userTransformer->transform($user->toArray()));
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
            return $this->respondNotFound('User not found');
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
            }
            else
            {
                $user->fill($inptus)->save();
                $response = ['data' => ['message' => 'User updated'], 'error' => null ];
                return $this->respondOk($response);
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
            return $this->respondOk(null, 'User deleted');
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
}
