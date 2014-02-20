<?php

class Cms{
    private $_methods_class = 'Cms_Methods';
    private $_methods;
    private $_options = array();
    private $_connected = false;
    private $_cookieFile;

// data stored in this object
    private $node;

    function __construct($options){
        $this->_options['username'] = $options['username'];
        $this->_options['password'] = $options['password'];
        $this->_options['endpoint'] = $options['endpoint'];
        $this->_options['token'] = file_get_contents('http://product.sky-city.me/services/session/token');
        $this->_cookieFile = tempnam('/tmp', 'CURLCOOKIE');
        $this->_methods = new $this->_methods_class();
    }
    private function connect(){
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

    private function requestSend($methodName, $args = array(), $token = false){
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
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, xmlrpc_encode_request($methodName, $args));
        }
        $output = curl_exec($ch);
        $info 	= curl_getinfo($ch);
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        echo $headerSent;
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
            print_r($result);
            $result = $this->requestSend($this->_methods->LOGIN, array(
                $this->_options['username'],
                $this->_options['password'],
            ));
            $endpoint = $this->_options['endpoint'];
            $this->_options['endpoint'] = 'http://product.sky-city.me/services/session/token';
            $this->_options['token'] = $this->requestSend('', array(),true);
            $this->_options['endpoint'] = $endpoint;

            print_r($result);
            $this->_connected = is_array($result);
        } catch (Exception $e) {
            echo $this->_methods->CONNECT . ":" . $e->getMessage();
        }
        return $this->_connected;
    }
    public function logout(){

    }
    public function node_load($nid) {
        return (object)$this->requestSend($this->_methods->NODE_GET, array($nid));
    }
    public function node_save($nid, $node) {
        $this->connect();
        if(is_object($node)){
            $node = (array)$node;
        }
        return $this->requestSend($this->_methods->NODE_SAVE, array($nid, $node));
    }
    
    public function node_list(){
        $this->connect();

    }
    public function term_list(){
        $this->connect();

    }
    public function term_load(){
        return $this->requestSend($this->_methods->NODE_GET, array($nid));
    }
    public function test(){
//        return $this->requestSend($this->_methods->NODE_GET, array('aa' => 34, 'bb' => 56));
          $result = $this->requestSend($this->_methods->CONNECT);
          if ($result) {
              echo 'yes'.print_r($result);
          }else {
              echo 'no';
          }
    }
    public function test2($nid){
          $result = $this->requestSend($this->_methods->CONNECT);
          $result = $this->requestSend($this->_methods->LOGIN, array(
                $this->_options['username'],
                $this->_options['password'],
            ));
          exit(print_r($result));
        return $this->requestSend($this->_methods->USER_LOAD, array($nid));
    }
    public function test3(){
        $this->_options['endpoint'] = 'http://product.sky-city.me/services/session/token';
        return $this->_options['token'] = $this->requestSend('', array(),true);
    }
    

}
class Cms_Methods{
    const CONNECT 	= 'system.connect';
    const LOGIN		= 'user.login';
    const LOGOUT	= 'user.logout';
    const SERVICES_GET = 'system.getServices';
    const USER_LOAD	= 'user.retrieve';
    const NODE_GET	= 'node.retrieve';
    const NODE_SAVE = 'node.update';
    const SEARCH_NODES = 'search.nodes';

    public function __get($name){
        if (!constant($constant = get_class($this) . '::' . $name)) {
            throw new Exception('Invalid ' . get_class($this) . ' const');
        }
        return constant($constant);
    }
}

$options = array(
    'endpoint' =>  'http://product.sky-city.me/?q=service/output',
//    'endpoint' =>  'http://product.sky-city.me/test.php',
    'username' => 'product',
    'password' => 'product&sky-city',
);
$cms = new Cms($options);
//print_r($cms->connect());
//echo $cms->requestSend($this->_methods->NODE_GET, array('aa' => 34, 'bb' => 56));
//$cms->test();
//print_r($cms->test2(1));
$node = $cms->node_load(1);
$node->field_filed_test['und'][0]['value'] = 'bbbb';
print_r($cms->node_save(1,$node));
//echo $cms->test3();
//print_r($node);
//$node->
?>
