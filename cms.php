<?php
class Cms{
    private $endpoint = 'http://product.sky-city.me';
    private $method = 'user.login';
    private $user = array();
    private $connected = false;
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

$user = array(
        'username' => 'tian',
        'password' => 'bo',
        );
$cms = new Cms($user);
print_r($cms->connect());
?>
