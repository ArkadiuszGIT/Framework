<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class Income extends \Core\Model
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

            $sql = 'INSERT INTO incomes_category_assigned_to_users VALUES (NULL, :id, :kategoria )';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':kategoria', $this->categoryName, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }
	
    public function save()
    {
        $this->validate();
		$incomeCategory =  $this->getIncomeCategoryID();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO incomes VALUES (NULL, :id, :categoryID, :income, :date, :komentarz )';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':categoryID', $incomeCategory->incomeCategoryAssignedToUserID, PDO::PARAM_INT);
			$stmt->bindValue(':income', strval($this->income), PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->incomeDate, PDO::PARAM_STR);
			$stmt->bindValue(':komentarz', $this->komentarz, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }
	
	public function updateCategory()
    {
        $this->validateCategory($this->categoryID);

        if (empty($this->errors)) {

            $sql = 'UPDATE incomes_category_assigned_to_users
                    SET name = :kategoria WHERE userID = :id AND incomeCategoryAssignedToUserID = :categoryID';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

			$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
            $stmt->bindValue(':kategoria', $this->categoryName, PDO::PARAM_STR);
			
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
        // Income
        if ($this->income == '') {
            $this->errors[] = 'Podaj przychód!';
        }
		if (($this->income<0) || ($this->income==0))
		{
			$this->errors[]="Przychód musi być większy od 0!";
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
	
	public function getIncomeCategoryID()
    {
        $sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE name=:kategoria
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $this->categoryName, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();	
    }
	
	public static function getUsersIncomeCategory()
    {
        $sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE userID = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
		
		$category = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
		//echo json_encode($category);
		return $category;
		
		/*foreach($category as $result) {
			echo $result['name'], '<br>';
		}*/	
    }
	
	public static function getIncomeCategoryIdForDelete($categoryName)
    {
		
        $sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE name=:kategoria
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $categoryName, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();	
    }
	
	public static function deleteUserCategory($categoryName)
    {
		$incomeCategory =  Income::getIncomeCategoryIdForDelete($categoryName);
		
        $sql = 'DELETE FROM incomes_category_assigned_to_users WHERE name=:kategoria AND userID=:id;
				  UPDATE incomes AS inc INNER JOIN incomes_category_assigned_to_users AS inccat ON inc.userID = inccat.userID SET inc.incomeCategoryAssignedToUserID = inccat.incomeCategoryAssignedToUserID WHERE inc.userID=:id AND inccat.name="Inne" 
				  AND inc.incomeCategoryAssignedToUserID=:categoryID;';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $categoryName, PDO::PARAM_STR);
		$stmt->bindValue(':categoryID', $incomeCategory->incomeCategoryAssignedToUserID, PDO::PARAM_INT);

        return $stmt->execute();				
    }
	
	public static function categoryNameExists($categoryName, $ignore_id = null)
    {
        $category = static::findByCategoryName($categoryName);
		
        if ($category) {
            if ($category->incomeCategoryAssignedToUserID != $ignore_id) {
                return true;
            }
        }

        return false;
    }
	
	public static function findByCategoryName($categoryName)
    {	
		$sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE name=:kategoria
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $categoryName, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();
    }
					
}
