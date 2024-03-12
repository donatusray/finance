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
            'account_name' => $this->request->getPost('menu_name'),
            'account_description' => $this->request->getPost('menu_link'),
            'account_type' => $this->request->getPost('menu_description'),
            'account_limit' => $this->request->getPost('menu_order'),
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