<?php
require_once(dirname(__FILE__) .'/DatabaseConfig.php');
require_once(dirname(__FILE__) .'/../config/Config.php');

class SystemDatabaseConfig extends DatabaseConfig {

    public $conn;

    private $dbHost;
    private $dbUsername;
    private $dbPassword;
    private $dbDatabase;

    public function __construct(){
        $this->dbHost = Config::getConfig()['db']['host'];
        $this->dbUsername = Config::getConfig()['db']['username'];
        $this->dbPassword = Config::getConfig()['db']['password'];
        $this->dbDatabase = Config::getConfig()['db']['database'];

        parent::__construct($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbDatabase);
    }


    function _addHistoryLog($page, $page_url, $actions, $user_id) {
      $query = $this->getConnection()
        ->query("INSERT INTO history_log (
        `page_name`,
        `page_url`,
        `actions`,
        `user_id`
        )
    VALUES
    ('{$page}', '{$page_url}', '{$actions}',  '{$user_id}')");
    }

}
