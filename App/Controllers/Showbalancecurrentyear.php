<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\BalanceCurrentYear;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
//class Items extends \Core\Controller
class Showbalancecurrentyear extends Authenticated
{

    protected function before()
    {
		parent::before();
		$this->incomeCatSum = BalanceCurrentYear::getUsersIncomesCategorySum();
		$this->incomeSum = BalanceCurrentYear::getUsersIncomesSum();
		$this->income = BalanceCurrentYear::getUsersIncomes();
		$this->expenseCatSum = BalanceCurrentYear::getUsersExpensesCategorySum();
		$this->expenseSum = BalanceCurrentYear::getUsersExpensesSum();
		$this->expense = BalanceCurrentYear::getUsersExpenses();
		$this->expenseChart = BalanceCurrentYear::getExpensesChart();
    }

    public function balanceAction()
    {
        View::renderTemplate('balance/balanceCurrentYear.html', [
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
