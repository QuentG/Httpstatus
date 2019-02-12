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
