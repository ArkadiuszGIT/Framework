<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\BalancePrevious;
use \App\Flash;
/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
//class Items extends \Core\Controller
class Showbalanceprevious extends Authenticated
{
    protected function before()
    {
		parent::before();
		$this->incomeCatSum = BalancePrevious::getUsersIncomesCategorySum();
		$this->incomeSum = BalancePrevious::getUsersIncomesSum();
		$this->income = BalancePrevious::getUsersIncomes();
		$this->expenseCatSum = BalancePrevious::getUsersExpensesCategorySum();
		$this->expenseSum = BalancePrevious::getUsersExpensesSum();
		$this->expense = BalancePrevious::getUsersExpenses();
		$this->expenseChart = BalancePrevious::getExpensesChart();
    }

    public function balanceAction()
    {
        View::renderTemplate('balance/balancePrevious.html', [
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
		if (BalancePrevious::deleteIncome($_POST['incomeID'])) {
			
			Flash::addMessage('Sukces! Przychód został poprawnie usunięty!');

			$this->redirect('/Showbalanceprevious/balance');			

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć przychodu', Flash::WARNING);		
			
            $this->redirect('/Showbalanceprevious/balance');
        }		
    }
	
	public function deleteExpenseAction()
    {	
		if (BalancePrevious::deleteExpense($_POST['expenseID'])) {
			
			Flash::addMessage('Sukces! Wydatek został poprawnie usunięty!');	

			$this->redirect('/Showbalanceprevious/balance');

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć wydatku', Flash::WARNING);		
			
            $this->redirect('/Showbalanceprevious/balance');
        }		
    }
}
