<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Response;
use Illuminate\Http\Response as HttpResponse;


class SessionController extends Controller
{

    protected $request;
    protected $auth;

    public function __construct(Request $request, JWTAuth $auth)
    {
        $this->request = $request;
        $this->auth = $auth;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
        $credentials = $this->request->only('email', 'password');
        dd($credentials);

        if (!$token = $this->auth->attempt($credentials)) 
        {
            return Response::json(false, HttpResponse::HTTP_UNAUTHORIZED);
        }
        return Response::json(compact('token'));

        /*try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = $this->auth->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }*/

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
