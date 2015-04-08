<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Remove ADSENSE Ads
*/
class Remove_ads {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
        
    }

    public function clear($site_id, $content){
            $this->CI->load->model('packages_model');
            $is_premium = $this->CI->packages_model->is_premium($site_id);
            if($content && !$is_premium) {
                $dom = new DOMDocument;
                $dom->loadHTML("<html><head></head><body>". mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8') . "</body></html>");
                $xpath = new DOMXPath($dom);
                $this->CI->config->load('removed_ads');
                $removed_ads = $this->CI->config->item('removed_ads');
                $newelement = $dom->createTextNode('<!-- Bu reklam Sincapp tarafından otomatik olarak silinmiştir. Reklam ekleyebilmek için üst pakete geçin. -->'); 

                foreach($removed_ads as $src) {
                    $results = $xpath->query("//script[contains(@src, '".$src."')]");
                    foreach ($results as $element) {
                         $element->parentNode->replaceChild($newelement, $element); 
                    }
                }

            $content = $dom->saveHTML();
            $content = preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $content);
            }

       return $content;        
    }
}