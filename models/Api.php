<?php
namespace models;

class Api extends \Model
{

   public function get_api_key()
   {
      return $this->get_one('admin');
   } 

}