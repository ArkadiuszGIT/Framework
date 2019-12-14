<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
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
		$this->incomeCatSum = Balance::getUsersIncomesCategorySum();
		$this->incomeSum = Balance::getUsersIncomesSum();
		$this->income = Balance::getUsersIncomes();
		$this->expenseCatSum = Balance::getUsersExpensesCategorySum();
		$this->expenseSum = Balance::getUsersExpensesSum();
		$this->expense = Balance::getUsersExpenses();
		$this->expenseChart = Balance::getExpensesChart();
    }
    /**
     * Items index
     *
     * @return void
     */
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
