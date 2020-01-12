<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Models\Expense;
use \App\Flash;

/**
 * Profile controller
 *
 * PHP version 7.0
 */
class Settings extends Authenticated
{

    /**
     * Before filter - called before each action method
     *
     * @return void
     */
    protected function before()
    {
        parent::before();
    }

    /**
     * Show the profile
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Settings/index.html', [
            'user' => $this->user
        ]);
    }

    /**
     * Show the form for editing the profile
     *
     * @return void
     */
	 
	public function showIncomeCategoryAction()
    {
		$this->category = Income::getUsersIncomeCategory();
		
		 View::renderTemplate('Settings/show_income_categories.html', [
			'user' => $this->user,
            'category' => $this->category
        ]);
		
    }
	
	public function showExpenseCategoryAction()
    {
		$this->category = Expense::getUsersExpenseCategory();
		
		 View::renderTemplate('Settings/show_expense_categories.html', [
			'user' => $this->user,
            'category' => $this->category
        ]);
		
    }
	
	public function showPaymentMethodsAction()
    {
		$this->payment = Expense::getUsersExpensePaymentMethod();
		
		 View::renderTemplate('Settings/show_payment_methods.html', [
			'user' => $this->user,
            'payment' => $this->payment
        ]);
		
    }
	
	public function showUserSettingsAction()
    {	
		 View::renderTemplate('Settings/show_user_settings.html', [
             'user' => $this->user
        ]);		
    }
	
	public function deleteIncomeCategory()
    {	
		Income::deleteUserCategory($_POST['deleteIncomeCategory']);
		
		Flash::addMessage('Sukces! Kategoria została poprawnie usunięta!');		
		
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

        } else {
			
			Flash::addMessage('Niestety! Nie udało się dodać kategorii', Flash::WARNING);		
			
            View::renderTemplate('settings/index.html', [
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

        } else {
			
			Flash::addMessage('Niestety! Nie udało się edytować kategorii', Flash::WARNING);		
			
            View::renderTemplate('settings/index.html', [
                'income' => $income,
                'user' => $this->user
            ]);

        }
    }
	
	public function modalSuccessAction()
    {	
		View::renderTemplate('Settings/success.html');		
    }
}
