<?php

namespace App\Controllers\Auth;

use App\Manager\UserManager;
use App\Service\Redirect;
use App\Controllers\Controller;

class AuthController extends Controller
{
	protected $userManager;

	private $redirectPath = '/admin';

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
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

		if(true === $logged) {
			return Redirect::to($this->redirectPath);
		}

		return $this->render($response, 'auth/login.html', ['message' => $logged]);	
	}

	public function logout($request, $response)
	{
		$logout = $this->userManager->logout();

		return Redirect::to('/');
	}
}
