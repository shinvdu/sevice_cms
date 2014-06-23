<?php

class User extends Service
{
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
  public function user_list(){
      return $this->requestSend($this->_methods->USER_LIST);
  }
}
