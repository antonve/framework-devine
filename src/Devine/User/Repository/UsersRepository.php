<?php

// UsersRepository.php - 
// By Anton Van Eechaute

namespace Devine\User\Repository;

use Devine\Framework\SingletonPDO;
use Devine\User\Model\User;

class UsersRepository
{
    /**
     * @var PDO ¬†
     */
    private $dbh;
    
    /**
     * Initializes a products repository ¬†
     */
    public function __construct()
    {
        $this->dbh = SingletonPDO::getInstance();
    }
    
    /**
     * Saves the user to the database, upgrade if not set
     * @param User $user
     * @return \Devine\User\Model\User ¬†
     */
    public function saveUser(User $user)
    {
        if (null === $user->getId()) { // insert new user
            $stmt = $this->dbh->prepare("INSERT INTO users (username, email, first_name, last_name, date_created, password, salt)
                                         VALUES (:username, :email, :first_name, :last_name, NOW(), :password, :salt)");
            
            $data = array('username' => $user->getUsername(),
                           'email' => $user->getEmail(),
                           'first_name' => $user->getFirstName(),
                           'last_name' => $user->getLastName(),
                           'password' => sha1($user->getPassword() . $user->getSalt()),
                           'salt' => $user->getSalt());
            
            $stmt->execute($data);
            
            if (1 === $stmt->rowCount()) {
                $user->setId($this->dbh->lastInsertId());
            } else {
                throw new \Exception('Couldn\'t save user to database');
            }
            
        } else { // update user
            
            $data = array('username' => $user->getUsername(),
                           'email' => $user->getEmail(),
                           'first_name' => $user->getFirstName(),
                           'last_name' => $user->getLastName(),
                           'id' => $user->getId());
            
            $password = '';
            if ('' != $user->getPassword()){
                $password = ',password = :password, salt = :salt ';
                $data['password'] = sha1($user->getPassword() . $user->getSalt());
                $data['salt'] = $user->getSalt();
            }
            $stmt = $this->dbh->prepare("UPDATE users 
                                         SET username = :username, 
                                         email = :email, 
                                         first_name = :first_name, 
                                         last_name = :last_name  
                                         " . $password . "
                                         WHERE id = :id");
            
            $result = $stmt->execute($data);
            
            if (!$result) {
                throw new \Exception('Couldn\'t save user to database');
            } else {
                echo 'saved';
            }
        }
        
        return $user;
    }
    
    /**
     * Checks if an user with the given username already exists
     * @param string $username
     * @return boolean ¬†
     */
    public function isUsernameAvailable($username) 
    {
        $stmt = $this->dbh->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute(array($username));
        
        return (1 === $stmt->rowCount()) ? false : true;
    }
    
    /**
     * Checks if an user and password combination exists and returns an user if it does
     * @param string $username
     * @param string $password
     * @return mixed¬†
     */
    public function checkLogin($username, $password) 
    {
        $stmt = $this->dbh->prepare("SELECT * 
                                     FROM users 
                                     WHERE username = :username 
                                     AND password = sha1(CONCAT(:password,(SELECT salt FROM users WHERE username = :username)))");
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        
        $stmt->execute();
        $data = $stmt->fetch();
        
        return (1 === $stmt->rowCount()) ? new User($data['id'], $data['username'], $data['email'], $data['first_name'], $data['last_name'], $data['date_created']) : false;
    }
    
    /**
     * Checks if password is correct
     * @param string $username
     * @param string $password
     * @return boolean ¬†
     */
    public function checkPassword($username, $password)
    {
        $stmt = $this->dbh->prepare("SELECT id 
                                     FROM users 
                                     WHERE username = :username 
                                     AND password = sha1(CONCAT(:password,(SELECT salt FROM users WHERE username = :username)))");
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        
        $stmt->execute();
        $data = $stmt->fetch();
        
        return (1 === $stmt->rowCount()) ? true : false;
    }
    
    public function addRememberMe($key, $uid)
    {
        $stmt = $this->dbh->prepare('INSERT INTO remember_me (id, user_id, date_created) VALUES (:id, :uid, NOW())');
        $stmt->execute(array('id' => $key, 'uid' => $uid));
    }
    
    /**
     * Tries to get a user by a remember me key
     * @param string $username
     * @param string $password
     * @return mixed¬†
     */
    public function getUserByRememberMe($key) 
    {
        $stmt = $this->dbh->prepare("SELECT users.* 
                                     FROM remember_me 
                                     INNER JOIN users ON (remember_me.user_id = users.id)
                                     WHERE remember_me.id = :key AND DATEDIFF(NOW(), remember_me.date_created) < 30");
        
        $stmt->bindParam(':key', $key);
        
        $stmt->execute();
        $data = $stmt->fetch();
        
        return (1 === $stmt->rowCount()) ? new User($data['id'], $data['username'], $data['email'], $data['first_name'], $data['last_name'], $data['date_created']) : false;
    }
}