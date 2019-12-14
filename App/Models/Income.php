<?php

namespace App\Models;

use PDO;
use \Core\View;

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
	public $category = [];
	
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
	
	public function getIncomeCategoryID()
    {
        $sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE name=:kategoria
					AND userID=:id';
					
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':kategoria', $this->kategoria, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();
		
    }
	
	public static function getUsersIncomeCategory()
    {
        $sql = 'SELECT name FROM incomes_category_assigned_to_users WHERE userID = :id';

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
	
}
