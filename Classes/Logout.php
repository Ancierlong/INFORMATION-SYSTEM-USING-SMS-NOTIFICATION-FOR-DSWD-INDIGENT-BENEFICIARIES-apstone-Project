<?php
require_once(dirname(__FILE__) . '/../config/Master.php');
require_once(dirname(__FILE__) . '/SystemDatabaseConfig.php');
class Logout {
    public function processLogout() {
        $actions = 'Log out';
        $page = 'Logout';
        $page_url = 'Logout.php';
        $user_id = $_SESSION['user']['id'];
        $dbConn = (new SystemDatabaseConfig());
        $dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);

        session_destroy();
        header('Location: ' . $this->redirectTo());
    }

    public function redirectTo() {
        return 'login.php';
    }
}
