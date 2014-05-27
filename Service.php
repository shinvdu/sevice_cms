<?php

class Service{
    protected $_methods_class = 'Methods';
    protected $_methods;
    protected $_token; 
    protected $_ch; 
    protected $_ch_info; 
    protected $_post_fields; 
    protected $_options = array();
    protected $_connected = false;
    protected $_cookieFile;

    public function __construct($options){
        $this->_options = $options;
        $this->_token = file_get_contents($options['token_url']);
        $this->_cookieFile = tempnam('/tmp', 'CURLCOOKIE');
        $this->_methods = new $this->_methods_class();
    }
    protected function connect(){
        if($this->_connected || $this->login()){
            $this->_connected = true;
        }else{
            exit('error, can not connect');
        }
        return $this->_connected;
    }
    public function connected(){
        return $this->_connected;
    }

    protected function curl($url){
        // Setup curl
        $this->_ch = curl_init($url);
        curl_setopt($this->_ch, CURLOPT_COOKIEJAR, $this->_cookieFile);
        curl_setopt($this->_ch, CURLOPT_COOKIEFILE, $this->_cookieFile);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($this->_ch, CURLINFO_HEADER_OUT, true); // enable tracking

        $csrf_header = 'X-CSRF-Token: ' . $this->_token;
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', $csrf_header));
        if(!empty($this->_post_fields)){
            curl_setopt($this->_ch, CURLOPT_POST, true);
            curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $this->_post_fields);
        }
        $output = curl_exec($this->_ch);
        $this->_ch_info   = curl_getinfo($this->_ch);
        curl_close($this->_ch);
        return $output;
    }

    protected function requestSend($methodName, $args = array()){
        $output_options = array( 
            "output_type" => "xml", 
            "verbosity" => "pretty", 
            "escaping" => array("markup"), 
            "version" => "xmlrpc", 
            "encoding" => "utf-8" 
            );

        $this->_post_fields = xmlrpc_encode_request($methodName, $args, $output_options);
        // $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        $output = $this->curl($this->_options['endpoint']);
        $response = xmlrpc_decode($output, 'utf-8');

        if (!is_array($response)) {
            exit(print_r($this->_ch_info, true));
        } elseif (xmlrpc_is_fault($response)) {
            var_dump($response);
            $response = false;
        } 
        return $response;
    }

    function login(){
        try {
            $result = $this->requestSend($this->_methods->CONNECT);
            $result = $this->requestSend($this->_methods->LOGIN, array(
                $this->_options['username'],
                $this->_options['password'],
            ));
            // upate token
            $this->_token = $this->curl($this->_options['token_url']);

            $this->_connected = is_array($result);
        } catch (Exception $e) {
            echo $this->_methods->CONNECT . ":" . $e->getMessage();
        }
        return $this->_connected;
    }

    public function logout(){
    }
}
