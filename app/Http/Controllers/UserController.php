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
use Rea\Validators\UpdateUserValidator;

use Tymon\JWTAuth\JWTAuth;

class UserController extends ApiController
{
    private $auth;
    protected $userTransformer;
    protected $updateUserValidator;

    public function __construct(
        JWTAuth $auth, 
        UserTransformer $userTransformer,
        UpdateUserValidator $updateUserValidator)
    {
        $this->middleware('jwt.auth');
        $this->auth = $auth;
        $this->userTransformer = $userTransformer;
        $this->updateUserValidator = $updateUserValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return $this->respondOk($this->userTransformer->transformCollection($users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $credentials = Input::only('name', 'email', 'password');
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
        return $this->respondOk($this->userTransformer->transform($user));
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
            $isValid = $this->updateUserValidator->with(Input::all())->passes();
            if($isValid)
            {
                $user->fill(Input::all())->save();
                return $this->respondOk(null, 'User updated');
            }
            else
            {
                return $this->respondUnprocessable('Invalid fields');
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
            return $this->respondNotFound('User not found');
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
            // Temporal... needs to be fixed
            $user = User::find($user->id);
            return $this->respondOk($this->userTransformer->transform($user));
        } 
        catch (Exception $e) 
        {
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }
        return ['data' => $user];
    }
}
