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
        return $this->render('httpstatus/login');
    } 
    
    public function admin ()
    {
        return $this->render('httpstatus/admin');
    }

    public function add ()
    {
        return $this->render('httpstatus/add');
    }

    public function edit ()
    {
        return $this->render('httpstatus/edit');
    }

    public function show ()
    {
        return $this->render('httpstatus/show');
    }
}