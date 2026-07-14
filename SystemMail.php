<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once(dirname(__FILE__) . '/config/Config.php');
require_once(dirname(__FILE__) . '/tools/PHPMailer-master/src/PHPMailer.php');
require_once(dirname(__FILE__) . '/tools/PHPMailer-master/src/Exception.php');
require_once(dirname(__FILE__) . '/tools/PHPMailer-master/src/SMTP.php');
require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');
require_once(dirname(__FILE__) . '/config/Master.php');


class SystemMail
{

    public $mail;
    public $baseUrl;


    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        // $this->mail->SMTPDebug = 2;
        $this->mail->isSMTP();
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Config::getConfig()['mailer']['username'];
        $this->mail->Password = Config::getConfig()['mailer']['password'];
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port = 465;
    }

    public function send($recipientAddress, $subject, $body)
    {
        try {
            $this->mail->Sender = 'jorganmedi@gmail.com';
            $this->mail->setFrom('jorganmedi@gmail.com', 'BMIS');
            $this->mail->addAddress($recipientAddress);
            $this->mail->isHTML(true);

            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->send();

            return true;
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

    public function sendAccountTemporaryPassword($recipientAddress, $messageDetails)
    {
        $subject = "BMIS: Create Account and Change Password";
        $body = "
          BMIS Account is Created.
          <br><br>

          Follow the steps below to use your account.
          <br><br>
          1. Go Login to http://bmis.000.pe/login.php <br>
          2. Use the credentials below <br><br>
            Email: {$messageDetails['email']} <br>
            Temporary Password: {$messageDetails['password']} <br><br>
          3. Go to My Profile http://bmis.000.pe/my_profile.php Page and change your password. <br><br>

          Thank you!
        ";

        $this->send($recipientAddress, $subject, $body);
    }

    public function sendAccountForgotPassword($recipientAddress, $messageDetails)
    {
        $subject = "BMIS: Forgot Password - Temporary Password";
        $body = "
          It seems that you forgot your password!
          <br><br>

          Follow the steps below to use retreive your account.
          <br><br>
          1. Go Login to http://bmis.000.pe/login.php <br>
          2. Use the credentials below <br><br>
            Email: {$messageDetails['email']} <br>
            Temporary Password: {$messageDetails['password']} <br><br>
          3. Go to My Profile http://bmis.000.pe/my_profile.php Page and change your password. <br><br>

          Thank you!
        ";

        $this->send($recipientAddress, $subject, $body);
    }
}
