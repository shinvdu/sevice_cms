<?php

class Comment extends Service
{
  // data stored in this object
  protected $comment;
  
  public function __construct($options){
    parent::__construct($options);
    $this->connect();
  }
  public function comment_load($cid) {
    return (object)$this->requestSend($this->_methods->COMMENT_GET, array($cid));
  }
  public function comment_create($comment) {
    if(is_array($comment)){
      $comment = (object)$comment;
    }
    return $this->requestSend($this->_methods->COMMENT_CREATE, array($comment));
  }

  public function comment_save($cid, $comment) {
    if(is_object($comment)){
      $comment = (array)$comment;
    }
    return $this->requestSend($this->_methods->COMMENT_SAVE, array($cid, $comment));
  }
  public function comment_delete($cid) {
   if (!is_array($cid)) {
      $cid = (array)$cid;
    } 
    $return = array();
    foreach ($cid as $id) {
      $return[] = $this->requestSend($this->_methods->COMMENT_DELETE, array($id));
    }
    return $return;
  }
  /*
    $page: The zero-based index of the page to get, defaults to 0.
    $fields: string, The fields to get.
    $parameters: array, Parameters array
    $pagesize: Number of records to get per page.
  */
  public function comment_list($page = 0, $fields = '*', $parameters = array(), $pagesize = 20){

      return $this->requestSend($this->_methods->COMMENT_LIST, array($page, $fields, $parameters, $pagesize));
  }
}
