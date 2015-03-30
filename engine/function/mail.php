<?php
class Mail {
	protected $_config = false;

	/**
	 * @param  array $config
	 * @access public
	 * @return void
	**/
	public function __construct($config) {
		$this->_config = $config;
	}

	/**
	 * Sets the cache expiration limit (IMPORTANT NOTE: seconds, NOT ms!).
	 *
	 * @param  string $to, string $title, string $text, string $accname
	 * @access public
	 * @return boolean
	**/

	/* * * * * * * * * * * * * * SEND EMAIL FUNCTIONS * * * * * * * * * * * * * */

	//This will send an email using auth smtp and output a log array
	//logArray - connection,

	public function sendMail($to, $title, $text)
	{
		/* * * * CONFIGURATION START * * * */
		$timeout = "30";
		$newLine = "\r\n";
		/* * * * CONFIGURATION END * * * * */

		//Connect to the host on the specified port
		$smtpConnect = fsockopen($this->_config['host'], $this->_config['port'], $errno, $errstr, $timeout);
		$smtpResponse = fgets($smtpConnect, 515);
		if(empty($smtpConnect))
		{
			$output = "Failed to connect: $smtpResponse";
			return $output;
		}
		else
		{
			$logArray['connection'] = "Connected: $smtpResponse";
		}

		//Request Auth Login
		fputs($smtpConnect,"AUTH LOGIN" . $newLine);
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['authrequest'] = "$smtpResponse";

		//Send username
		fputs($smtpConnect, base64_encode($this->_config['username']) . $newLine);
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['authusername'] = "$smtpResponse";

		//Send password
		fputs($smtpConnect, base64_encode($this->_config['password']) . $newLine);
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['authpassword'] = "$smtpResponse";

		//Say Hello to SMTP
		fputs($smtpConnect, "HELO ".$this->_config['host']."" . $newLine);
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['heloresponse'] = "$smtpResponse";

		//Email From
		fputs($smtpConnect, "MAIL FROM: ".$this->_config['username']."" . $newLine);
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['mailfromresponse'] = "$smtpResponse";

		//Email To
		fputs($smtpConnect, "RCPT TO: $to" . $newLine);
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['mailtoresponse'] = "$smtpResponse";

		//The Email
		fputs($smtpConnect, "DATA" . $newLine);
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['data1response'] = "$smtpResponse";

		//Send mail function
		fputs($smtpConnect, "To: $to\nFrom: ".$this->_config['username']."\nSubject: $title\n\n$text\n.\n");
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['data2response'] = "$smtpResponse";

		// Say Bye to SMTP
		fputs($smtpConnect,"QUIT" . $newLine);
		$smtpResponse = fgets($smtpConnect, 515);
		$logArray['quitresponse'] = "$smtpResponse";
	}
}
?>
