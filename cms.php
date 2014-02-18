<?php

$options = array(
    'endpoint' =>  'http://product.sky-city.me',
    'username' => '',
    'password' => '',
);
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

    private function requestSend( $methodName, $args = array()){
        // Setup curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->_cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->_cookieFile);
        curl_setopt($ch, CURLOPT_URL, $this->_options['endpoint']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/xml; charset=utf-8' ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, xmlrpc_encode_request($methodName, $args));
        $output = curl_exec($ch);
        $info 	= curl_getinfo($ch);
        curl_close($ch);

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
            $result = $this->requestSend($this->_methods->LOGIN, array(
                $this->_options['username'],
                $this->_options['password'],
            ));
            $this->_connected = is_array($result);
        } catch (Exception $e) {
            echo $this->_methods->CONNECT . ":" . $e->getMessage();
        }
        return $this->_connected;
    }
    function logout(){

    }
    public function node_load($nid, $fields = array()) {
        $this->connect();
        return $this->requestSend($this->_methods->NODE_GET, array($nid));
    }
    function node_list(){
        $this->connect();

    }
    function term_list(){
        $this->connect();

    }
    function term_load(){
        $this->connect();

    }
}
class Cms_Methods{
    const CONNECT 	= 'system.connect';
    const LOGIN		= 'user.login';
    const LOGOUT	= 'user.logout';
    const SERVICES_GET = 'system.getServices';

    // ref: http://cms.woger-cdn.com/admin/build/services/browse/node.get
    const NODE_GET	= 'node.retrieve';

    // ref: http://cms.woger-cdn.com/admin/build/services/browse/node.update
    const NODE_SAVE = 'node.update';

    // ref: http://cms.woger-cdn.com/admin/build/services/browse/search.nodes
    const SEARCH_NODES = 'search.nodes';

    public function __get($name){
        if (!constant($constant = get_class($this) . '::' . $name)) {
            throw new Exception('Invalid ' . get_class($this) . ' const');
        }
        return constant($constant);
    }
}

$user = array(
        'username' => 'tian',
        'password' => 'bo',
        );
$cms = new Cms($user);
//print_r($cms->connect());
echo $cms->login();
?>
