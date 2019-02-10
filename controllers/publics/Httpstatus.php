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
        $sites = $this->internal_httpstatus->getAllSites();

        return $this->render('httpstatus/home', [
            'sites' => $sites
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
        if($_GET['deconnexion'])
        {
            session_destroy();
            header('Location: ./login');
        }
        elseif($_GET['delete'])
        {
            $id = $_GET['delete'];
            $delete = $this->internal_httpstatus->deleteSite($id);

            header('Location: ./admin');
        }
        elseif($_SESSION['admin'])
        {
            $sites = $this->internal_httpstatus->getAllSites();

            return $this->render('httpstatus/admin/admin', [
                "admin" => $_SESSION['admin'],
                "sites" => $sites
            ]);
        }
        else
        {
            header('Location: ./login');
        }
    }

    public function add ()
    {
        $url_site = $_POST['url_site'] ?? false;

        if(!$url_site){
            return $this->render('httpstatus/admin/add');
        }
        else
        {
            $status_url = get_headers($url_site);
            $status = intval(substr($status_url[0], 9, -2));
    
            $sites = $this->internal_httpstatus->addSite($url_site, $status);
    
            if(!$sites)
            {
                return $this->render('httpstatus/admin/add');
            }
            else 
            {
                header('Location: ../admin');
            }
        }        
    }

    public function edit (int $id)
    {
        $update = $this->internal_httpstatus->updateSite($id);

        if(!$update)
        {
            return $this->render('httpstatus/admin/edit', [
                'success' => false
            ]);
        }
        else {
            
        }
    }

    public function show (int $id)
    {
        return $this->render('httpstatus/show', [
            "id" => $id
        ]);
    }
}