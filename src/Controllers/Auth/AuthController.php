<?php

namespace App\Controllers\Auth;

use App\Manager\UserManager;
use App\Service\Redirect;
use App\Service\TemplateEngine;

class AuthController 
{

	protected $userManager;

	private $redirectPath = '/';

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	public function showRegister() 
	{
		return TemplateEngine::render('auth/register.html');
	}

	public function postRegister($request, $response) 
	{
		$input = $request->getParsedBody();
		$registered = $this->userManager->register($input);

		return TemplateEngine::render('auth/register.html', ['message' => $registered]);
	}

	public function showLogin()
	{
		return TemplateEngine::render('auth/login.html');
	}

	public function postLogin($request, $response)
	{
		$input  = $request->getParsedBody();
		$logged = $this->userManager->login($input);
		
		if(true === $logged) {
			return Redirect::to($this->redirectPath);
		}

		return TemplateEngine::render('auth/login.html', ['message' => $logged]);
	}
}