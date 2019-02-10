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

    public function addSite(string $url_site)
    {
        $add = $this->model_httpstatus->addSite($url_site);

        return $add;
    }

    public function getAllSites(string $url_site, int $status_site)
    {
       $sites = $this->model_httpstatus->showAllSites($url_site, $status_site);

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
