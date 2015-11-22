<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\Role;
use Rea\Transformers\RoleTransformer;
use Rea\Validators\CreateRoleValidator;
use Rea\Validators\UpdateRoleValidator;

class RoleController extends ApiController
{
    protected $roleTransformer;
    protected $updateRoleValidator;
    protected $createRoleValidator;

    public function __construct(
        RoleTransformer $roleTransformer,
        UpdateRoleValidator $updateRoleValidator,
        CreateRoleValidator $createRoleValidator)
    {
        $this->roleTransformer = $roleTransformer;
        $this->createRoleValidator = $createRoleValidator;
        $this->updateRoleValidator = $updateRoleValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return $this->respondOk($this->roleTransformer->transformCollection($roles));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Input::all();
        $isValid = $this->createRoleValidator->with($data)->passes();
        if($isValid)
        {
            $role = Role::create($data);
            return $this->respondCreated($this->roleTransformer->transform($role), 'Role Created');
        }
        else
            return $this->respondUnprocessable('Invalid fields');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        if(!$role)
        {
            return $this->respondNotFound('Role not found');
        }
        return $this->respondOk($this->roleTransformer->transform($role));
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
        $role = Role::find($id);
        if(!$role)
            return $this->respondNotFound('Role not found');
        else
        {
            $isValid = $this->updateRoleValidator->with(Input::all())->passes();
            if($isValid)
            {
                $role->fill(Input::all())->save();
                return $this->respondOk(null, 'Role updated');
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
        $role = Role::find($id);
        if(!$role)
            return $this->respondNotFound('Role not found');
        else
        {
            $role->delete();
            return $this->respondOk(null, 'Role deleted');
        }
    }
}
