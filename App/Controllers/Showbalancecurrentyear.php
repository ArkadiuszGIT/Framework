<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\BalanceCurrentYear;
use \App\Flash;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
//class Items extends \Core\Controller
class Showbalancecurrentyear extends Authenticated
{

    /**
     * Require the user to be authenticated before giving access to all methods in the controller
     *
     * @return void
     */

    protected function before()
    {
		parent::before();
        $this->requireLogin();
		$this->user = Auth::getUser();
		$this->incomeCatSum = BalanceCurrentYear::getUsersIncomesCategorySum();
		$this->incomeSum = BalanceCurrentYear::getUsersIncomesSum();
		$this->income = BalanceCurrentYear::getUsersIncomes();
		$this->expenseCatSum = BalanceCurrentYear::getUsersExpensesCategorySum();
		$this->expenseSum = BalanceCurrentYear::getUsersExpensesSum();
		$this->expense = BalanceCurrentYear::getUsersExpenses();
		$this->expenseChart = BalanceCurrentYear::getExpensesChart();
    }
    /**
     * Items index
     *
     * @return void
     */
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

    /**
     * Add a new item
     *
     * @return void
     */
    public function newAction()
    {
        echo "new action";
    }

    /**
     * Show an item
     *
     * @return void
     */
    public function showAction()
    {
        echo "show action";
    }
}
