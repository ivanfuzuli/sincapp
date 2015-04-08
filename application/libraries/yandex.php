<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class UnexpectedYandexException extends Exception {}
class DomainLimitYandexException extends Exception {}

class Yandex {
	private $CI;
	private $_token;
	private $_client;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->config->load('yandex');
		$this->_token = $this->CI->config->item('yandex_token');
		$this->_client = new GuzzleHttp\Client();
		//disable ssl verification
		$this->_client->setDefaultOption('verify', false);
	}

	public function reg_domain($domain) {
		$url = "https://api.kurum.yandex.com.tr/api/reg_domain.xml?token=" . $this->_token;
		$url .= "&domain=" . $domain;

		try {
			$res = $this->_client->get($url);
		} catch (Exception $ex) {
			throw new UnexpectedYandexException();
			return false;
		}
		$xml = $res->xml();
		if($xml->status->error == "domains_limit") {
			throw new DomainLimitYandexException();
			return false;
		}
			$data = array(
			'secret_name' => ''.$xml->domains->domain->secret_name.'',
			'secret_value' => ''.$xml->domains->domain->secret_value .''
			);
		return $data;

	}

	public function add_logo($domain) {
	$url = "https://api.kurum.yandex.com.tr/api/add_logo.xml";
	$filename = getcwd() . "/application/libraries/logo.png";
	$post = array('domain' => $domain, 'token' => $this->_token, 'file'=>'@'.$filename);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$post);

	// in real life you should use something like:
	// curl_setopt($ch, CURLOPT_POSTFIELDS,
	//          http_build_query(array('postvar1' => 'value1')));

	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	curl_close ($ch);
	}

	public function reg_user($domain, $login, $pass) {
		$url = "https://api.kurum.yandex.com.tr/api/reg_user.xml?token=" . $this->_token;
		$url .= "&domain=" . $domain;
		$url .= "&login=" . $login;
		$url .= "&passwd=" . $pass;

		$res = $this->_client->get($url);
		$xml = $res->xml();

		$error = (string) $xml->status->error;
		return $error;
	}

	public function delete_user($domain, $login) {
		$url = "https://api.kurum.yandex.com.tr/api/del_user.xml?token=" . $this->_token;
		$url .= "&domain=" . $domain;
		$url .= "&login=" . $login;

		$res = $this->_client->get($url);
		$xml = $res->xml();
		print_r($xml);
	}
}
