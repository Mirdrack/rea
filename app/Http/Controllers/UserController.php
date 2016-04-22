<?php

namespace Rea\Http\Controllers;

use Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response as HttpResponse;
use Validator;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\Role;
use Rea\Entities\User as User;
use Rea\Transformers\UserTransformer;
use Rea\Validators\UpdateUserValidator;

use Tymon\JWTAuth\JWTAuth;
use Faker\Factory as FakerFactory;

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
        // $action = Route::getCurrentRoute()->getAction();
        $this->auth = $auth;
        $this->userTransformer = $userTransformer;
        $this->updateUserValidator = $updateUserValidator;

        $permissionMiddlewareExceptions = [
            'profile',
            'permissions',
            'changePassword',
            'recoveryPassword',
        ];

        $this->middleware('jwt.auth', ['except' => array('recoveryPassword')]);
        $this->middleware('permission', ['except' => $permissionMiddlewareExceptions]);
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
        $data = Input::only('groups');
        try 
        {
            $user = User::create($credentials);
            if(count($data['groups']) > 0)
            {
                foreach($data['groups'] as $group)
                {
                    // For this case groups means roles
                    $role = Role::find((int) $group);
                    if($role)
                        $user->giveRole($role);
                }
            }
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

    public function giveRole($user, $role)
    {
        $user = User::find($user);
        if(!$user)
            return $this->respondNotFound('User not found');
        else
        {
            $role = Role::find($role);
            if(!$role)
                return $this->respondNotFound('Role not found');
            else
            {
                $user->giveRole($role);
                return $this->respondOk(null, 'Role gived');
            }
        }
    }

    public function retrieveRole($user, $role)
    {
        $user = User::find($user);
        if(!$user)
            return $this->respondNotFound('User not found');
        else
        {
            $role = Role::find($role);
            if(!$role)
                return $this->respondNotFound('Role not found');
            else
            {
                $user->retrieveRole($role);
                return $this->respondOk(null, 'Role retrieved');
            }
        }
    }

    public function permissions()
    {
        $data = Input::only('permissions');
        
        // We get the logged user
        $this->auth->parseToken()->toUser();
        $token = $this->auth->getToken();
        $user = $this->auth->toUser($token);

        // $user = User::find(1);
        if(!$user)
            return $this->respondNotFound('User not found');
        else
        {
            $permissions = $user->checkPermissions($data['permissions']);
            return $this->respondOk($permissions);
        }
    }

    public function changePassword()
    {
        $data = Input::only('password');

        // We get the logged user
        $this->auth->parseToken()->toUser();
        $token = $this->auth->getToken();
        $user = $this->auth->toUser($token);

        if(!$user)
            return $this->respondNotFound('User not found');
        else
        {
            $user->password = $data['password'];
            $user->save();
            return $this->respondOk($user);
        }
    }

    public function recoveryPassword($email)
    {
        $user = User::where('email', $email)->first();
        if(!$user)
            return $this->respondNotFound('User not found');
        else
        {   
            $this->faker = FakerFactory::create('es_ES');
            $newPassword = $this->faker->password;
            $user->password = $newPassword;
            $user->save();

            // Mailing
            Mail::send('emails.password-update', ['user' => $user, 'newPassword' => $newPassword], function ($m) use ($user) 
            {
                $m->from('aitanastudios@gmail.com', 'Sistema de Monitoreo');
                $m->to($user->email)->subject('Nuevo password');
            });

            return $this->respondOk(null, 'An email with the password has been send it');
        }
    }
}
