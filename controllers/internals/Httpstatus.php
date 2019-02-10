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

    public function updateSite(int $id)
    {

        $site = $this->model_httpstatus->getOneSiteById($id);

        if (!$site)
        {
            return null;
        }
        else 
        {

        $this->model_httpstatus->modifySite(
            $site['id'],
            $site['url_site'],
            $site['status_site']
        );

        return $site['url_site'];

        }
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

}
