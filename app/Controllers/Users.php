<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 07/03/2024
 * Time: 18:49
 */

namespace App\Controllers;


use App\Models\RolesModel;
use App\Models\UserModel;

class Users extends BaseController
{
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RolesModel();
    }

    public function index()
    {
        $listUser = $this->userModel->listUser();
        $data['list_user'] = $listUser;
        return view('list/user_list', $data);
    }

    public function profile()
    {
        $username = session()->get('username');
        $users = $this->userModel->getUsernameWithRoleName($username);
        $data['users'] = $users;
        return view('auth/profile', $data);
    }

    public function add()
    {
        $listRole = $this->roleModel->selectRoleUser();
        $data['roles'] = $listRole;
        return view('forms/user_add', $data);
    }

    public function insert()
    {
        $data = array(
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'createdby' => 1,
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('users/add'));
        } else {
            $simpan = $this->userModel->insertUser($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Insert Pengguna Berhasil');
                return redirect()->to(base_url('users'));
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $listRole = $this->roleModel->selectRoleUser();
        $users = $this->userModel->getUser($id);
        $data['roles'] = $listRole;
        $data['users'] = $users;
        session()->setFlashdata('inputs', $users);
        return view('forms/user_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('user_id');
        $data = array(
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'isactive' => ($this->request->getPost('isactive')) ? "Y" : "N",
            'updatedby' => 1,
            'updated' => date('Y-m-d H:i:s')
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('users/edit') . "?id=" . $id);
        } else {
            $simpan = $this->userModel->updateUser($data, $id);
            if ($simpan) {
                session()->setFlashdata('success', 'Update Pengguna Berhasil');
                return redirect()->to(base_url('users'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');
        if ($id == 1) {
            session()->setFlashdata('warning', 'Username superadmin tidak bisa dihapus!');
            return redirect()->to(base_url('users'));
        } else {
            $delete = $this->userModel->deleteUser($id);
            if ($delete) {
                session()->setFlashdata('success', 'Delete Pengguna Berhasil');
                return redirect()->to(base_url('users'));
            } else {
                session()->setFlashdata('warning', 'Delete Pengguna Gagal');
                return redirect()->to(base_url('users'));
            }
        }
    }

    public function usereditsingle()
    {
        $id = session()->get('user_id');
        $listRole = $this->roleModel->selectRoleUser();
        $users = $this->userModel->getUser($id);
        $data['roles'] = $listRole;
        $data['users'] = $users;
        session()->setFlashdata('inputs', $users);
        return view('forms/user_edit_single', $data);
    }

    public function updatesingle()
    {
        $id = $this->request->getPost('user_id');
        $data = array(
            'full_name' => $this->request->getPost('full_name'),
            'role_id' => $this->request->getPost('role_id'),
            'updatedby' => 1,
            'updated' => date('Y-m-d H:i:s')
        );

        $simpan = $this->userModel->updateUser($data, $id);
        if ($simpan) {
            session()->setFlashdata('success', 'Update Profil Berhasil');
            return redirect()->to(base_url('users/usereditsingle'));
        }
    }

    private function getError($post)
    {
        $error = array();
        if ($post['username'] == "") {
            $error[] = "Username Wajib Diisi";
        }
        if ($post['password'] == "") {
            $error[] = "Password Wajib Diisi";
        }
        if ($post['full_name'] == "") {
            $error[] = "Nama lengkap Wajib Diisi";
        }
        if ($post['role_id'] == "") {
            $error[] = "Role Wajib Diisi";
        }

        return $error;
    }


} 