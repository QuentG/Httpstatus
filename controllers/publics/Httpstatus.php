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

        if($_SESSION['admin']){
            header('Location: ./admin');
        }
        elseif (!$email || !$pwd)
        {
            return $this->render('httpstatus/login', [
                "success" => true
            ]);
        }
        else
        {
            $admin = $this->internal_httpstatus->get_login($email, $pwd);

            if (!$admin)
            {
                return $this->render('httpstatus/login', [
                    "success" => false
                ]);
            }
            else
            {
                session_start();
                $_SESSION['admin'] = $admin;
                header('location: ./admin');
            }
        }
    } 
    
    public function admin ()
    {
        if($_GET['deconnexion']){
            session_destroy();
            header('Location: ./login');
        }
        elseif($_SESSION['admin'])
        {
            return $this->render('httpstatus/admin', [
                "admin" => $_SESSION['admin']
            ]);
        }
        else
        {
            header('Location: ./login');
        }
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