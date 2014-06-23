<?php

class Node extends Service
{
  // data stored in this object
  protected $node;

  public function node_load($nid) {
    $this->connect();
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
      return $this->requestSend($this->_methods->NODE_LIST);
  }
}
