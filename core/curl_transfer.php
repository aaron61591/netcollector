<?php

class Curl_transfer {

    private $url;
    private $content;
    private $curl_handle;
    private $header;
    private $useragent;
    private $transfer_timeout;
    private $wait_timeout;

    public function __construct() {
        
        $this->header = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $this->useragent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';
        $this->transfer_timeout=180;
        $this->wait_timeout=10;
        $this->content='';
    }
    
    public function initialize_url($current_url){
        
        $this->url=$current_url;
    }

    public function get_content() {

        $this->curl_handle = curl_init();
        curl_setopt($this->curl_handle, CURLOPT_URL, $this->url);
        curl_setopt($this->curl_handle, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($this->curl_handle, CURLOPT_TIMEOUT, $this->transfer_timeout);
        curl_setopt($this->curl_handle, CURLOPT_CONNECTIONTIMEOUT, $this->wait_timeout);
        curl_setopt($this->curl_handle, CURLOPT_HEADER, 0);
        curl_setopt($this->curl_handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl_handle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curl_handle, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($this->curl_handle, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($this->curl_handle, CURLOPT_REFERER, $this->url);
        $this->content = curl_exec($this->curl_handle);
        curl_close($this->curl_handle);
        return $this->content;
    }

}

?>
