<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\Read;
use Rea\Transformers\ReadTransformer;
use Rea\Validators\CreateReadValidator;

class ReadController extends ApiController
{
    protected $readTransformer;
    protected $createReadValidator;

    public function __construct(
        ReadTransformer $readTransformer,
        CreateReadValidator $createReadValidator)
    {
        $this->readTransformer = $readTransformer;
        $this->createReadValidator = $createReadValidator;
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
        $isValid = $this->createReadValidator->with($data)->passes();
        if($isValid)
        {
            $read = Read::create($data);
            return $this->respondCreated($this->readTransformer->transform($read), 'Read Created');
        }
        else
            return $this->respondUnprocessable('Invalid fields');
    }
}
