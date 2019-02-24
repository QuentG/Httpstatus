<?php
namespace controllers\internals;

use \models\Httpstatus as ModelHttpstatus;

class Httpstatus extends \InternalController
{
    public function __construct (\PDO $pdo)
    {
        $this->model_httpstatus = new ModelHttpstatus($pdo);
    }

    public function get_login($email, $pwd)
    {
        $login = $this->model_httpstatus->get_admin($email, $pwd);

        if ($login)
        {
            if($login['mdp'] === $pwd){
                return $login;
            }
        }
        else
        {
            return false;
        }
    }

    public function addSite(string $url_site, int $status_site)
    {
        $add = $this->model_httpstatus->addSite($url_site, $status_site);

        if($add)
        {
            return $add;
        }
        else
        {
            return false;
        }
    }

    public function getAllSites()
    {
       $sites = $this->model_httpstatus->showAllSites();

       if($sites)
       {
           return $sites;
       }
       else
       {
           return false;
       }

    }

    public function updateSite(int $id, string $url_site, int $status_site)
    {

        $site = $this->model_httpstatus->getOneSiteById($id);

        if (!$site)
        {
            return null;
        }

        $this->model_httpstatus->modifySite(
            $site['id'],
            $url_site,
            $status_site
        );

        return $url_site;

    }

    public function deleteSite(int $id)
    {
        $delete = $this->model_httpstatus->removeSite($id);

        if($delete)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getOneSite(int $id)
    {
        $one_site = $this->model_httpstatus->getOneSiteById($id);
        return $one_site;
    }

    public function showHistoric(int $id)
    {
        $historic = $this->model_httpstatus->get_historic_site($id);
        return $historic;
    }

    public function checkStatus()
    {
        $error_array = array();
        $all_site = $this->model_httpstatus->showAllSites();

        // Init le tableau d'erreur à 0
        foreach ($all_site as $key => $site) {
            $error_id = intval($site['id']);
            array_push($error_array, [
                'id' => $error_id,
                'error' => 0,
                'time' => 0
            ]);
        }


        while(true){
            sleep(120);

            foreach ($all_site as $key => $site) {
                $url = $site['url_site'];
                $id = $site['id'];
                $index = array_search($id, array_column($error_array, 'id')); 

                $status_url = get_headers($url);
                $status = intval(substr($status_url[0], 9, -2));

                $update_status = $this->model_httpstatus->updateStatus($id, $status);
                $update_historic = $this->model_httpstatus->updateHistoric($id, $status);

                if($status !== 200)
                {
                    $error_array[$index]['error'] += 1;
                }
                else
                {
                    $error_array[$index]['error'] = 0;
                }

                if($error_array[$index]['error'] == 3)
                {
                    if($error_array[$index]['time'] == 0)
                    {
                        $error_array[$index]['time'] = (new \DateTime())->format('Y-m-d H:i:s');
                        $error_array[$index]['error'] = 0;
                        sendMail($site['url_site'], $error_array[$index]['time']);
                    }
                    else
                    {
                        $limit = $error_array[$index]['time']+7200;
                        $current_time = (new \DateTime())->format('Y-m-d H:i:s');

                        if($current_time >= $limit){
                            $error_array[$index]['time'] = (new \DateTime())->format('Y-m-d H:i:s');
                            $error_array[$index]['error'] = 0;
                            sendMail($site['url_site'], $error_array[$index]['time']);
                        }
                    }
                }
            }

            echo 'check done';
        }
    }

    public function sendMail(string $url_site, datetime $date)
    {
        $headers = array(
            'From' => 'webmaster@httpstatus.fr',
            'Reply-to' => 'nobody@bye.fr',
            'Content-type' => 'text/plain' 
        );

        mail('deschaussettes@yopmail.com', 'Site K.O', 'Le site ' .$url_site. 'est K.O depuis '. $date .' ', $headers);
    }

}
