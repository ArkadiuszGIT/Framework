<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
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
    /**
     * Items index
     *
     * @return void
     */
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
