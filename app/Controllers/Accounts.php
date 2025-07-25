<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 08/03/2024
 * Time: 14:30
 */

namespace App\Controllers;


use App\Models\AccountsCreditDetailModel;
use App\Models\AccountsModel;

class Accounts extends BaseController
{
    private $accountModel;
    private $accountsCreditDetailModel;

    public function __construct()
    {
        $this->accountModel = new AccountsModel();
        $this->accountsCreditDetailModel = new AccountsCreditDetailModel();
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
            'account_income' => ($this->request->getPost('account_income')) ? "Y" : "N",
            'account_expense' => ($this->request->getPost('account_expense')) ? "Y" : "N",
            'is_credit' => ($this->request->getPost('is_credit')) ? 1 : 0,
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
                if ($data['is_credit'] == 1) {
                    $datacr['account_id'] = $simpan;
                    $datacr['credit_limit'] = str_replace(",", "", $this->request->getPost('credit_limit'));
                    $datacr['billing_date'] = $this->request->getPost('billing_date');
                    $datacr['due_date'] = $this->request->getPost('due_date');
                    $datacr['createdby'] = 1;
                    $datacr['updatedby'] = 1;
                    $this->accountsCreditDetailModel->insertAccount($datacr);
                }
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
        if ($account['is_credit'] == 1) {
            $accountCredit = $this->accountsCreditDetailModel->getAccountCreditDetail($id);
            $data['account_credit'] = $accountCredit;
        }
        session()->setFlashdata('inputs', $account);
        return view('forms/account_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('account_id');
        $data = array(
            'account_name' => $this->request->getPost('account_name'),
            'account_description' => $this->request->getPost('account_description'),
            'account_active' => ($this->request->getPost('account_active')) ? "Y" : "N",
            'updatedby' => 1,
            'updated' => date('Y-m-d h:i:s'),
            'account_income' => ($this->request->getPost('account_income')) ? "Y" : "N",
            'account_expense' => ($this->request->getPost('account_expense')) ? "Y" : "N",
            'is_credit' => ($this->request->getPost('is_credit')) ? 1 : 0,
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('accounts/edit') . "?id=" . $id);
        } else {
            $simpan = $this->accountModel->updateAccount($data, $id);
            if ($simpan) {
                $checkDataAccount = $this->accountsCreditDetailModel->getAccountCreditDetail($id);
                if ($data['is_credit'] == 1) {
                    $datacr['account_id'] = $id;
                    $datacr['credit_limit'] = str_replace(",", "", $this->request->getPost('credit_limit'));
                    $datacr['billing_date'] = $this->request->getPost('billing_date');
                    $datacr['due_date'] = $this->request->getPost('due_date');
                    if ($checkDataAccount) {
                        $datacr['updatedby'] = 1;
                        $datacr['updated'] = date('Y-m-d h:i:s');
                        $this->accountsCreditDetailModel->updateAccount($datacr, $id);
                    } else {
                        $datacr['createdby'] = 1;
                        $datacr['updatedby'] = 1;
                        $this->accountsCreditDetailModel->insertAccount($datacr);
                    }
                } else {
                    if ($checkDataAccount) {
                        $this->accountsCreditDetailModel->deleteAccount($id);
                    }
                }
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
                $checkDataAccount = $this->accountsCreditDetailModel->getAccountCreditDetail($id);
                if ($checkDataAccount) {
                    $this->accountsCreditDetailModel->deleteAccount($id);
                }
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

        return $error;
    }

} 