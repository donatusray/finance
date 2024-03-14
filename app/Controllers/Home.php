<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if ($this->checkLogin() == false) {
            session()->setFlashdata('error_login', $this->alertLogin);
            return redirect()->to(base_url());
        }
        return view('home');
    }
}
