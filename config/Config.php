<?php

class Config {
    public static function getConfig() {
        $dbConfig = [
            'db' => [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'database' => 'bmis'
            ],
            'mailer' => [
              'username' => 'jorganmedi@gmail.com', // Your email
              'password' => 'mmohzydtxzvggzru' // Your Password
            ]
        ];

        return $dbConfig;
    }
}
