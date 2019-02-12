<?php
namespace controllers\publics;

use \controllers\internals\Api as InternalApi;
use \ApiController as ApiController;

class Api extends \Controller
{
    public function __construct (\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->internal_api = new InternalApi($pdo);
        $this->controller_api = new ApiController($pdo);
    }

    public function home ()
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            return $this->controller_api->json(array(
                'version' => 1,
                'list' => $_SERVER['SERVER_NAME'].'/Httpstatus/api/list/'

            ));
        }
        else
        {
            return $this->controller_api->json(array(
                'success' => false,
                'api_key' => 'Not valid'
            ));
        }
    }

    public function add ()
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {

            $add = $this->model_api->create(htmlspecialchars($_POST['url_site']));
            // descartes/model/last_id()
            $id = $this->model_api->last_id();

            if($add === true && !$id === null || empty($id))
            {
                return $this->controller_api->json(array(
                    'success' => true,
                    'id' => $id
                ));
            }
            else
            {
                return $this->controller_api->json(array(
                    'success' => false
                ));
            }

        }
        else
        {
            return $this->controller_api->json(array(
                'success' => false,
                'api_key' => 'Not valid'
            ));
        }
    }

    public function list ()
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            $sites = $this->internal_api->getSites();

            $websites = array();

            foreach($sites as $key => $site){
                $array_site = [
                    'id' => $site['id'],
                    'url' => $site['url_site'],
                    'delete' => $_SERVER['SERVER_NAME'].'/Httpstatus/api/delete/'.$site['id'],
                    'status' => $_SERVER['SERVER_NAME'].'/Httpstatus/api/status/'.$site['id'],
                    'history' => $_SERVER['SERVER_NAME'].'/Httpstatus/api/history/'.$site['id']
                ];
                array_push($websites, $array_site);
            }

            return $this->controller_api->json(array(
                'version' => 1,
                'websites' => $websites

            ));
        }
        else
        {
            return $this->controller_api->json(array(
                'success' => false,
                'api_key' => 'Not valid'
            ));
        }
    }

    public function status ($id)
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            return $this->render('api/status', [
                'success' => true,
                'api' => $api_key
            ]);
        }
        else
        {
            return $this->render('api/status', [
                'success' => false
            ]);
        }
    }

    public function delete (int $id)
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            $deleteSite = $this->internal_api->deleteSite($id);
            
            if($deleteSite)
            {
                return $this->controller_api->json(array(
                    'success' => true,
                    'id' => $id
                ));
            }
            else
            {
                return $this->controller_api->json(array(
                    'success' => false,
                    'id' => 'ID not valid'
                ));
            }
        }
        else
        {
            return $this->controller_api->json(array(
                'success' => false,
                'api_key' => 'Not Valid'
            ));
        }
    }
}