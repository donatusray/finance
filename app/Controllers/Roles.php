<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 02/03/2024
 * Time: 23:47
 */

namespace App\Controllers;


use App\Models\RolesModel;

class Roles extends BaseController
{
    private $roleModel;

    public function __construct()
    {
        $this->roleModel = new RolesModel();
    }

    public function index()
    {
        $listRole = $this->roleModel->listData();
        $data['list_role'] = $listRole;
        return view('list/role_list', $data);
    }

    public function add()
    {
        return view('forms/role_add');
    }

    public function insert()
    {
        $data = array(
            'role_name' => $this->request->getPost('role_name'),
            'description' => $this->request->getPost('description'),
            'createdby' => 1,
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('roles/add'));
        } else {
            $simpan = $this->roleModel->insertRole($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Insert Role Berhasil');
                return redirect()->to(base_url('roles'));
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $roles = $this->roleModel->getRole($id);
        $data['roles'] = $roles;
        session()->setFlashdata('inputs', $roles);
        return view('forms/role_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('role_id');
        $data = array(
            'role_name' => $this->request->getPost('role_name'),
            'description' => $this->request->getPost('description'),
            'isactive' => ($this->request->getPost('isactive')) ? "Y" : "N",
            'updatedby' => 1,
            'updated' => date('Y-m-d H:i:s')
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('role/edit') . "?id=" . $id);
        } else {
            $simpan = $this->roleModel->updateRole($data, $id);
            if ($simpan) {
                session()->setFlashdata('success', 'Update Role Berhasil');
                return redirect()->to(base_url('roles'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');
        $delete = $this->roleModel->deleteRole($id);
        if ($delete) {
            session()->setFlashdata('success', 'Delete Role Berhasil');
            return redirect()->to(base_url('roles'));
        } else {
            session()->setFlashdata('warning', 'Delete Role Gagal');
            return redirect()->to(base_url('roles'));
        }
    }

    private function getError($post)
    {
        $error = array();
        if ($post['role_name'] == "") {
            $error[] = "Nama Role Wajib Diisi";
        }

        return $error;
    }
} 