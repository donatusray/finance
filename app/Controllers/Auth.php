<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 12/02/2024
 * Time: 15:24
 */

namespace App\Controllers;


use App\Models\UserModel;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->user_model = new UserModel();
    }

    public function index()
    {
        if ($this->checkLogin() == FALSE) {
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
            $getUsername = $this->user_model->get_username($userName);
            if ($getUsername) {
                $passwordForm = $this->preparePassword($password);
                $passwordDb = $this->preparePassword($getUsername['password']);
                if ($passwordForm == $passwordDb) {
                    $menu = "";
                    $roleApp = $getUsername['role_app'];
                    $dataMenu = $this->auth_model->getMenuRole($roleApp);
                    $nav = 1;
                    foreach ($dataMenu as $main) {
                        $dataSubMenu = trim($main['menu_link']) == '#' ? $this->auth_model->get_submenu($main['menu_id']) : NULL;
                        if (is_null($dataSubMenu)) {
                            $menu .= '<li class="nav-item">
                            <a id="' . $nav . '" data-nav="' . $nav . '" href="' . base_url($main['menu_link']) . '" class="nav-link menu-nav">
                                <i class="nav-icon ' . $main['menu_icon'] . '"></i>
                                <p style="margin-left:10px;">' . $main['menu_name'] . '</p>
                            </a>
                          </li>';
                        } else {
                            $navSub = 1;
                            $menu .= '<li id="menu' . $nav . '" class="nav-item has-treeview">';
                            $menu .= '<a id="' . $nav . '" data-nav="' . $nav . '" href="' . base_url($main['menu_link']) . '" class="nav-link menu-nav">
                            <i class="nav-icon ' . $main['menu_icon'] . '"></i>
                            <p style="margin-left:10px;">' . $main['menu_name'] . '<i class="fas fa-angle-left right"></i></p>
                          </a>';
                            $menu .= '<ul class="nav nav-treeview">';

                            foreach ($dataSubMenu as $sub) {
                                $menu .= '<li class="nav-item">
                                <a id="' . $nav . '-' . $navSub . '" data-navsub="' . $nav . '-' . $navSub . '" href="' . base_url($sub['menu_link']) . '" class="nav-link menu-navsub">
                                    <i class="nav-icon ' . $sub['menu_icon'] . '"></i>
                                    <p style="margin-left:10px;">' . $sub['menu_name'] . '</p>
                                </a>
                              </li>';
                                $navSub++;
                            }

                            $menu .= '</ul></li>';
                        }
                        $nav++;
                    }

                    $sessionData = array(
                        'logged' => TRUE,
                        'akses_menu' => $menu,
                        'user_id' => $getUsername['ad_user_id'],
                        'username' => $getUsername['name'],
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

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url());
    }

    private function preparePassword($password)
    {
        return base64_encode(hash('sha384', $password, true));
    }

    private function verifyPassword($password, $hash)
    {
        return password_verify($this->preparePassword($password), $hash);
    }
} 