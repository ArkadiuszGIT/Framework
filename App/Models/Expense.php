<?php

namespace App\Models;

use PDO;
use \Core\View;

/**
 * User model
 *
 * PHP version 7.0
 */
class Expense extends \Core\Model
{

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];
	public $category = [];
	public $payment= [];
	
	 public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function save()
    {
        $this->validate();
		$expenseCategory =  $this->getExpenseCategoryID();
		$paymentMethod =  $this->getExpensePaymentID();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO expenses VALUES (NULL, :id, :categoryID, :paymentID, :expense, :date, :komentarz )';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':categoryID', $expenseCategory->expenseCategoryAssignedToUserID, PDO::PARAM_INT);
			$stmt->bindValue(':paymentID', $paymentMethod->paymentMethodAssignedToUserID, PDO::PARAM_INT);
			$stmt->bindValue(':expense', strval($this->expense), PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->expenseDate, PDO::PARAM_STR);
			$stmt->bindValue(':komentarz', $this->komentarz, PDO::PARAM_STR);
			
            return $stmt->execute();
        }

        return false;
    }

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    public function validate()
    {
        // Expense
        if ($this->expense == '') {
            $this->errors[] = 'Podaj wydatek!';
        }
		if ($this->expense==0)
		{
			$this->errors[]="Wydatek musi być różny od 0!";
		}
		if ($this->expense>0)
		{
			$this->expense = -$this->expense;
		}
    }
	
	public function getExpenseCategoryID()
    {
        $sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE name=:kategoria
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $this->kategoria, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();
		
    }
	
	public static function getUsersExpenseCategory()
    {
        $sql = 'SELECT name FROM expenses_category_assigned_to_users WHERE userID = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
		
		$category = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
		return $category;
		
		/*foreach($stmt as $result) {
			echo $result['name'], '<br>';
		}*/
	
    }
	
	public function getExpensePaymentID()
    {
        $sql = 'SELECT * FROM payment_methods_assigned_to_users WHERE name=:payment
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':payment', $this->payment, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();
		
    }
	
	public static function getUsersExpensePaymentMethod()
    {
        $sql = 'SELECT name FROM payment_methods_assigned_to_users WHERE userID = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
		
		$paymentMethod = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
		return $paymentMethod;
		
		/*foreach($stmt as $result) {
			echo $result['name'], '<br>';
		}*/
	
    }
	
}
