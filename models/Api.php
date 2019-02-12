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

   public function create_site(string $url_site)
   {
      return $this->insert('list_site', [
         'url_site' => $url_site,
      ]);
   }

}