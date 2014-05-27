<?php

class Service{
    protected $_methods_class = 'Methods';
    protected $_methods;
    protected $_options = array();
    protected $_connected = false;
    protected $_cookieFile;

    public function __construct($options){
        $this->_options['username'] = $options['username'];
        $this->_options['password'] = $options['password'];
        $this->_options['endpoint'] = $options['endpoint'];
        $this->_options['token_url'] = $options['token_url'];
        $this->_options['token'] = file_get_contents($options['token_url']);
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

    protected function requestSend($methodName, $args = array(), $token = false){
        // Setup curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->_cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->_cookieFile);
        curl_setopt($ch, CURLOPT_URL, $this->_options['endpoint']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true); // enable tracking

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $csrf_header = 'X-CSRF-Token: ' . $this->_options['token'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', $csrf_header));
        if(!$token){
            // for utf-8, 
            $output_options = array( 
                "output_type" => "xml", 
                "verbosity" => "pretty", 
                "escaping" => array("markup"), 
                "version" => "xmlrpc", 
                "encoding" => "utf-8" 
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, xmlrpc_encode_request($methodName, $args, $output_options));
        }
        $output = curl_exec($ch);
        $info 	= curl_getinfo($ch);
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
//        echo $headerSent;
//        print_r($info);
        curl_close($ch);
        if($token){
            return $output;
        }
        $response = xmlrpc_decode($output, 'utf-8');

        if (!is_array($response)) {
            exit(print_r($info, true));
        } elseif (xmlrpc_is_fault($response)) {
            var_dump($response);
            $response = false;
        } 
        return $response;
    }
    function login(){
        try {
            $result = $this->requestSend($this->_methods->CONNECT);
       //     print_r($result);
            $result = $this->requestSend($this->_methods->LOGIN, array(
                $this->_options['username'],
                $this->_options['password'],
            ));
            $endpoint = $this->_options['endpoint'];
            $this->_options['endpoint'] = $this->_options['token_url'];
            $this->_options['token'] = $this->requestSend('', array(),true);
            $this->_options['endpoint'] = $endpoint;

      //      print_r($result);
            $this->_connected = is_array($result);
        } catch (Exception $e) {
            echo $this->_methods->CONNECT . ":" . $e->getMessage();
        }
        return $this->_connected;
    }

    public function logout(){
    }
}