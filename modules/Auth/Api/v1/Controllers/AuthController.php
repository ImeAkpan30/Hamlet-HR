<?php


namespace Hamlet\Modules\Auth\Api\v1\Controllers;


use Hamlet\Modules\BaseController;

class AuthController extends BaseController
{

    public function __construct()
    {
    }

    public function index(){
        return $this->success("Hamlet Authentication home");

    }

}
