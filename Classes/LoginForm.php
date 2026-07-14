<?php
require_once(dirname(__FILE__) . '/../config/Master.php');
require_once(dirname(__FILE__) . '/SystemDatabaseConfig.php');
require_once(dirname(__FILE__) . '/Admin.php');
require_once(dirname(__FILE__) . '/Form.php');
require_once(dirname(__FILE__) . '/Password.php');

/**
 * OOP #4: (Interface) Extends
 */
class LoginForm extends Form
{
    use Password;
    public $email;
    public $password;

    public $dbConn;
    public $errors = [];
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->dbConn = (new SystemDatabaseConfig());
        parent::__construct();
    }

    /**
     * OOP #3: Overriding Method from Form
     */
    public function handleSubmit()
    {
        $passedValidation = $this->validate();
        if ($passedValidation == true) {
            if ($this->isUserExist() == true) {
                $userInfo =  $this->getUser()[0];
                if ($userInfo['approval_status'] != 1) {
                    if ($userInfo['approval_status'] == 0) {
                        $this->errors['email'][] = 'Account is Pending for Approval';
                        return false;
                    }

                    if ($userInfo['approval_status'] == 2) {
                        $this->errors['email'][] = 'Account is Rejected';
                        return false;
                    }

                    if ($userInfo['approval_status'] == 3) {
                        $this->errors['email'][] = 'Account is Archived';
                        return false;
                    }
                    $this->errors['email'][] = 'Account is Under Review';
                    return false;
                }

                $isPasswordMatch = $this->verify($this->password, $this->getUser()[0]['password']);
                if ($isPasswordMatch == true) {
                    $customer = new Admin();
                    $customer->setName($userInfo['name']);
                    $customer->setEmail($userInfo['email']);
                    $customer->setId($userInfo['id']);
                    $customer->setContactNo($userInfo['contact_no']);
                    $customer->setRole($userInfo['role']);
                    $_SESSION["user"] = $customer->toArray();
                    $_SESSION["user"]['role-assignment'] = array_column($this->getRoleAssignment($userInfo['role']), 'role_actions_id');
                    $_SESSION["is_logged_in"] = true;

                    $actions = 'Successfully Logged In';
                    $page = 'Login';
                    $page_url = 'Login.php';
                    $user_id = $userInfo['id'];
                    $this->dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);

                    header('Location:' . $this->redirectTo());
                    return true;
                }
                $this->errors['password'][] = 'Incorrect Password';
            } else {
                $this->errors['email'][] = 'Email does not exist';
            }
        }
        $actions = 'Failed Logged In';
        $page = 'Login';
        $page_url = 'Login.php';
        $user_id = 0; // guest
        $this->dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);
        return false;
    }

    protected function validate()
    {

        if ($this->email == '' || is_null($this->email) == true) {
            $this->errors['email'][] = 'Email is required';
        }

        if ((!filter_var($this->email, FILTER_VALIDATE_EMAIL)) == true) {
            $this->errors['email'][] = 'Invalid Email format';
        }

        if ($this->password == '' || is_null($this->email) == true) {
            $this->errors['password'][] = 'Password is required';
        }

        return empty($this->errors)
            ? true
            : false;
    }

    private function isUserExist()
    {
        if (count($this->getUser()) > 0) {
            return true;
        }
        return false;
    }

    private function getUser()
    {
        $query = $this->dbConn->getConnection()
            ->query("SELECT * FROM users WHERE email = '" . $this->email . "' limit 1");
        $result = $query->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    private function getRoleAssignment($role_id)
    {
        $query = $this->dbConn->getConnection()
            ->query("SELECT role_actions_id FROM role_assignments WHERE role_id = '" . $role_id ."'");
        $result = $query->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function redirectTo()
    {
        return 'dashboard.php';
    }
}
