<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class ValidationException extends Exception {}
class TransactionException extends Exception {}

class Pos {

    var $CI;
    private $_posnet = null;
    private $_ccno = null;
    private $_expdate = null;
    private $_cvc = null;
    private $_orderid = null;
    private $_currencycode = "YT";
    private $_instnumber = 00;
    private $_amount = null; 
    public function __construct() {
        $this->CI =& get_instance(); 
        if (ENVIRONMENT == 'production') {
            $this->CI->config->load('posnet');
        } else {
            $this->CI->config->load('test_posnet');
        }

        $hostname = $this->CI->config->item('posnet_hostname');
        $mid = $this->CI->config->item('posnet_mid');
        $tid = $this->CI->config->item('posnet_tid');

            $path =  realpath(APPPATH) . '/libraries/Posnet Modules';
            set_include_path(get_include_path() . PATH_SEPARATOR . $path);
            require_once('Posnet XML/posnet.php');
            $this->_posnet = new Posnet();

            $this->_posnet->SetURL($hostname);
            $this->_posnet->SetMid($mid);
            $this->_posnet->SetTid($tid);
            $this->_posnet->SetDebugLevel(0);        
    }

    /**
     * Set credit card number
     * @param $ccno
     */
    public function set_ccno($ccno) {
    	$this->_ccno = $ccno;
    }

    /**
     * Setter for expiration date
     * @param int $expdate ex. 1901 (2019-01)
     */
    public function set_expdate($expdate) {
    	$this->_expdate = $expdate;
    }

    /**
     * Setter for cvc
     */
    public function set_cvc($cvc) {
    	$this->_cvc = $cvc;
    }

    /**
     * Setter for order id, it is random 24 digit alphanumeric
     * @param int $order_id
     */
    public function set_orderid($orderid) {
    	$this->_orderid = $orderid;
    }

    public function set_instnumber($instnumber) {
    	$this->_instnumber = $instnumber;
    }

    public function set_amount($amount) {
    	$amount = number_format($amount, 2, '', ''); // 15 TL ex 1500
    	$this->_amount = $amount;
    }
    /**
     * Getter for credit card number
     * @return int
     */
    private function _get_ccno() {
    	if(!preg_match('/^[0-9]{16}$/', $this->_ccno)) {
    		throw new ValidationException("Kredi kartı numarası 16 karakter uzunluğunda olmalıdır.");
    	}

    	return $this->_ccno;
    }

    /**
     * Getter for amount
     */
    private function _get_amount() {
    	if(!is_numeric($this->_amount) || $this->_amount < 1) {
    		throw new ValidationException("Tutar sayısal bir veri olmak zorundadır.");
    	}
    	return $this->_amount;
    }
    /**
     * Getter for expiration date
     * @return int
     */
    private function _get_expdate() {
        $error = false;
        // 4 karakter ve numerik
        if ( ! preg_match('/^[0-9]{4}$/', $this->_expdate))
            $error = true;
/**        // Ay kontrolü
        // 1-12 arası olmak zorunda
        $ay = (int) substr($this->_expdate, 0, 2);
        if ($ay > 12 or $ay <= 0)
            $error = true;
        // Yıl kontrolü
        // Geçmiş yıl olamaz
        $yil = (int) substr($this->_expdate, 2, 2);
        if ($yil < date('y'))
            $error = true;
*/
    	if($error) {
    		throw new ValidationException("Son kullanma tarihi hatalı.");
    	}
    	return $this->_expdate;
    }

    private function _get_orderid() {
    	if(strlen($this->_orderid) != 24) {
    		throw new ValidationException("Sipariş numarası 24 karakterden oluşmalıdır.");
    	}
    	return $this->_orderid;
    }

    /**
     * Getter for cvc number
     */
    private function _get_cvc() {
    	if(!preg_match('/^[0-9]{3}$/', $this->_cvc)) {
    		throw new ValidationException("CVC 3 karakterden oluşmalıdır.");
    	}
    	return $this->_cvc;
    }

    public function generate_orderid() {
    	$randNumber = null;
        for ($i = 0; $i < 24; $i++) {
            $randNumber .= rand(0, 9);

        }

        return $randNumber;    	
    }

    /**
     * Do Sale
     */
    public function sale() {
        $this->_posnet->DoSaleTran(
                    $this->_get_ccno(),
                    $this->_get_expdate(), // Ex : 0703 - Format : YYMM
                    $this->_get_cvc(),
                    $this->_get_orderid(),
                    $this->_get_amount(), // Ex : 1500->15.00 YTL
                    $this->_currencycode, // Ex : YT
                    $this->_instnumber // Ex : 05
        );

        if($this->is_approved()) {
        	return true;
        } else {
        	throw new TransactionException("Para transfer işlemi banka tarafından onaylanmadı.");
        }
    }

    public function is_approved() {
    	if($this->_posnet->GetApprovedCode()){
    		return true;
    	} else {
    		return false;
    	};
    }

    /**
    * Hata kodu
    */
    public function get_response_code() {
    	return $this->_posnet->GetResponseCode();
    }

    /*
     * Hata Mesajı
     */
    public function get_response_text() {
    	return $this->_posnet->GetResponseText();
    }


    /**
     * Onay Kodu
     */
    public function get_auth_code() {
    	return $this->_posnet->GetAuthcode();
    }

    /**
     * Referans kodu
     */
    public function get_reference() {
		return $this->_posnet->GetHostlogkey();
    }

    public function get_ip() {
    $ip = getenv('HTTP_CLIENT_IP')?:
    getenv('HTTP_X_FORWARDED_FOR')?:
    getenv('HTTP_X_FORWARDED')?:
    getenv('HTTP_FORWARDED_FOR')?:
    getenv('HTTP_FORWARDED')?:
    getenv('REMOTE_ADDR');

    return $ip;        
    }
}