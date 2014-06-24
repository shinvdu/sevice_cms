<?php

class System extends Connector {
  public function __construct($options){
    parent::__construct($options);
    $this->connect();
  }
  public function variable_get($name, $value = '') {
    return (object)$this->requestSend($this->_methods->SYSTEM_GET, array($name, $value));
  }
  public function variable_set($name, $value) {
    return $this->requestSend($this->_methods->SYSTEM_SET, array($name, $value));
  }

  public function variable_delete($name) {
    return $this->requestSend($this->_methods->SYSTEM_DELETE, array($name));
  }
}
