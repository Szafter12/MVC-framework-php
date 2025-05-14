<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        if ($request->isPost()) {
            $registerModel = new RegisterModel();

            echo "<pre>";
            var_dump($request->getBody());
            echo "</pre>";
            exit;
            
            // return 'Handling post request for registration';
        }
        $this->setLayout('auth');
        return $this->render('register');
    }
}
