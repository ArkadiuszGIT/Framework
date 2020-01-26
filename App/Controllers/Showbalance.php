<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Balance;
use \App\Flash;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
//class Items extends \Core\Controller
class Showbalance extends Authenticated
{
    protected function before()
    {
		parent::before();
		$this->incomeCatSum = Balance::getUsersIncomesCategorySum();
		$this->incomeSum = Balance::getUsersIncomesSum();
		$this->income = Balance::getUsersIncomes();
		$this->expenseCatSum = Balance::getUsersExpensesCategorySum();
		$this->expenseSum = Balance::getUsersExpensesSum();
		$this->expense = Balance::getUsersExpenses();
		$this->expenseChart = Balance::getExpensesChart();
    }

    public function balanceAction()
    {
        View::renderTemplate('balance/balance.html', [
			'expenseChart' => $this->expenseChart,
			'expenseCatSum' => $this->expenseCatSum,
			'expenseSum' => $this->expenseSum,
			'incomeCatSum' => $this->incomeCatSum,
			'incomeSum' => $this->incomeSum,
			'expense' => $this->expense,
			'income' => $this->income,
            'user' => $this->user,
        ]);
    }
	
	public function deleteIncomeAction()
    {	
		if (Balance::deleteIncome($_POST['incomeID'])) {
			
			Flash::addMessage('Sukces! Przychód został poprawnie usunięty!');

			$this->redirect('/showbalance/balance');			

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć przychodu', Flash::WARNING);		
			
            $this->redirect('/showbalance/balance');
        }		
    }
	
	public function deleteExpenseAction()
    {	
		if (Balance::deleteExpense($_POST['expenseID'])) {
			
			Flash::addMessage('Sukces! Wydatek został poprawnie usunięty!');	

			$this->redirect('/showbalance/balance');

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć wydatku', Flash::WARNING);		
			
            $this->redirect('/showbalance/balance');
        }		
    }
	


}
