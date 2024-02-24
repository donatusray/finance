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
        $listMenuParent = $this->menuModel->listDataParent();
        $data['parents'] = $listMenuParent;
        return view('forms/menu_add', $data);
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
        if ($this->request->getPost('menu_parent') != '') {
            $data['menu_parent'] = $this->request->getPost('menu_parent');
        }

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
        $id = $this->request->getGet('id');
        $listMenuParent = $this->menuModel->listDataParent();
        $menus = $this->menuModel->getMenu($id);
        $data['parents'] = $listMenuParent;
        $data['menus'] = $menus;
        session()->setFlashdata('inputs', $menus);
        return view('forms/menu_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('menu_id');
        $data = array(
            'menu_name' => $this->request->getPost('menu_name'),
            'menu_link' => $this->request->getPost('menu_link'),
            'menu_icon' => $this->request->getPost('menu_icon'),
            'menu_description' => $this->request->getPost('menu_description'),
            'updatedby' => 1,
            'updated' => date('Y-m-d H:i:s')
        );

        $data['menu_parent'] = ($this->request->getPost('menu_parent') != '') ? $this->request->getPost('menu_parent') : null;

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('menus/edit') . "?id=" . $id);
        } else {
            $simpan = $this->menuModel->updateMenu($data, $id);
            if ($simpan) {
                session()->setFlashdata('success', 'Update Menu Berhasil');
                return redirect()->to(base_url('menus'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');
        $delete = $this->menuModel->deleteMenu($id);
        if ($delete) {
            session()->setFlashdata('success', 'Delete Menu Berhasil');
            return redirect()->to(base_url('menus'));
        } else {
            session()->setFlashdata('warning', 'Delete Menu Gagal');
            return redirect()->to(base_url('menus'));
        }
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