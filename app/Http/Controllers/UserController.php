<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\User as User;

use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
        //
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
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object['created_at']))
        ];
    }

}
