<?php


class Semaphore {

  protected $APIKEY = '948f6a79137287f09b5343abc08c8509';
  protected $SENDER_NAME = 'SEMAPHORE';

  public function sendMessage($numberArray, $message) {
    $ch = curl_init();
    $parameters = array(
        'apikey' => $this->getApiKey(),
        'number' => implode(',', $numberArray),
        'message' => $message,
        'sendername' => $this->getSenderName()
    );
    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
    curl_setopt( $ch, CURLOPT_POST, 1 );

    //Send the parameters set above with the request
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

    // Receive response from server
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec( $ch );
    curl_close ($ch);

    //Show the server response
    return $output;
  }

  public function getApiKey() {
    return $this->APIKEY;
  }

  public function getSenderName() {
    return $this->SENDER_NAME;
  }

}
