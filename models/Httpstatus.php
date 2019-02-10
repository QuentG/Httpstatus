<?php
namespace models;

class Httpstatus extends \Model
{

   public function getOneSiteById(int $id)
   {
      return $this->get_one('list_site', [
         'id' => $id
      ]);
   } 

   /**
    * Show one site
    */
    public function showOneSite(int $id) 
    {
        return $this->get_one('list_site', [
           'id' => $id
        ]);
    }

   /**
    * Show all sites
    */
   public function showAllSites() 
   {
       return $this->get('list_site');
   }

   /**
    * Add a site
    */
   public function addSite(string $url_site, int $status_site)
   {
      return $this->insert('list_site', [
         'url_site' => $url_site,
         'status_site' => $status_site
      ]);
   }

   /**
    * Modify a site
    */
   public function modifySite(int $id, string $url_site, int $status_site)
   {
      return $this->update('list_site', [
         'url_site' => $url_site,
         'status_site' => $status_site
      ],
      [
         'id' => $id
      ]
   );
   }

   /**
    * Remove a site
    */
   public function removeSite(int $id)
   {
      return $this->delete('list_site', [
         'id' => $id
      ]);
   }

   /**
    * Login
    */
   public function get_admin(string $email, string $pwd) 
   {
      return $this->get_one('admin', [
         'email' => $email
      ]);
   }

   /**
    * Show historic
    */
   public function get_historic_site(int $id)
   {
      return $this->get('history_site', [
         'id_site' => $id
      ]);
   }

}