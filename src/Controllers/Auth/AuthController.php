<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Manager\UserManager;
use App\Service\Redirect;

class AuthController extends BaseController {

	protected $userManager;

	private $redirectPath = '/';

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	public function showRegister() 
	{
		return $this->getTemplateEngine()->render('auth/register.html');
	}

	public function postRegister($request, $response) 
	{
		$input = $request->getParsedBody();
		$registered = $this->userManager->register($input);

		return $this->getTemplateEngine()->render('auth/register.html', ['message' => $registered]);
	}

	public function showLogin()
	{
		return $this->getTemplateEngine()->render('auth/register.html');
	}

	public function postLogin($request, $response)
	{
		$input  = $request->getParsedBody();
		$logged = $this->userManager->login($input);
		
		if(!$logged) {
			$error = [
				'status'  => 'error',
				'message' => 'Details are incorrect.'
			];

			return $this->getTemplateEngine()->render('auth/register.html', ['message' => $error]);
		}

		return Redirect::to($this->redirectPath);
	}
}