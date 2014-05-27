<?php

class Node extends Service
{
    public function node_load($nid) {
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
    }
}
