<?php
 
class MY_Security extends CI_Security{
 	var $purifier = null;
	//overriding the normal csrf_verify, this gets automatically called in the Input library's constructor
	//verifying on POST and PUT and DELETE
	public function csrf_verify(){
		$request_method = strtoupper($_SERVER['REQUEST_METHOD']);
		//If it is GET, ignore the rest
		if($request_method == 'GET' OR $request_method == 'HEAD' OR $request_method == 'OPTIONS'){
			return $this->csrf_set_cookie();
		}
 
		// Check if URI has been whitelisted from CSRF checks
		if($exclude_uris = config_item('csrf_exclude_uris')){
			$uri = load_class('URI', 'core');
			if(in_array($uri->uri_string(), $exclude_uris)){
				return $this;
			}
		}
 
		//Double submit cookie method: COOKIE needs to exist and at least either POST or SERVER needs to exist and at least one of the POST or SERVER must match the COOKIE
		if(
			!isset($_COOKIE[$this->_csrf_cookie_name])
			OR
			(
				!isset($_POST[$this->_csrf_token_name])
				AND
				!isset($_SERVER['HTTP_X_CSRF_TOKEN'])
			)
		){
			$this->csrf_show_error();

		}
 		
		//if CSRF token was in the POST, then it needs to match the cookie
		if(isset($_POST[$this->_csrf_token_name])){
			if($_POST[$this->_csrf_token_name] !== $_COOKIE[$this->_csrf_cookie_name]){
				$this->csrf_show_error();
			}
		}

		//if CSRF token was in the SERVER (headers), then it needs to match the cookie
		if(isset($_SERVER['HTTP_X_CSRF_TOKEN'])){
			if($_SERVER['HTTP_X_CSRF_TOKEN'] !== $_COOKIE[$this->_csrf_cookie_name]){
				$this->csrf_show_error();
			}
		}
		
		// We kill this since we're done and we don't want to polute the _POST array
		unset($_POST[$this->_csrf_token_name]);
 
		if(config_item('csrf_regenerate')){
			unset($_COOKIE[$this->_csrf_cookie_name]);
			$this->_csrf_hash = '';
		}
 
		$this->_csrf_set_hash();
		$this->csrf_set_cookie();
 
		log_message('debug', 'CSRF token verified');
		return $this;
	
	}
 
	public function csrf_show_error()
	{
		show_error('The action you have requested is not allowed.', 406);
	}

	/**
	 * Set Cross Site Request Forgery Protection Cookie
	 *
	 * @return	object
	 */
	public function csrf_set_cookie()
	{
		$expire = time() + $this->_csrf_expire;
		$secure_cookie = (config_item('cookie_secure') === TRUE) ? 1 : 0;

		if ($secure_cookie && (empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) === 'off'))
		{
			return FALSE;
		}

		setcookie($this->_csrf_cookie_name, $this->_csrf_hash, $expire, config_item('cookie_path'), config_item('cookie_domain'), config_item('cookie_secure'), config_item('cookie_httponly'));

		log_message('debug', "CRSF cookie Set");

		return $this;
	}

	public function xss_clean($str, $is_image = FALSE)
	{			
		if (!$this->purifier) {
			$config = HTMLPurifier_Config::createDefault();
			$this->purifier = new HTMLPurifier($config);			
		}
		$str = $this->purifier->purify($str);
		
		$str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
		return $str;	
	}	
}