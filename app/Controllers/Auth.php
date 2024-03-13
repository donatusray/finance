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
            $getUsername = $this->user_model->get_username($userName);
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
                            $collapsed = "";
                            $expanded = "false";
                            $show = "";
                            $navSub = 1;
                            $active = "";
                            if ($nav == 1) {
                                $collapsed = "collapsed";
                                $expanded = "true";
                                $show = "show";
                                $active = "class='active'";
                            }
                            $menu .= '<li ' . $active . '>';
                            $menu .= '<a href="#form' . $nav . '" class="iq-waves-effect ' . $collapsed . '" data-toggle="collapse" aria-expanded="' . $expanded . '"><span
                            class="ripple rippleEffect"></span><i
                            class="' . $main['menu_icon'] . ' iq-arrow-left"></i><span>' . $main['menu_name'] . '</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>';
                            $menu .= '<ul id="form' . $nav . '" class="iq-submenu collapse ' . $show . '" data-parent="#iq-sidebar-toggle">';

                            foreach ($dataSubMenu as $sub) {
                                if ($navSub == 1 && $nav == 1) {
                                    $menu .= '<li ' . $active . '>';
                                } else {
                                    $menu .= '<li>';
                                }
                                $menu .= '<a href="' . $sub['menu_link'] . '"><i class="' . $sub['menu_link'] . '"></i>' . $sub['menu_name'] . '</a></li>';
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

}