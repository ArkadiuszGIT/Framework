<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\BalanceCustom;
use \App\Flash;
/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
//class Items extends \Core\Controller
class Showbalancecustom extends Authenticated
{

    protected function before()
    {
		parent::before();
		$balanceCustom = new BalanceCustom($_POST);
		$this->incomeCatSum = $balanceCustom->getUsersIncomesCategorySum();
		$this->incomeSum = $balanceCustom->getUsersIncomesSum();
		$this->income = $balanceCustom->getUsersIncomes();
		$this->expenseCatSum = $balanceCustom->getUsersExpensesCategorySum();
		$this->expenseSum = $balanceCustom->getUsersExpensesSum();
		$this->expense = $balanceCustom->getUsersExpenses();
		$this->expenseChart = $balanceCustom->getExpensesChart();
		$this->firstday = $balanceCustom->getFirstDay();
		$this->lastday = $balanceCustom->getLastDay();
    }

    public function balanceAction()
    {	
        View::renderTemplate('balance/balanceCustom.html', [
			'lastday' => $this->lastday,
			'firstday' => $this->firstday,
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
		$balanceCustom = new BalanceCustom($_POST);
		if ($balanceCustom->deleteIncome()) {
			
			Flash::addMessage('Sukces! Przychód został poprawnie usunięty!');

			$this->incomeCatSum = $balanceCustom->getUsersIncomesCategorySum();
			$this->incomeSum = $balanceCustom->getUsersIncomesSum();
			$this->income = $balanceCustom->getUsersIncomes();
			$this->expenseCatSum = $balanceCustom->getUsersExpensesCategorySum();
			$this->expenseSum = $balanceCustom->getUsersExpensesSum();
			$this->expense = $balanceCustom->getUsersExpenses();
			$this->expenseChart = $balanceCustom->getExpensesChart();
			$this->firstday = $balanceCustom->getFirstDay();
			$this->lastday = $balanceCustom->getLastDay();
		
			View::renderTemplate('balance/balanceCustom.html', [
				'lastday' => $this->lastday,
				'firstday' => $this->firstday,
				'expenseChart' => $this->expenseChart,
				'expenseCatSum' => $this->expenseCatSum,
				'expenseSum' => $this->expenseSum,
				'incomeCatSum' => $this->incomeCatSum,
				'incomeSum' => $this->incomeSum,
				'expense' => $this->expense,
				'income' => $this->income,
				'user' => $this->user,
			]);		

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć przychodu', Flash::WARNING);		
			
            $this->incomeCatSum = $balanceCustom->getUsersIncomesCategorySum();
			$this->incomeSum = $balanceCustom->getUsersIncomesSum();
			$this->income = $balanceCustom->getUsersIncomes();
			$this->expenseCatSum = $balanceCustom->getUsersExpensesCategorySum();
			$this->expenseSum = $balanceCustom->getUsersExpensesSum();
			$this->expense = $balanceCustom->getUsersExpenses();
			$this->expenseChart = $balanceCustom->getExpensesChart();
			$this->firstday = $balanceCustom->getFirstDay();
			$this->lastday = $balanceCustom->getLastDay();
		
			View::renderTemplate('balance/balanceCustom.html', [
				'lastday' => $this->lastday,
				'firstday' => $this->firstday,
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
    }
	
	public function deleteExpenseAction()
    {	
		$balanceCustom = new BalanceCustom($_POST);
		if ($balanceCustom->deleteExpense()) {
			
			Flash::addMessage('Sukces! Wydatek został poprawnie usunięty!');	

			$this->incomeCatSum = $balanceCustom->getUsersIncomesCategorySum();
			$this->incomeSum = $balanceCustom->getUsersIncomesSum();
			$this->income = $balanceCustom->getUsersIncomes();
			$this->expenseCatSum = $balanceCustom->getUsersExpensesCategorySum();
			$this->expenseSum = $balanceCustom->getUsersExpensesSum();
			$this->expense = $balanceCustom->getUsersExpenses();
			$this->expenseChart = $balanceCustom->getExpensesChart();
			$this->firstday = $balanceCustom->getFirstDay();
			$this->lastday = $balanceCustom->getLastDay();
		
			View::renderTemplate('balance/balanceCustom.html', [
				'lastday' => $this->lastday,
				'firstday' => $this->firstday,
				'expenseChart' => $this->expenseChart,
				'expenseCatSum' => $this->expenseCatSum,
				'expenseSum' => $this->expenseSum,
				'incomeCatSum' => $this->incomeCatSum,
				'incomeSum' => $this->incomeSum,
				'expense' => $this->expense,
				'income' => $this->income,
				'user' => $this->user,
			]);		

        } else {
			
			Flash::addMessage('Niestety! Nie udało się usunąć wydatku', Flash::WARNING);		
			
			$this->incomeCatSum = $balanceCustom->getUsersIncomesCategorySum();
			$this->incomeSum = $balanceCustom->getUsersIncomesSum();
			$this->income = $balanceCustom->getUsersIncomes();
			$this->expenseCatSum = $balanceCustom->getUsersExpensesCategorySum();
			$this->expenseSum = $balanceCustom->getUsersExpensesSum();
			$this->expense = $balanceCustom->getUsersExpenses();
			$this->expenseChart = $balanceCustom->getExpensesChart();
			$this->firstday = $balanceCustom->getFirstDay();
			$this->lastday = $balanceCustom->getLastDay();
		
			View::renderTemplate('balance/balanceCustom.html', [
				'lastday' => $this->lastday,
				'firstday' => $this->firstday,
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
    }
}
