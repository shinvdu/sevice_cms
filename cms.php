<?php
class Cms{
    private $endpoint = 'http://product.sky-city.me';
    private $method = 'user.login';
    private $methods_class = 'Cms_Methods';
    private $user = array();
    private $connected = false;
    private $cookieFile;
    private $node;
    function __construct($user){
        $this->user['username'] = $user['username'];
        $this->user['password'] = $user['password'];
    }
    function connect(){
        if($this->connected || $this->login()){
            $this->connected = true;
        }else{
            exit('error, can not connect');
        }
        return $this->connected;
    }

    function login(){
        $login = new Cms_Methods();
        return $login->__get('CONNECT');
    }
    function logout(){

    }
    function node_load(){
        $this->connect();

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
