<?php
namespace models;

class Api extends \Model
{

   public function get_api_key()
   {
      return $this->get_one('admin');
   } 

   public function get_all_sites()
   {
      return $this->get('list_site');
   }

   public function get_one_site(int $id)
   {
      return $this->get_one('list_site', [
         'id' => $id
      ]);
   }
}