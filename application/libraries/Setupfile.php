<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setupfile {

  function send($number, $message)
  {
    $ci = & get_instance();
    $data=array("username"=>'fundoomomsonline@gmail.com',"hash"=>'9fb3b5cee6e058629fe3340d585e5d5e133f5501294de639a029acc756bf7473','apikey'=>false);
    $sender  = "TXTLCL";
    $numbers = array($number);
    $ci->load->library('textlocal',$data);

    $response = $ci->textlocal->sendSms($numbers, $message, $sender);
  return $response;
  }
}
