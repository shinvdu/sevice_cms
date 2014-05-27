<?php

class TestService extends Service
{
    public function test(){
//        return $this->requestSend($this->_methods->NODE_GET, array('aa' => 34, 'bb' => 56));
          $result = $this->requestSend($this->_methods->CONNECT);
          if ($result) {
              echo 'yes'.print_r($result);
          }else {
              echo 'no';
          }
    }
    public function test2($nid){
          $result = $this->requestSend($this->_methods->CONNECT);
          $result = $this->requestSend($this->_methods->LOGIN, array(
                $this->_options['username'],
                $this->_options['password'],
            ));
          exit(print_r($result));
        return $this->requestSend($this->_methods->USER_LOAD, array($nid));
    }
    public function test3(){
        $this->_options['endpoint'] = 'http://ted.sky-city.me/services/session/token';
        return $this->_options['token'] = $this->requestSend('', array(),true);
    }
    

}
