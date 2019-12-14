<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{
    /**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        $user = new User($_POST);

        if ($user->save() && $user->copyDefaultUserCategories()) {
		
            $user->sendActivationEmail();
			
			Flash::addMessageRegistration('Sukces! Dziękujemy za rejestracje. Sprawdź swój email aby aktywować konto.');
			
			$this->redirect('/Home/index');

        } else {
			
			Flash::addMessageRegistration('Niestety nie udało Ci się zarejestrować, spróbuj jeszcze raz.', Flash::WARNING);

            View::renderTemplate('Home/index.html', [
                'user' => $user
            ]);

        }
    }

    /**
     * Activate a new account
     *
     * @return void
     */
    public function activateAction()
    {
        User::activate($this->route_params['token']);

        $this->redirect('/home/activated');
    }

    /**
     * Show the activation success page
     *
     * @return void
     */
    public function activatedAction()
    {
        View::renderTemplate('Home/activated.html');
    }
}
