<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceTransformer;
use App\Models\Service;

/**
 * Class ServiceController
 *
 * @package App\Http\Controllers
 */
class ServiceController extends Controller
{

    /**
     * @var Service
     */
    private $service;


    /**
     * Create a new controller instance.
     *
     * @param  Service  $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }


    /**
     * Return the list of services.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ServiceTransformer::collection($this->service->all());
    }


}
