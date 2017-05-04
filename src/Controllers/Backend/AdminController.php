<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

class AdminController extends Controller
{
    public function index($request, $response, $args)
    {
        return $this->render($response, 'admin/index.html');
    }
}