<?php

class Term extends Service {
  // data stored in this object
  protected $term;
  
  public function __construct($options){
    parent::__construct($options);
    $this->connect();
  }
  public function term_load($tid) {
    return (object)$this->requestSend($this->_methods->TERM_GET, array($tid));
  }
  public function term_create($term) {
    if(is_array($term)){
      $term = (object)$term;
    }
    return $this->requestSend($this->_methods->TERM_CREATE, array($term));
  }

  public function term_save($tid, $term) {
    if(is_object($term)){
      $term = (array)$term;
    }
    return $this->requestSend($this->_methods->TERM_SAVE, array($tid, $term));
  }
  public function term_delete($tid) {
   if (!is_array($tid)) {
      $tid = (array)$tid;
    } 
    $return = array();
    foreach ($tid as $id) {
      $return[] = $this->requestSend($this->_methods->TERM_DELETE, array($id));
    }
    return $return;
  }
  /*
    $page: The zero-based index of the page to get, defaults to 0.
    $fields: string, The fields to get.
    $parameters: array, Parameters array
    $pagesize: Number of records to get per page.
  */
  public function term_list($page = 0, $fields = '*', $parameters = array(), $pagesize = 20){

      return $this->requestSend($this->_methods->TERM_LIST, array($page, $fields, $parameters, $pagesize));
  }
}

