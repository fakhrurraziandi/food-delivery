<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends RestController 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
    }

    public function index_get()
    {
        $users = $this->user->select('*')->findAll();
        $this->response([
            'users' => $users
        ], 200);
    }
}