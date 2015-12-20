<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\Event;
use Rea\Transformers\EventTransformer;
use Rea\Validators\CreateEventValidator;

class EventController extends ApiController
{
    protected $eventTransformer;
    protected $createEventValidator;

    public function __construct(
        EventTransformer $eventTransformer,
        CreateEventValidator $createEventValidator)
    {
        $this->eventTransformer = $eventTransformer;
        $this->createEventValidator = $createEventValidator;
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
        $isValid = $this->createEventValidator->with($data)->passes();
        if($isValid)
        {
            $event = Event::create($data);
            return $this->respondCreated($this->eventTransformer->transform($event), 'Event Created');
        }
        else
            return $this->respondUnprocessable('Invalid fields');
    }
}
