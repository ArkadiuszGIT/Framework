<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
//class Items extends \Core\Controller
class Addexpense extends Authenticated
{

    /**
     * Require the user to be authenticated before giving access to all methods in the controller
     *
     * @return void
     */

    protected function before()
    {
		parent::before();
		$this->category = Expense::getUsersExpenseCategory();
		$this->payment = Expense::getUsersExpensePaymentMethod();
    }
	
	public function createAction()
    {
        $expense = new Expense($_POST);

        if ($expense->save()) {
			
			Flash::addMessage('Sukces! Wydatek został poprawnie dodany!');
			
			$this->redirect('/Addexpense/expense');

        } else {

            View::renderTemplate('expense/expense.html', [
				'expense' => $expense,
                'user' => $this->user,
				'category' => $this->category,
				'payment' => $this->payment
            ]);

        }
    }
	
    /**
     * Items index
     *
     * @return void
     */
    public function expenseAction()
    {
        View::renderTemplate('expense/expense.html', [
            'user' => $this->user,
			'category' => $this->category,
			'payment' => $this->payment
        ]);
    }
}
