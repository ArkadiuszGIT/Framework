<?php

namespace App\Models;

use PDO;
use \Core\View;

/**
 * User model
 *
 * PHP version 7.0
 */
class Balance extends \Core\Model
{
	public static function getUsersIncomes()
    {
		$sql = 'SELECT inc.dateOfIncome, inc.amount, inc.incomeComment, incat.name FROM incomes inc INNER JOIN incomes_category_assigned_to_users incat ON inc.incomeCategoryAssignedToUserID = incat.incomeCategoryAssignedToUserID WHERE inc.userID = :id AND inc.dateOfIncome >= :firstday AND inc.dateOfIncome <= :lastday ORDER BY inc.dateOfIncome DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':firstday', date("Y-m-01"), PDO::PARAM_STR);
		$stmt->bindValue(':lastday', date("Y-m-31"), PDO::PARAM_STR);
		
        $stmt->execute();
		
		$incomes = $stmt->fetchAll();
		//echo date("Y-n-j",strtotime("-1 month"));
		return $incomes;
	
    }
	public static function getUsersIncomesCategorySum()
    {
		$sql = 'SELECT incat.name, SUM(inc.amount) FROM incomes inc INNER JOIN incomes_category_assigned_to_users incat ON inc.incomeCategoryAssignedToUserID = incat.incomeCategoryAssignedToUserID WHERE inc.userID = :id AND inc.dateOfIncome >= :firstday AND inc.dateOfIncome <= :lastday GROUP BY incat.name';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':firstday', date("Y-m-01"), PDO::PARAM_STR);
		$stmt->bindValue(':lastday', date("Y-m-31"), PDO::PARAM_STR);
		
        $stmt->execute();

		$incomesCatSum = $stmt->fetchAll();
		
		//echo date("Y-n-j",strtotime("-1 month"));
		return $incomesCatSum;	
    }
	
	public static function getUsersIncomesSum()
    {
		$sql = 'SELECT SUM(amount) FROM incomes WHERE userID = :id AND dateOfIncome >= :firstday AND dateOfIncome <= :lastday';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':firstday', date("Y-m-01"), PDO::PARAM_STR);
		$stmt->bindValue(':lastday', date("Y-m-31"), PDO::PARAM_STR);
		
        $stmt->execute();
		
		$incomesSum = $stmt->fetchAll();
		//echo date("Y-n-j",strtotime("-1 month"));
		return $incomesSum;	
    }

	
	
	public static function getUsersExpenses()
    {
		$sql = 'SELECT exp.dateOfExpense, exp.amount, exp.expenseComment, expcat.name, expmet.name AS name2 FROM expenses exp INNER JOIN expenses_category_assigned_to_users expcat ON exp.expenseCategoryAssignedToUserID = expcat.expenseCategoryAssignedToUserID INNER JOIN payment_methods_assigned_to_users expmet ON exp.paymentMethodAssignedToUserID = expmet.paymentMethodAssignedToUserID
		WHERE exp.userID = :id AND exp.dateOfExpense >= :firstday AND exp.dateOfExpense <= :lastday  ORDER BY exp.dateOfExpense DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':firstday', date("Y-m-01"), PDO::PARAM_STR);
		$stmt->bindValue(':lastday', date("Y-m-31"), PDO::PARAM_STR);
		
        $stmt->execute();
		
		$expenses = $stmt->fetchAll();
		//echo date("Y-n-j",strtotime("-1 month"));
		return $expenses;
	
    }
	public static function getUsersExpensesCategorySum()
    {
		$sql = 'SELECT expcat.name, SUM(exp.amount) FROM expenses exp INNER JOIN expenses_category_assigned_to_users expcat ON exp.expenseCategoryAssignedToUserID = expcat.expenseCategoryAssignedToUserID WHERE exp.userID = :id AND exp.dateOfExpense >= :firstday AND exp.dateOfExpense <= :lastday GROUP BY expcat.name';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':firstday', date("Y-m-01"), PDO::PARAM_STR);
		$stmt->bindValue(':lastday', date("Y-m-31"), PDO::PARAM_STR);
		
        $stmt->execute();

		$expensesCatSum = $stmt->fetchAll();
		
		//echo date("Y-n-j",strtotime("-1 month"));
		return $expensesCatSum;	
    }
	
	public static function getUsersExpensesSum()
    {
		$sql = 'SELECT SUM(amount) FROM expenses WHERE userID = :id AND dateOfExpense >= :firstday AND dateOfExpense <= :lastday';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':firstday', date("Y-m-01"), PDO::PARAM_STR);
		$stmt->bindValue(':lastday', date("Y-m-31"), PDO::PARAM_STR);
		
        $stmt->execute();
		
		$expensesSum = $stmt->fetchAll();
		//echo date("Y-n-j",strtotime("-1 month"));
		return $expensesSum;	
    }
	
	public static function getExpensesChart()
    {
		$sql = 'SELECT expcat.name, SUM(exp.amount) FROM expenses exp INNER JOIN expenses_category_assigned_to_users expcat ON exp.expenseCategoryAssignedToUserID = expcat.expenseCategoryAssignedToUserID WHERE exp.userID = :id AND exp.dateOfExpense >= :firstday AND exp.dateOfExpense <= :lastday GROUP BY expcat.name';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':firstday', date("Y-m-01"), PDO::PARAM_STR);
		$stmt->bindValue(':lastday', date("Y-m-31"), PDO::PARAM_STR);
		
        $stmt->execute();

		$expensesChart = $stmt->fetchAll();
		
		//echo date("Y-n-j",strtotime("-1 month"));
		return $expensesChart;	
    }
	
	
}
