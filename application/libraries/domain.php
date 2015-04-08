<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
//exceptions

class CustomerExistsException extends Exception {}
class AccessDeniedException extends Exception {}
class UnexpectedException extends Exception {}
class DomainExistsException extends Exception {}
class ConnectionException extends Exception {}

class Domain {
	private $CI;
	private $_auth_userid;
	private $_api_key;
	private $_api_url;
	private $_client;
	private $_ns1;
	private $_ns2;
	public function __construct() {
		$this->CI =& get_instance();
		if (ENVIRONMENT == 'production') {
			$this->CI->config->load('resellerclub');
		} else {
			$this->CI->config->load('test_resellerclub');
		}

		$this->_api_url = $this->CI->config->item('api_url');
		$this->_api_key = $this->CI->config->item('api_key');

		$this->_auth_userid = $this->CI->config->item('auth_user_id');

		$this->_ns1 = $this->CI->config->item('ns1');
		$this->_ns2 = $this->CI->config->item('ns2');

		$this->_client = new GuzzleHttp\Client();
	}

	/**
	* Get domain avaliablety
	* @param string $domain, ex. sincapp
	* @param string $tdls, ex. com
	* @return bool
	*/
	public function whois($domain, $tdls)
	{
		$url = $this->_api_url ."/api/domains/available.json?auth-userid=" . $this->_auth_userid ."&api-key=". $this->_api_key ."&domain-name=". $domain;
		foreach($tdls as $tdl) {
			$url .= "&tlds=". $tdl;
		}

		$res = $this->_client->get($url);
		return $res->json();
	}

	public function add_customer($data) {
		$url = $this->_api_url ."/api/customers/signup.xml?auth-userid=" . $this->_auth_userid ."&api-key=". $this->_api_key;
		$url .= "&username=" . $data['email'];
		$url .= "&passwd=" . $this->_generate_pass();
		$url .= "&name=" . urlencode($data['name']);
		$url .= "&company=sincapp";
		$url .= "&address-line-1=" . urlencode($data['address']);
		$url .= "&city=" . urlencode($data['city']);
		$url .= "&state=". urlencode("Not Applicable");
		$url .= "&country=TR";
		$url .= "&zipcode=" . urlencode($data['zipcode']);
		$url .= "&phone-cc=+90";
		$url .= "&phone=" . urlencode($data['phone']);
		$url .= "&lang-pref=tr";

		try {
			$res = $this->_client->post($url);
		} catch (GuzzleHttp\Exception\ServerException $exception) {
			$response = $exception->getResponse()->getBody();
			$xml = simplexml_load_string($response);
			// Already exist error
			switch($xml->message):
				case $data['email'] . ' is already a Customer.':
					throw new CustomerExistsException();
					break;
				case "Access Denied: You are not authorized to perform this action":
					throw new AccessDeniedException();
					break;
			endswitch;
		} catch(GuzzleHttp\Exception\RequestException $exception) {
			throw new ConnectionException();
		}

		if (!$res) {
			throw new UnexpectedException();
		}
		$xml = $res->xml();

		if($xml[0]) {
			return $xml[0];
		} else {
			throw new UnexpectedException();
		};
	}

	public function add_contact($customer_id, $data) {
		$url = $this->_api_url ."/api/contacts/add.json?auth-userid=" . $this->_auth_userid ."&api-key=". $this->_api_key;
		$url .= "&name=" . urlencode($data['name']);
		$url .= "&company=sincapp";
		$url .= "&email=" . $data['email'];
		$url .= "&address-line-1=" . urlencode($data['address']);
		$url .= "&city=" . urlencode($data['city']);
		$url .= "&state=". urlencode("Not Applicable");
		$url .= "&country=TR";
		$url .= "&zipcode=" . urlencode($data['zipcode']);
		$url .= "&phone-cc=+90";
		$url .= "&phone=" . urlencode($data['phone']);
		$url .= "&customer-id=" . $customer_id;
		$url .= "&type=Contact";

		try{
			$res = $this->_client->post($url);
		} catch(Exception $exception) {
			throw UnexpectedException();
		}

		if (!$res) {
			throw new UnexpectedException();
		}
		$json = $res->json();

		if(is_numeric($json)) {
			return $json;		
		} else {
			throw new UnexpectedException();
		}
	}


	public function register_domain($customer_id, $contact_id, $order) {
		$url = $this->_api_url ."/api/domains/register.json?auth-userid=" . $this->_auth_userid ."&api-key=". $this->_api_key;
		$url .= '&domain-name='. $order->domain;
		$url .= "&years=1";
		$url .= "&ns=".$this->_ns1;
		$url .= "&ns=".$this->_ns2;
		$url .= "&customer-id=" . $customer_id;
		$url .= "&reg-contact-id=" . $contact_id;
		$url .= "&admin-contact-id=" . $contact_id;
		$url .= "&tech-contact-id=" . $contact_id;
		$url .= "&billing-contact-id=". $contact_id;
		$url .= "&invoice-option=NoInvoice";
		$url .= "&purchase-privacy=1";
		$url .=	"&protect-privacy=1";

		try {
			$res = $this->_client->post($url);
		} catch(GuzzleHttp\Exception\ServerException $exception) {
			$message = $exception->getResponse()->getBody();
			throw new UnexpectedException();
		} catch(GuzzleHttp\Exception\RequestException $exception) {
			throw new ConnectionException();
		} catch(Exception $exception) {
			throw new UnexpectedException();
		}

		$json = $res->json();
		
		// Success
		if(isset($json['actionstatus']) && $json['actionstatus'] == 'Success') {
			return true;
		}
		// \ Success
		if(isset($json['status']) && $json['status'] == 'error') {
			$message = $json['error'];

			if(preg_match("/already registered/", $message)){
			    throw new DomainExistsException();
			}
			throw new UnexpectedException();
		}
		return true;		
	}

	private function _generate_pass($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;		
	}
}