<?php

namespace App\Models;

use PDO;

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
	public function saveNewCategory()
    {
       $this->validateCategory();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO expenses_category_assigned_to_users VALUES (NULL, :id, :kategoria )';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':kategoria', $this->categoryName, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }
	
	public function saveNewPaymentMethod()
    {
       $this->validatePaymentMethod();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO payment_methods_assigned_to_users VALUES (NULL, :id, :metoda )';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':metoda', $this->methodName, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }
	
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
		
	public function updateCategory()
    {
        $this->validateCategory($this->categoryID);

        if (empty($this->errors)) {

            $sql = 'UPDATE expenses_category_assigned_to_users
                    SET name = :kategoria WHERE userID = :id AND expenseCategoryAssignedToUserID = :categoryID';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

			$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
            $stmt->bindValue(':kategoria', $this->categoryName, PDO::PARAM_STR);
			
            return $stmt->execute();
        }

        return false;
    }
	
	public function updatePaymentMethod()
    {
        $this->validatePaymentMethod($this->methodID);

        if (empty($this->errors)) {

            $sql = 'UPDATE payment_methods_assigned_to_users
                    SET name = :metoda WHERE userID = :id AND paymentMethodAssignedToUserID = :methodID';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

			$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':methodID', $this->methodID, PDO::PARAM_INT);
            $stmt->bindValue(':metoda', $this->methodName, PDO::PARAM_STR);
			
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
		
	public function validateCategory($ignore_id = null)
    {
        if ($this->categoryName == '') {
            $this->errors[] = 'Podaj nazwę kategorii!';
        }
		if (static::categoryNameExists($this->categoryName, $ignore_id)) {
            $this->errors[] = 'Kategoria o tej nazwie już istnieje!';
        }

		if (strlen($this->categoryName) < 3) {
                $this->errors[] = 'Nazwa kategorii musi posiadać od 3 do 20 znaków!';
        }
			
		if (strlen($this->categoryName) > 20) {
                $this->errors[] = 'Nazwa kategorii musi posiadać od 3 do 20 znaków!';
        }

    }
	
	public function validatePaymentMethod($ignore_id = null)
    {
        if ($this->methodName == '') {
            $this->errors[] = 'Podaj nazwę metody płatności!';
        }
		if (static::methodNameExists($this->methodName, $ignore_id)) {
            $this->errors[] = 'Metoda płatności o tej nazwie już istnieje!';
        }

		if (strlen($this->methodName) < 3) {
                $this->errors[] = 'Nazwa metody płatności musi posiadać od 3 do 20 znaków!';
        }
			
		if (strlen($this->methodName) > 20) {
                $this->errors[] = 'Nazwa metody płatności musi posiadać od 3 do 20 znaków!';
        }

    }
	
	public function getExpenseCategoryID()
    {
        $sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE name=:kategoria
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $this->categoryName, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();
		
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
		
	public static function getUsersExpenseCategory()
    {
        $sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE userID = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
		
		$category = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
		return $category;
    }
	
	public static function getUsersExpensePaymentMethod()
    {
        $sql = 'SELECT * FROM payment_methods_assigned_to_users WHERE userID = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
		
		$paymentMethod = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
		return $paymentMethod;
    }
	
	public static function deleteUserCategory($categoryName)
    {
        $sql = 'DELETE FROM expenses_category_assigned_to_users WHERE name=:kategoria
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $categoryName, PDO::PARAM_STR);

        return $stmt->execute();				
    }
	
	public static function deleteUserPaymentMethod($methodName)
    {
        $sql = 'DELETE FROM payment_methods_assigned_to_users WHERE name=:metoda
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':metoda', $methodName, PDO::PARAM_STR);

        return $stmt->execute();				
    }
	
	public static function categoryNameExists($categoryName, $ignore_id = null)
    {
        $category = static::findByCategoryName($categoryName);
		
        if ($category) {
            if ($category->expenseCategoryAssignedToUserID != $ignore_id) {
                return true;
            }
        }

        return false;
    }
	
	public static function methodNameExists($methodName, $ignore_id = null)
    {
        $method = static::findByPaymentMethodName($methodName);
		
        if ($method) {
            if ($method->paymentMethodAssignedToUserID != $ignore_id) {
                return true;
            }
        }

        return false;
    }
	
	public static function findByCategoryName($categoryName)
    {	
		$sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE name=:kategoria
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $categoryName, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();
    }
	
	public static function findByPaymentMethodName($methodName)
    {	
		$sql = 'SELECT * FROM payment_methods_assigned_to_users WHERE name=:metoda
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':metoda', $methodName, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();
    }	
}
