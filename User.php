<?php

class User extends Service
{
  // data stored in this object
  protected $user;

  public function user_load($uid) {
    $this->connect();
    return (object)$this->requestSend($this->_methods->USER_LOAD, array($uid));
  }
  public function user_save($uid, $user) {
    $this->connect();
    if(is_object($user)){
      $user = (array)$user;
    }
    return $this->requestSend($this->_methods->USER_SAVE, array($uid, $user));
  }
  
  public function user_list(){
    $this->connect();
  }
}
