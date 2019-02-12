<?php
namespace controllers\internals;

use \models\Api as ModelApi;

class Api extends \InternalController
{
    public function __construct (\PDO $pdo)
    {
        $this->model_api = new ModelApi($pdo);
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

}
