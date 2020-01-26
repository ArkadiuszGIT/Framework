<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;

class Settingsexpense extends Authenticated
{
	protected function before()
    {
        parent::before();
    }
	
	public function showExpenseCategoryAction()
    {
		$this->category = Expense::getUsersExpenseCategory();
		
		 View::renderTemplate('Settings/show_expense_categories.html', [
			'user' => $this->user,
            'category' => $this->category
        ]);
		
    }
	
	public function showLimitAction()
    {
			$this->category = Expense::findByCategoryName($_POST['categoryName']);
			$this->categorySum = Expense::getUsersExpensesCategorySum($_POST['expenseDate'], $_POST['categoryName']);
			$this->amount = $_POST['expense'];

			$this->difference = $this->category->expenseLimit - $this->categorySum[0];
			$this->difference = -$this->difference;
			$this->expenseSum = $this->categorySum[0] - $this->amount;
			
		if ($this->category->expenseLimit != 0)
		{	
			if( $this->expenseSum  >= $this->category->expenseLimit)
			{
				View::renderTemplate('expense/show_limit_success.html', [
					'user' => $this->user,
					'category' => $this->category,
					'categorySum' => $this->categorySum,
					'difference' => $this->difference,
					'expenseSum' => $this->expenseSum
				]);
				
			}else{
				
				View::renderTemplate('expense/show_limit_danger.html', [
					'user' => $this->user,
					'category' => $this->category,
					'categorySum' => $this->categorySum,
					'difference' => $this->difference,
					'expenseSum' => $this->expenseSum
				]);
			}
		}else{			
			View::renderTemplate('expense/show_none_limit.html');		
		}
    }
	
	public function showPaymentMethodsAction()
    {
		$this->payment = Expense::getUsersExpensePaymentMethod();
		
		 View::renderTemplate('Settings/show_payment_methods.html', [
			'user' => $this->user,
            'payment' => $this->payment
        ]);
		
    }
	
	public function deleteExpenseCategoryAction()
    {	

		if (Expense::deleteUserCategory($_POST['deleteExpenseCategory'])) {
			
			Flash::addMessage('Sukces! Kategoria została poprawnie usunięta!');		

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć kategorii', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
                'user' => $this->user
            ]);

        }
		
    }
	
	public function validateExpenseCategoryAction()
    {
        $is_valid = ! Expense::categoryNameExists($_GET['categoryName'], $_GET['ignore_id'] ?? null);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
	
	public function addExpenseCategoryAction()
    {
        $expense = new Expense($_POST);

        if ($expense->saveNewCategory()) {
			
			Flash::addMessage('Sukces! Nazwa kategorii została poprawnie dodana!');		

        } else {
			
			Flash::addMessage('Niestety! Nie udało się dodać kategorii', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
				'expense' => $expense,
                'user' => $this->user
            ]);

        }
    }

    public function updateExpenseCategoryAction()
    {
		$expense = new Expense($_POST);
		 
        if ($expense->updateCategory()) {

            Flash::addMessage('Zmiany zapisane!');

        } else {
			
			Flash::addMessage('Niestety! Nie udało się edytować kategorii', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
                'expense' => $expense,
                'user' => $this->user
            ]);

        }
    }
	
	public function modalSuccessAction()
    {	
		View::renderTemplate('Settings/expense_success.html');		
    }
	
	public function deletePaymentMethodAction()
    {	

		if (Expense::deleteUserPaymentMethod($_POST['deletePaymentMethod'])) {
			
			Flash::addMessage('Sukces! Metoda płątności została poprawnie usunięta!');		

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć metody płatności', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
                'user' => $this->user
            ]);

        }
		
    }
	
	public function validatePaymentMethodAction()
    {
        $is_valid = ! Expense::methodNameExists($_GET['methodName'], $_GET['ignore_id'] ?? null);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
	
	public function addPaymentMethodAction()
    {
        $expense = new Expense($_POST);

        if ($expense->saveNewPaymentMethod()) {
			
			Flash::addMessage('Sukces! Nazwa metody płatności została poprawnie dodana!');		

        } else {
			
			Flash::addMessage('Niestety! Nie udało się dodać metody płatności', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
				'expense' => $expense,
                'user' => $this->user
            ]);

        }
    }

    public function updatePaymentMethodAction()
    {
		$expense = new Expense($_POST);
		 
        if ($expense->updatePaymentMethod()) {

            Flash::addMessage('Zmiany zapisane!');

        } else {
			
			Flash::addMessage('Niestety! Nie udało się edytować metody płatności', Flash::WARNING);		
			
            View::renderTemplate('Settings/index.html', [
                'expense' => $expense,
                'user' => $this->user
            ]);

        }
    }
	
	public function modalPaymentSuccessAction()
    {	
		View::renderTemplate('Settings/payment_success.html');		
    }
}
