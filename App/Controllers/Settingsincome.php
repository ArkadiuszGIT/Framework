<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Flash;

class Settingsincome extends Authenticated
{
	
	protected function before()
    {
        parent::before();
    }
	
	public function showIncomeCategoryAction()
    {
		$this->category = Income::getUsersIncomeCategory();
		
		 View::renderTemplate('Settings/show_income_categories.html', [
			'user' => $this->user,
            'category' => $this->category
        ]);
		
    }
	
	public function deleteIncomeCategoryAction()
    {	

		if (Income::deleteUserCategory($_POST['deleteIncomeCategory'])) {
			
			Flash::addMessage('Sukces! Kategoria została poprawnie usunięta!');	
			
			die;

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć kategorii', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
                'user' => $this->user
            ]);

        }
		
    }
	
	public function validateIncomeCategoryAction()
    {
        $is_valid = ! Income::categoryNameExists($_GET['categoryName'], $_GET['ignore_id'] ?? null);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
	
	public function addIncomeCategoryAction()
    {
        $income = new Income($_POST);

        if ($income->saveNewCategory()) {
			
			Flash::addMessage('Sukces! Nazwa kategorii została poprawnie dodana!');

			die;

        } else {
			
			Flash::addMessage('Niestety! Nie udało się dodać kategorii', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
				'income' => $income,
                'user' => $this->user
            ]);

        }
    }

    public function updateIncomeCategoryAction()
    {
		 $income = new Income($_POST);
		 
        if ($income->updateCategory()) {

            Flash::addMessage('Zmiany zapisane!');
			
			die;

        } else {
			
			Flash::addMessage('Niestety! Nie udało się edytować kategorii', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
                'income' => $income,
                'user' => $this->user
            ]);

        }
    }
	
	public function modalSuccessAction()
    {	
		View::renderTemplate('Settings/income_success.html');		
    }
}
