<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\BalancePrevious;

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
}
