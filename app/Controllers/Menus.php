<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 18/02/2024
 * Time: 01:18
 */

namespace App\Controllers;


use App\Models\MenusModel;

class Menus extends BaseController
{
    private $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenusModel();
    }

    public function index()
    {
        $listMenu = $this->menuModel->listData();
        $data['list_menu'] = $listMenu;
        return view('list/menu_list', $data);
    }

    public function add()
    {
        return view('forms/menu_add');
    }

    public function insert()
    {
        $data = array(
            'menu_name' => $this->request->getPost('menu_name'),
            'menu_link' => $this->request->getPost('menu_link'),
            'menu_icon' => $this->request->getPost('menu_icon'),
            'menu_description' => $this->request->getPost('menu_description'),
            'createdby' => 1,
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('menus/add'));
        } else {
            $simpan = $this->menuModel->insertMenu($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Insert Menu Berhasil');
                return redirect()->to(base_url('menus'));
            }
        }
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    private function getError($post)
    {
        $error = array();
        if ($post['menu_name'] == "") {
            $error[] = "Nama Menu Wajib Diisi";
        }
        if ($post['menu_link'] == "") {
            $error[] = "Link Menu Wajib Diisi";
        }

        return $error;
    }
} 