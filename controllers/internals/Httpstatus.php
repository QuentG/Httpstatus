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
            return true;
        }
        else
        {
            return false;
        }
    }

}
