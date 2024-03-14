<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 05/03/2024
 * Time: 11:42
 */

namespace App\Controllers;


use App\Models\RoleMenuModel;

class RoleMenu extends BaseController
{
    private $roleMenuModel;

    public function __construct()
    {
        $this->roleMenuModel = new RoleMenuModel();
    }

    public function insert()
    {
        $roleId = $this->request->getPost('role_id');
        $menuId = $this->request->getPost('menu_id');
        $roleMenus = $this->roleMenuModel->selectRoleMenuByRole($roleId);
        if (count($roleMenus) > 0) {
            $this->roleMenuModel->deleteRoleMenuByIdRole($roleId);
        }
        if ($menuId) {
            foreach ($menuId as $mi) {
                $data['role_id'] = $roleId;
                $data['menu_id'] = $mi;
                $this->roleMenuModel->insertRoleMenu($data);
            }
        }
        session()->setFlashdata('success', 'Setting Menu Berhasil');
        return redirect()->to(base_url('roles'));
    }
} 