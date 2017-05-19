<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;
use App\Manager\RoleManager;
use App\Service\Redirect;
use App\Service\Session;

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
        return $this->render(
            $response, 
            'admin/role/listing.html', 
            ['roles' => $roles, 'notify' => Session::getNotify()]
        );
    }

    public function view($request, $response, $args)
    {
        if(!empty($args['id'])) {
            $role = $this->roleManager->findById($args['id']);
            return $this->render(
                $response, 
                'admin/role/single.html', 
                ['role' => $role, 'notify' => Session::getNotify()]
            );
        }

        return $this->render($response, 'admin/role/single.html');
    }

    public function edit($request, $response, $args)
    {
        $input = $request->getParsedBody();
        $notify = $this->roleManager->save($input, (!empty($args['id'])) ? $args['id'] : null);

        if('error' == $notify['status']) {
            return $this->render(
                $response, 
                'admin/role/single.html', 
                ['notify' => $notify]
            );
        }

        return Redirect::route('admin.role', $notify, $notify);
    }

    public function delete($request, $response, $args)
    {
        $deleted = $this->roleManager->delete($args['id']);

        return Redirect::route('admin.roles', null, $deleted);
    }
}