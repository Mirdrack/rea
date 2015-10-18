<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;

use Rea\Entities\Permission;
use Rea\Transformers\PermissionTransformer;
use Rea\Validators\UpdatePermissionValidator;

class PermissionController extends ApiController
{
    protected $permissionTransformer;
    protected $updatePermissionValidator;

    public function __construct(
        PermissionTransformer $permissionTransformer,
        UpdatePermissionValidator $updatePermissionValidator)
    {
        $this->permissionTransformer = $permissionTransformer;
        $this->updatePermissionValidator = $updatePermissionValidator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return $this->respondOk($this->permissionTransformer->transformCollection($permissions));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);
        if(!$permission)
        {
            return $this->respondNotFound('Permission not found');
        }
        return $this->respondOk($this->permissionTransformer->transform($permission->toArray()));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        if(!$permission)
            return $this->respondNotFound('Permission not found');
        else
        {
            $isValid = $this->updatePermissionValidator->with(Input::all())->passes();
            if($isValid)
            {
                $permission->fill(Input::all())->save();
                return $this->respondOk(null, 'Permission updated');
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
