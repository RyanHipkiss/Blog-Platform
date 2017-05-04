<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;
use App\Manager\RoleManager;

class RolesController extends Controller
{
    protected $rolesManager;

    public function __construct(RoleManager $roleManager)
    {
        $this->roleManager = $roleManager;
    }

    public function show($request, $response, $args)
    {
        $roles = $this->roleManager->findAll();
        return $this->render($response, 'admin/role/listing.html', ['roles' => $roles]);
    }

    public function view($request, $response, $args)
    {
        if(!empty($args['id'])) {
            $role = $this->roleManager->findById($args['id']);
            return $this->render($response, 'admin/role/single.html', ['role' => $role]);
        }

        return $this->render($response, 'admin/role/single.html');
    }

    public function edit($request, $response, $args)
    {
       $input = $request->getParsedBody();
       $notify = $this->roleManager->save($input, $args['id']);
       //show the message & then the message perhaps?
       return $this->render($response, 'admin/role/single.html', ['notify' => $notify]);
    }
}