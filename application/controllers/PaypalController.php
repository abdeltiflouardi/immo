<?php
/**
 * Paypal Controller
 * 
 * @author 
 * @version
 */
class PaypalController extends Zend_Controller_Action
{	
	function okAction()
	{
		$errors = '';
		$result = false;
		$values = array();
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$params = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value)
			$params .= '&'.$key.'='.urlencode(stripslashes($value));
		
		$paypalServer = SERVER_PAYPAL;
		
		// Getting PayPal data...
		if (function_exists('curl_exec'))
		{
			// curl ready
			$ch = curl_init('https://' . $paypalServer . '/cgi-bin/webscr');
		    
			// If the above fails, then try the url with a trailing slash (fixes problems on some servers)
		 	if (!$ch)
				$ch = curl_init('https://' . $paypalServer . '/cgi-bin/webscr/');
			
			if (!$ch)
				$errors .= 'curlmethodfailed';
			else
			{
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
				$result = curl_exec($ch);
		
				if ($result != 'VERIFIED')
					$errors .= $result.' cURL error:'.curl_error($ch);
					
				curl_close($ch);
			}
		}
		elseif (($fp = @fsockopen('ssl://' . $paypalServer, 443, $errno, $errstr, 30)) || ($fp = @fsockopen($paypalServer, 80, $errno, $errstr, 30)))
		{
			// fsockopen ready
			$header = 'POST /cgi-bin/webscr HTTP/1.0'."\r\n" .
		          'Host: '.$paypalServer."\r\n".
		          'Content-Type: application/x-www-form-urlencoded'."\r\n".
		          'Content-Length: '.Tools::strlen($params)."\r\n".
		          'Connection: close'."\r\n\r\n";
			fputs($fp, $header.$params);
		 	
		 	$read = '';
		 	while (!feof($fp))
			{
				$reading = trim(fgets($fp, 1024));
				$read .= $reading;
				if (($reading == 'VERIFIED') || ($reading == 'INVALID'))
				{
				 	$result = $reading;
					break;
				}
		 	}
			if ($result != 'VERIFIED')
				$errors .= 'socketmethod'.$result;
			fclose($fp);
		}
		else
			$errors = 'connect'.'nomethod';
		
		
		// Printing errors...
		if ($result == 'VERIFIED') {
			
			if (!isset($_POST['mc_gross'])) $errors .= 'mc_gross'.'<br />';
			
			
			if (!isset($_POST['payment_status']))
				$errors .= 'payment_status'.'<br />';
			//elseif ($_POST['payment_status'] != 'Completed')
			//	$errors .= 'payment'.$_POST['payment_status'].'<br />';
			
			
			if (!isset($_POST['custom']))$errors .= 'custom'.'<br />';
			
			if (!isset($_POST['txn_id']))$errors .= 'txn_id'.'<br />';
			
			if (!isset($_POST['mc_currency']))$errors .= 'mc_currency'.'<br />';
			
			
			if (empty($errors))
			{
					//$_POST['txn_id'];
					$nbr_jrs = TAbonnement::getLeftByClient($_POST['custom']);
					
					$values['email'] = $_POST['custom'];
					$values['nbr_jours'] = $_POST['item_number']+$nbr_jrs;
					$values['prix'] = $_POST['mc_gross'];
					
					$nab = new TAbonnement;
					$nab->insertAbonnement($values);
			}
		} else {
			$errors .= 'verified';
		}
		
		if (!empty($errors) AND isset($_POST['custom'])){
			
			$data = array(
							'erreur' => $errors,
							'date_erreur' => new Zend_Db_Expr('NOW()')
						);
			
			$ne = new TErreur;
			$ne->insert($data);
			
		}
			
	}
}

/*
			'mc_gross' => $this->l('Paypal key \'mc_gross\' not specified, can\'t control amount paid.'),
			'payment_status' => $this->l('Paypal key \'payment_status\' not specified, can\'t control payment validity'),
			'payment' => $this->l('Payment: '),
			'custom' => $this->l('Paypal key \'custom\' not specified, can\'t rely to cart'),
			'txn_id' => $this->l('Paypal key \'txn_id\' not specified, transaction unknown'),
			'mc_currency' => $this->l('Paypal key \'mc_currency\' not specified, currency unknown'),
			'cart' => $this->l('Cart not found'),
			'order' => $this->l('Order has already been placed'),
			'transaction' => $this->l('Paypal Transaction ID: '),
			'verified' => $this->l('The PayPal transaction could not be VERIFIED.'),
			'connect' => $this->l('Problem connecting to the PayPal server.'),
			'nomethod' => $this->l('No communications transport available.'),
			'socketmethod' => $this->l('Verification failure (using fsockopen). Returned: '),
			'curlmethod' => $this->l('Verification failure (using cURL). Returned: '),
			'curlmethodfailed' => $this->l('Connection using cURL failed'),
*/
?>
