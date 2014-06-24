<?php

class User extends Service {
  // data stored in this object
  protected $user;

  public function __construct($options){
    parent::__construct($options);
    $this->connect();
  }
  public function user_load($uid) {
    return (object)$this->requestSend($this->_methods->USER_LOAD, array($uid));
  }
  public function user_save($uid, $user) {
    if(is_object($user)){
      $user = (array)$user;
    }
    return $this->requestSend($this->_methods->USER_SAVE, array($uid, $user));
  }
  public function user_create($user) {
    if(is_array($user)){
      $user = (object)$user;
    }
    return $this->requestSend($this->_methods->USER_CREATE, array($user));
  }

  public function user_delete($uid) {
    return $this->requestSend($this->_methods->USER_DELETE, array($uid));
  }

  public function user_list($page = 0, $fields = '*', $parameters = array(), $pagesize = 20){
    return $this->requestSend($this->_methods->USER_LIST, array($page, $fields, $parameters, $pagesize));
  }
}
