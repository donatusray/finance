<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 12/02/2024
 * Time: 15:24
 */

namespace App\Controllers;


use App\Models\MenusModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->user_model = new UserModel();
        $this->menuModel = new MenusModel();
    }

    public function index()
    {

        if ($this->checkLogin() == false) {
            return view('auth/login');
        }
        return redirect()->to(base_url('home'));

    }

    public function loginprocess()
    {
        $userName = $this->request->getPost('uname');
        $password = $this->request->getPost('pwuse');

        if ($userName == '' && $password == '') {
            session()->setFlashdata('error_login', '<b>Error : </b>Username & password tidak boleh kosong');
            return redirect()->to(base_url());
        } else {
            $getUsername = $this->user_model->getUsernameWithRoleName($userName);
            if ($getUsername) {
                if ($password == $getUsername['password']) {
                    $menu = "";
                    $roleApp = $getUsername['role_id'];

                    $dataMenu = $this->menuModel->listDataParentWithRoleMenu($roleApp);
                    $nav = 1;
                    foreach ($dataMenu as $main) {
                        $dataSubMenu = trim($main['menu_link']) == '#' ? $this->menuModel->listDataChildWithRoleMenu($roleApp, $main['menu_id']) : NULL;
                        if (is_null($dataSubMenu)) {
                            $menu .= '<li class="nav-item">
                            <a id="' . $nav . '" data-nav="' . $nav . '" href="' . base_url($main['menu_link']) . '" class="nav-link menu-nav">
                                <i class="nav-icon ' . $main['menu_icon'] . '"></i>
                                <p style="margin-left:10px;">' . $main['menu_name'] . '</p>
                            </a>
                          </li>';
                        } else {
                            $navSub = 1;
                            $menu .= '<li id="' . $nav . '" >';
                            $menu .= '<a id="a' . $nav . '" href="#form' . $nav . '" class="iq-waves-effect menu-nav" data-toggle="collapse"><span
                            class="ripple rippleEffect"></span><i
                            class="' . $main['menu_icon'] . ' iq-arrow-left"></i><span>' . $main['menu_name'] . '</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>';
                            $menu .= '<ul id="form' . $nav . '" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">';

                            foreach ($dataSubMenu as $sub) {
                                if ($navSub == 1 && $nav == 1) {
                                    $menu .= '<li id="' . $nav . "-" . $navSub . '" >';
                                } else {
                                    $menu .= '<li id="' . $nav . "-" . $navSub . '">';
                                }
                                $menu .= '<a data-navsub="' . $nav . "-" . $navSub . '" href="' . $sub['menu_link'] . '" class="menu-navsub"><i class="' . $sub['menu_icon'] . '"></i>' . $sub['menu_name'] . '</a></li>';
                                $navSub++;
                            }

                            $menu .= '</ul></li>';
                        }
                        $nav++;
                    }
                    $sessionData = array(
                        'logged' => 1,
                        'akses_menu' => $menu,
                        'user_id' => $getUsername['user_id'],
                        'username' => $getUsername['username'],
                        'role_name' => $getUsername['role_name'],
                        'role_app' => $roleApp
                    );
                    session()->set($sessionData);
                    return redirect()->to(base_url());
                } else {
                    session()->setFlashdata('error_login', '<b>Error : </b>Password salah');
                    return redirect()->to(base_url());
                }
            } else {
                session()->setFlashdata('error_login', '<b>Error : </b>Username tidak terdaftar');
                return redirect()->to(base_url());
            }
        }
    }

    public function changepassword()
    {
        return view('auth/change_password');
    }

    public function changepasswordact()
    {
        $userId = session()->get('user_id');
        $passwordLama = $this->request->getPost('password_old');
        $passwordBaru = $this->request->getPost('password_new');
        $passwordConfirm = $this->request->getPost('password_confirm');

        $dataErrors = $this->getErrorChangePassword($passwordLama, $passwordBaru, $passwordConfirm, $userId);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('auth/changepassword'));
        } else {
            $simpan = $this->user_model->updateUser(array('password' => $passwordBaru), $userId);
            if ($simpan) {
                session()->setFlashdata('success', 'Pergantian Password Berhasil');
                return redirect()->to(base_url('auth/changepassword'));
            }
        }
    }

    public function getErrorChangePassword($passwordLama, $passwordBaru, $passwordConfirm, $userId)
    {
        $error = array();
        if ($passwordBaru != $passwordConfirm) {
            $error[] = "Password Baru dan Password Confirm tidak sama";
        }

        $getUser = $this->user_model->getUser($userId);
        if ($getUser['password'] != $passwordLama) {
            $error[] = "Password Lama Tidak Sama";
        }

        return $error;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }

}