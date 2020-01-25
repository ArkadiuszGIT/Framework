<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

class Settings extends Authenticated
{

    protected function before()
    {
        parent::before();
    }

    public function indexAction()
    {
        View::renderTemplate('Settings/index.html', [
            'user' => $this->user
        ]);
    }
	
	public function showUserSettingsAction()
    {	
		 View::renderTemplate('Settings/show_user_settings.html', [
             'user' => $this->user
        ]);		
    }
	
	public function updatePasswordAction()
    {
		 
        if ($this->user->updatePassword($_POST)) {

            Flash::addMessage('Hasło zostało zmienione!');

        } else {
			
			Flash::addMessage('Niestety! Nie udało się edytować hasła', Flash::WARNING);		
			
            View::renderTemplate('settings/index.html', [
                'user' => $this->user
            ]);

        }
    }
	public function updateDataAction()
    {
		 
        if ($this->user->updateProfile($_POST)) {

            Flash::addMessage('Zmiany zapisane!');

        } else {
			
			Flash::addMessage('Niestety! Nie udało się edytować profilu', Flash::WARNING);		
			
            View::renderTemplate('settings/index.html', [
                'user' => $this->user
            ]);

        }
    }
	
	public function deleteFinancesAction()
    {	

		if ($this->user->deleteUserFinances()) {
			
			Flash::addMessage('Sukces! Wszystkie przychody i wydatki zostały poprawnie usunięte!');		

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć przychodów i wydatków', Flash::WARNING);		
			
            View::renderTemplate('settings/index.html', [
                'user' => $this->user
            ]);

        }		
    }
	
	public function deleteAccountAction()
    {	

		if ($this->user->deleteUserAccount()) {
			
			Flash::addMessageRegistration('Sukces! Konto zostało poprawnie usunięte!');

			$this->redirect('/home/index');

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć konta', Flash::WARNING);		
			
            View::renderTemplate('settings/index.html', [
                'user' => $this->user
            ]);

        }		
    }
	
	
	public function modalSuccessAction()
    {	
		View::renderTemplate('Settings/user_success.html');		
    }
	
}
