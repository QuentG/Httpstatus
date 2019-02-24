<?php
namespace controllers\internals;

use \models\Api as ModelApi;
use \models\Httpstatus as ModelHttpstatus;

class Api extends \InternalController
{
    public function __construct (\PDO $pdo)
    {
        $this->model_api = new ModelApi($pdo);
        $this->model_httpstatus = new ModelHttpstatus($pdo);
    }
    
    /**
     * Get the api_key
     */
    public function apiKey()
    {
        $api_key = $this->model_api->get_api_key();

        if($api_key)
        {
            return $api_key['api_key'];
        }
        else
        {
            return false;
        }
    }

    /**
     * Get all sites
     */
    public function getSites()
    {
        $sites = $this->model_api->get_all_sites();

        if($sites)
        {
            return $sites;
        }
        else
        {
            return false;
        }
    }

    public function getOneSite(int $id)
    {
        $site = $this->model_api->get_one_site($id);

        if($site)
        {
            return $site;
        }
        else
        {
            return false;
        }
    }

    public function getSiteByIdAndUrl(int $id, string $url_site)
    {
        $site = $this->model_api->get_site_by_id_url($id, $url_site);

        if($site)
        {
            return $site;
        }
        else
        {
            return false;
        }
    }
    public function getOneHistory(int $id)
    {
        $history = $this->model_api->get_one_history($id);

        if($history)
        {
            return $history;
        }
        else
        {
            return false;
        }
    }
    public function getHistory(int $id)
    {
        $history = $this->model_api->get_all_history($id);

        if($history)
        {
            return $history;
        }
        else
        {
            return false;
        }
    }

    public function addSite(string $url_site, int $status_site)
    {
        $site = $this->model_api->create_site($url_site, $status_site);

        if($site)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * Delete a site 
     */
    public function deleteSite(int $id)
    {
        $delete = $this->model_httpstatus->removeSite($id);

        if($delete)
        {
            return $delete;
        }
        else
        {
            return false;
        }
    }


}
