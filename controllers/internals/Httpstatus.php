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

}
