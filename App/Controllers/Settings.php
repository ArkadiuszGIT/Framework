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
            'category' => $this->category
        ]);
		
    }
	
	public function showExpenseCategoryAction()
    {
		$this->category = Expense::getUsersExpenseCategory();
		
		 View::renderTemplate('Settings/show_expense_categories.html', [
            'category' => $this->category
        ]);
		
    }
	
	public function showPaymentMethodsAction()
    {
		$this->payment = Expense::getUsersExpensePaymentMethod();
		
		 View::renderTemplate('Settings/show_payment_methods.html', [
            'payment' => $this->payment
        ]);
		
    }
	
	public function showUserSettingsAction()
    {	
		 View::renderTemplate('Settings/show_user_settings.html', [
             'user' => $this->user
        ]);
		
    }
	
	
	
    public function editAction()
    {
        View::renderTemplate('Profile/edit.html', [
            'user' => $this->user
        ]);
    }

    /**
     * Update the profile
     *
     * @return void
     */
    public function updateAction()
    {
        if ($this->user->updateProfile($_POST)) {

            Flash::addMessage('Changes saved');

            $this->redirect('/profile/show');

        } else {

            View::renderTemplate('Profile/edit.html', [
                'user' => $this->user
            ]);

        }
    }
}
