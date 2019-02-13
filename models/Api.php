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
         'id' => $id,
      ]);
   }

   public function get_site_by_id_url(int $id, string $url_site)
   {
      return $this->get_one('list_site', [
         'id' => $id,
         'url_site' => $url_site
      ]);
   }

   public function create_site(string $url_site, int $status)
   {
      return $this->insert('list_site', [
         'url_site' => $url_site,
         'status_site' => $status
      ]);
   }
}