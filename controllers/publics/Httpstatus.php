<?php
namespace controllers\publics;

use \controllers\internals\Httpstatus as InternalHttpstatus;

class Httpstatus extends \Controller
{
    public function __construct (\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->internal_httpstatus = new InternalHttpstatus($pdo);
    }

    public function home ()
    {
        $toto = 'Bernard';

        return $this->render('httpstatus/home', [
            'prenom' => $toto,
        ]);
    }

    public function login ()
    {
        $email = $_POST['email'] ?? false;
        $pwd = $_POST['password'] ?? false;

        if (!$email || !$pwd)
        {
            return $this->render('httpstatus/login');
        }
        else
        {
            $login = $this->internal_httpstatus->get_login($email, $pwd);

            if (!$login)
            {
                return $this->render('httpstatus/login');
            }
            else{
                header("Location: ./admin");
            }
        }
    } 
    
    public function admin ()
    {
        return $this->render('httpstatus/admin');
    }

    public function add ()
    {
        return $this->render('httpstatus/add');
    }

    public function edit (int $id)
    {
        return $this->render('httpstatus/edit', [
            "id" => $id
        ]);
    }

    public function show (int $id)
    {
        return $this->render('httpstatus/show', [
            "id" => $id
        ]);
    }
}