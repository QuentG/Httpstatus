<?php
namespace controllers\publics;

use \controllers\internals\Api as InternalApi;

class Api extends \Controller
{
    public function __construct (\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->internal_api = new InternalApi($pdo);
    }

    public function home ()
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            return $this->render('api/home', [
                'success' => 'true'
            ]);
        }
        else
        {
            return $this->render('api/home', [
                'success' => 'false'
            ]);
        }
    }

    public function add ()
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            return $this->render('api/add', [
                'success' => 'true'
            ]);
        }
        else
        {
            return $this->render('api/add', [
                'success' => 'false'
            ]);
        }
    }

    public function list ()
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            return $this->render('api/list', [
                'success' => 'true'
            ]);
        }
        else
        {
            return $this->render('api/list', [
                'success' => 'false'
            ]);
        }
    }

    public function status ($id)
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            return $this->render('api/status', [
                'success' => 'true',
                'api' => $api_key
            ]);
        }
        else
        {
            return $this->render('api/status', [
                'success' => 'false'
            ]);
        }
    }

    public function delete ($id)
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            return $this->render('api/delete', [
                'success' => 'true'
            ]);
        }
        else
        {
            return $this->render('api/delete', [
                'success' => 'false'
            ]);
        }
    }
}