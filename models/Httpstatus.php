<?php
namespace models;

class Httpstatus extends \Model
{

   /**
    * Show one site
    */
    public function getOneSiteById(int $id)
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

   public function updateStatus(int $id, int $status)
   {
      return $this->update('list_site', [
         'status_site' => $status
         ],
         [
            'id' => $id
         ]
      );
   }

   public function updateHistoric(int $id, int $status)
   {
      $update = (new \DateTime())->format('Y-m-d H:i:s');

      return $this->insert('history_site', [
         'id_site' => $id,
         'status_site' => $status,
         'update_site' => $update
         ]
      );
   }

}