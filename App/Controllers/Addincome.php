<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\Income;
use \App\Flash;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
//class Items extends \Core\Controller
class Addincome extends Authenticated
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
		$this->category = Income::getUsersIncomeCategory();
    }
	
	public function createAction()
    {
        $income = new Income($_POST);

        if ($income->save()) {
			
			Flash::addMessage('Sukces! Przychód został poprawnie dodany!');
			
			$this->redirect('/Addincome/income');

        } else {

            View::renderTemplate('income/income.html', [
				'income' => $income,
                'user' => $this->user,
				'category' => $this->category
            ]);

        }
    }
	
    /**
     * Items index
     *
     * @return void
     */
    public function incomeAction()
    {
        View::renderTemplate('income/income.html', [
            'user' => $this->user,
			'category' => $this->category
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
