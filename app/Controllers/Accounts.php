<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 08/03/2024
 * Time: 14:30
 */

namespace App\Controllers;


use App\Models\AccountsModel;

class Accounts extends BaseController
{
    private $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountsModel();
    }

    public function index()
    {
        $listAccount = $this->accountModel->listAccount();
        $data['list_account'] = $listAccount;
        return view('list/account_list', $data);
    }

    public function add()
    {
        return view('forms/account_add');
    }

    public function insert()
    {
        $data = array(
            'account_name' => $this->request->getPost('account_name'),
            'account_description' => $this->request->getPost('account_description'),
            'account_type' => $this->request->getPost('account_type'),
            'account_limit' => str_replace(",", "", $this->request->getPost('account_limit')),
            'createdby' => 1,
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('accounts/add'));
        } else {
            $simpan = $this->accountModel->insertAccount($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Insert Akun Berhasil');
                return redirect()->to(base_url('accounts'));
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $account = $this->accountModel->getAccount($id);
        $data['account'] = $account;
        session()->setFlashdata('inputs', $account);
        return view('forms/account_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('account_id');
        $data = array(
            'account_name' => $this->request->getPost('account_name'),
            'account_description' => $this->request->getPost('account_description'),
            'account_type' => $this->request->getPost('account_type'),
            'account_limit' => str_replace(",", "", $this->request->getPost('account_limit')),
            'account_active' => ($this->request->getPost('account_active')) ? "Y" : "N",
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('accounts/edit') . "?id=" . $id);
        } else {
            $simpan = $this->accountModel->updateAccount($data, $id);
            if ($simpan) {
                session()->setFlashdata('success', 'Update Akun Berhasil');
                return redirect()->to(base_url('accounts'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');
        $account = $this->accountModel->getAccount($id);
        if ($account['account_active'] == 'Y') {
            session()->setFlashdata('warning', 'Delete Akun Gagal, Akun masih aktif');
            return redirect()->to(base_url('accounts'));
        } else if ($account['account_balance'] != 0) {
            session()->setFlashdata('warning', 'Delete Akun Gagal, Saldo tidak sama dengan 0');
            return redirect()->to(base_url('accounts'));
        } else {
            $delete = $this->accountModel->deleteAccount($id);
            if ($delete) {
                session()->setFlashdata('success', 'Delete Akun Berhasil');
                return redirect()->to(base_url('accounts'));
            } else {
                session()->setFlashdata('warning', 'Delete Akun Gagal');
                return redirect()->to(base_url('accounts'));
            }
        }
    }

    private function getError($post)
    {
        $error = array();
        if ($post['account_name'] == "") {
            $error[] = "Nama Akun Wajib Diisi";
        }
        if ($post['account_type'] == "") {
            $error[] = "Tipe Akun Wajib Diisi";
        }

        return $error;
    }

} 