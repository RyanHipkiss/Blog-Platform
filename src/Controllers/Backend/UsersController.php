<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;
use App\Manager\UserManager;
use App\Manager\RoleManager;
use App\Service\Redirect;
use App\Service\Session;

class UsersController extends Controller
{
    protected $userManager;

    public function __construct(UserManager $userManager, RoleManager $roleManager)
    {
        $this->userManager = $userManager;
        $this->roleManager = $roleManager;
    }

    public function show($request, $response, $args) 
    {
        $users = $this->userManager->findAll();
        
        return $this->render(
            $response, 
            'admin/user/listing.html', 
            ['users' => $users, 'notify' => Session::getNotify()]
        );
    }

    public function view($request, $response, $args) 
    {
        $roles = $this->roleManager->findAll();

        if(!empty($args['id'])) {
            $user = $this->userManager->findById($args['id']);
            
            return $this->render(
                $response,
                'admin/user/single.html',
                ['user' => $user, 'roles' => $roles, 'notify' => Session::getNotify()]
            );
        }

        return $this->render($response, 'admin/user/single.html', ['roles' => $roles]);
    }

    public function delete($request, $response, $args) 
    {
        $deleted = $this->userManager->delete($args['id']);

        return Redirect::route('admin.users', null, $deleted);
    }

    public function edit($request, $response, $args) 
    {
        $input = $request->getParsedBody();
        $notify = $this->userManager->register($input, (!empty($args['id'])) ? $args['id'] : null);
        
        if('error' == $notify['status']) {
            return $this->render(
                $response,
                'admin/user/single.html',
                ['notify' => $notify]
            );
        }

        return Redirect::route('admin.user', $notify, $notify);
    }
}