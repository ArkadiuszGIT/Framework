<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Log in a user
     *
     * @return void
     */
	public function newAction()
    {
        View::renderTemplate('Home/index.html');
    }
	
    public function createAction()
    {
        $user = User::authenticate($_POST['log'], $_POST['logPassword']);
        
        $remember_me = isset($_POST['remember_me']);

        if ($user) {

            Auth::login($user, $remember_me);

           $this->redirect('/menu/index');

        } else {

            Flash::addMessage('Nieprawidłowy login lub hasło', Flash::WARNING);

            View::renderTemplate('Home/index.html', [
                'log' => $_POST['log'],
                'remember_me' => $remember_me
            ]);
        }
    }

    /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {
        Auth::logout();

        $this->redirect('/login/show-logout-message');
    }

    /**
     * Show a "logged out" flash message and redirect to the homepage. Necessary to use the flash messages
     * as they use the session and at the end of the logout method (destroyAction) the session is destroyed
     * so a new action needs to be called in order to use the session.
     *
     * @return void
     */
    public function showLogoutMessageAction()
    {
        Flash::addMessage('Logout successful');

        $this->redirect('/');
    }
}
