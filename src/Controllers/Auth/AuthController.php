<?php

namespace App\Controllers\Auth;

use App\Manager\UserManager;
use App\Service\Redirect;
use App\Controllers\Controller;

class AuthController extends Controller
{
	const ADMIN_ROLES = [1];

	protected $userManager;

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	public static function getAdminRoles()
	{
		return self::ADMIN_ROLES;
	}

	public function showRegister($request, $response, $args)
	{
		return $this->render($response, 'auth/register.html');
	}

	public function postRegister($request, $response)
	{
		$input = $request->getParsedBody();
		$registered = $this->userManager->register($input);

		return $this->render($response, 'auth/register.html', ['message' => $registered]);
	}

	public function showLogin($request, $response, $args)
	{
		return $this->render($response, 'auth/login.html');
	}

	public function postLogin($request, $response)
	{
		$input  = $request->getParsedBody();
		$logged = $this->userManager->login($input);

		if('success' === $logged['status']) {

			if(in_array($logged['id'], self::getAdminRoles())) {
				return Redirect::route('admin.index');
			} else {
				return Redirect::route('home');
			}
		}

		return $this->render($response, 'auth/login.html', ['message' => $logged]);	
	}

	public function logout($request, $response)
	{
		$logout = $this->userManager->logout();

		return Redirect::route('index');
	}
}
