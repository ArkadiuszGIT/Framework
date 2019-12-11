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
    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */

    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $token = new Token();
            $hashed_token = $token->getHash();
            $this->activation_token = $token->getValue();

            $sql = 'INSERT INTO users (login, email, password_hash, activation_hash)
                    VALUES (:name, :email, :password_hash, :activation_hash)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

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
        // Name
        if ($this->name == '') {
            $this->errors[] = 'Podaj nazwę użytkownika!';
        }
		if (static::loginExists($this->name, $this->id ?? null)) {
            $this->errors[] = 'Użytkownik o tej nazwie jest już zarejestrowany!';
        }

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Podaj poprawny adres e-mail!';
        }
        if (static::emailExists($this->email, $this->id ?? null)) {
            $this->errors[] = 'Email o tej nazwie jest już zarejestrowany!';
        }

        // Password
        if (isset($this->password)) {

            if (strlen($this->password) < 6) {
                $this->errors[] = 'Hasło musi posiadać od 6 do 20 znaków!';
            }
			
			 if (strlen($this->password) > 20) {
                $this->errors[] = 'Hasło musi posiadać od 6 do 20 znaków!';
            }

            if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
                $this->errors[] = 'Hasło musi zawierać conajmniej jedną literę';
            }

            if (preg_match('/.*\d+.*/i', $this->password) == 0) {
                $this->errors[] = 'Hasło musi zawierać conajmniej jedną cyfrę';
            }

        }
		
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
	

    /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     * @param string $ignore_id Return false anyway if the record found has this ID
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
	public static function loginExists($login, $ignore_id = null)
    {
        $user = static::findByLogin($login);

        if ($user) {
            if ($user->userID != $ignore_id) {
                return true;
            }
        }

        return false;
    }
	public static function findByLogin($login)
    {
        $sql = 'SELECT * FROM users WHERE login = :login';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':login', $login, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function emailExists($email, $ignore_id = null)
    {
        $user = static::findByEmail($email);

        if ($user) {
            if ($user->userID != $ignore_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

}
