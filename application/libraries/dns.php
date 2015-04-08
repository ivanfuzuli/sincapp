<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class UnexpectedDnsException extends Exception {}

class Dns {
	private $CI;
	private $_client_id;
	private $_api_key;
	private $_ip;
	private $_client;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->config->load('digitalocean');
		$this->_client_id = $this->CI->config->item('do_client_id');
		$this->_api_key = $this->CI->config->item('do_api_key');
		$this->_ip = $this->CI->config->item('do_ip');
		$this->_client = new GuzzleHttp\Client();
	}

	public function add_domain($domain) {
		$url = "https://api.digitalocean.com/v1/domains/new?client_id=".$this->_client_id."&api_key=" . $this->_api_key;
		$url .= "&name=". $domain;
		$url .= "&ip_address=". $this->_ip;

		try {
			$res = $this->_client->get($url);

		} catch(Exception $ex) {
			throw new UnExpectedDnsException();
		}
		$json = $res->json();
		if($json['status'] == "OK") {
			return $json['domain']['id'];
		} else {
			throw new UnExpectedDnsException();
		}
	}

	public function add_record($data) {
		$url = "https://api.digitalocean.com/v1/domains/".$data['domain_id']."/records/new?";
		$url .= "client_id=" .$this->_client_id ."&api_key=". $this->_api_key;
		$url .= "&record_type=" . $data['record_type'];
		$url .= "&data=" . $data['data'];
		if(isset($data['name'])) {
			$url .= "&name=" . $data['name'];
		}
		if(isset($data['priority'])) {		
			$url .= "&priority=" . $data['priority'];
		}

		try {
			$res = $this->_client->get($url);
		} catch(Exception $ex) {
			throw new UnExpectedDnsException();
		}

		$json = $res->json();
		return $json;
	}
}