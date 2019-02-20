<?php
namespace controllers\publics;

use \controllers\internals\Api as InternalApi;
use \ApiController as ApiController;
use \Model as Model;

class Api extends \Controller
{
    public function __construct (\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->internal_api = new InternalApi($pdo);
        $this->controller_api = new ApiController($pdo);
        $this->model_api = new Model($pdo);
    }

    public function home ()
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            return $this->controller_api->json(array(
                'version' => 1,
                'list' => $_SERVER['SERVER_NAME'].'/httpstatus/api/list/'

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

        $url_site = htmlspecialchars($_POST['url_site']);

        if($api_key == $api_key_user)
        {
            if(!isset($url_site) || empty($url_site))
            {
                return $this->controller_api->json(array(
                    'success' => false,
                    'error' => 'Choose method POST or insert values'
                ));
            }
            else 
            {

                $status_url = get_headers($url_site);
                $status = intval(substr($status_url[0], 9, -2));

                $add = $this->internal_api->addSite($url_site, $status);
                
                // descartes/model/last_id()
                $id = $this->model_api->last_id();

                if($add && isset($url_site) && !empty($url_site))
                {
                    return $this->controller_api->json(array(
                        'success' => true,
                        'id' => $id,
                    ));
                }
                else
                {
                    return $this->controller_api->json(array(
                        'success' => false,
                        'error' => 'Do not insert in db'
                    ));
                }
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
                    'delete' => $_SERVER['SERVER_NAME'].'/httpstatus/api/delete/'.$site['id'],
                    'status' => $_SERVER['SERVER_NAME'].'/httpstatus/api/status/'.$site['id'],
                    'history' => $_SERVER['SERVER_NAME'].'/httpstatus/api/history/'.$site['id']
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

    public function status (int $id)
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            $status = $this->internal_api->getOneSite($id);
            $time = $this->internal_api->getHistory($id);

            if($status['id'] == $id)
            {           
                return $this->controller_api->json(array(
                    'id' => $id,
                    'url' => $status['url_site'],
                    'status' => [
                        'code' => $status['status_site'],
                        'at' => $time['update_site']
                    ]
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
                'api_key' => 'Not valid'
            ));
        }
    }

    public function history ($id)
    {
        $api_key_user = $_GET['api_key'] ?? false;
        $api_key = $this->internal_api->apiKey();

        if($api_key == $api_key_user)
        {
            $site = $this->internal_api->getOneSite($id);
            $history = $this->internal_api->getOneHistory($id);

            if($site['id'] == $id)
            {
                $array_history = array();
                foreach ($history as $key => $hist) {
                    array_push($array_history, [
                        'code' => $hist['status_site'],
                        'at' => $hist['update_site']
                    ]);
                }
                return $this->controller_api->json(array(
                    'id' => $id,
                    'url' =>$site['url_site'],
                    'status' => $array_history
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
                'api_key' => 'Not valid'
            ));
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
