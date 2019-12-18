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

    /**
     * Require the user to be authenticated before giving access to all methods in the controller
     *
     * @return void
     */

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
    /**
     * Items index
     *
     * @return void
     */
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
