<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
use OAuth\OAuth2\Service\Facebook;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;
/**
 * ErkanaAuth by Michael Wales
 */

class Fb {

    var $CI;
    private $_curentUri;
    private $_facebookService;

    public function __construct() {
        $this->CI =& get_instance();
        
        $this->CI->config->load('facebook');
		// Session storage
		$storage = new Session();
		
		$serviceFactory = new \OAuth\ServiceFactory();

		$uriFactory = new \OAuth\Common\Http\Uri\UriFactory();
		$this->_currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
		$this->_currentUri->setQuery('');

		$credentials = new Credentials(
    		$this->CI->config->item('key'),
    		$this->CI->config->item('secret'),
    		$this->_currentUri->getAbsoluteUri()
		);

		$this->_facebookService = $serviceFactory->createService('facebook', $credentials, $storage, array('email'));
    }


	/**
	* Redirect function for facebook login
	*
	*/
    public function redirect_to_fb(){
		if (!empty($_GET['fb']) && $_GET['fb'] === 'fb') {
		    $url = $this->_facebookService->getAuthorizationUri();
		    header('Location: ' . $url);
		} 	    	
    }
    /**
    * Getter for facebook information
    * @return array|bool
    */
    public function get_fb_info()
    {
		if (!empty($_GET['code'])) {
		    // This was a callback request from facebook, get the token
		    $token = $this->_facebookService->requestAccessToken($_GET['code']);

		    // Send a request with it
		    $result = json_decode($this->_facebookService->request('/me'), true);

		    // Show some of the resultant data
		    return $result;
		} else {
			return false;
		}
    }

    /**
    * Getter for facebook login url
    * @return string
    */
    public function get_url() {
    	return $this->_currentUri->getRelativeUri() . '?fb=fb';
    }
}