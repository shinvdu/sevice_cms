<?php

class File extends Service {
  
  public function __construct($options){
    parent::__construct($options);
    $this->connect();
  }
  /*
    $file_contents: To return file contents or not.
  */
  public function file_load($fid, $file_contents = 1, $image_styles = false) {
    return (object)$this->requestSend($this->_methods->FILE_GET, array($fid, $file_contents, $image_styles));
  }

  public function file_create($file) {
    return (object)$this->requestSend($this->_methods->FILE_CREATE, array($file));
  }

  public function file_delete($fid) {
    if (!is_array($fid)) {
      $fid = (array)$fid;
    } 
    $return = array();
    foreach ($fid as $id) {
      $return[] = $this->requestSend($this->_methods->FILE_DELETE, array($id));
    }
    return $return;
  }
  /*
    $page: The zero-based index of the page to get, defaults to 0.
    $fields: string, The fields to get.
    $parameters: array, Parameters array
    $pagesize: Number of records to get per page.
  */
  public function file_list($page = 0, $fields = '*', $parameters = array(), $pagesize = 20){
      return $this->requestSend($this->_methods->FILE_LIST, array($page, $fields, $parameters, $pagesize));
  }
}
