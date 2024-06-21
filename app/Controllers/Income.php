<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 01/04/2024
 * Time: 09:46
 */

namespace App\Controllers;


use App\Models\AccountsModel;
use App\Models\CategoryModel;
use App\Models\IncomeModel;
use App\Models\MutationModel;

class Income extends BaseController
{
    private $incomeModel;
    private $categoryModel;
    private $accountsModel;
    private $mutationModel;

    public function __construct()
    {
        $this->incomeModel = new IncomeModel();
        $this->categoryModel = new CategoryModel();
        $this->accountsModel = new AccountsModel();
        $this->mutationModel = new MutationModel();
    }

    public function index()
    {
        $queryString = $_SERVER['QUERY_STRING'];
        session()->set('current_page', base_url('income') . "?" . $queryString);

        $getCategory = $this->request->getGet('category');
        $getAccount = $this->request->getGet('account');
        $getFrom = ($this->request->getGet('from') != "") ? $this->request->getGet('from') : date('Y-m-d');
        $getTo = ($this->request->getGet('to') != "") ? $this->request->getGet('to') : date('Y-m-d');
        $listCategoryIncome = $this->categoryModel->listCategoryIncome();
        $listAccountIncome = $this->accountsModel->listAccountIncomeActive();
        $where[] = "i.income_date between :from_date: and :to_date:";
        $value['from_date'] = $getFrom;
        $value['to_date'] = $getTo;

        if ($getCategory != "") {
            $where[] = "and i.category_id=:category_id:";
            $value['category_id'] = $getCategory;
        }
        if ($getAccount != "") {
            $where[] = "and i.account_id=:account_id:";
            $value['account_id'] = $getAccount;
        }

        $listIncome = $this->incomeModel->listIncomeCustom($where, $value);

        $data['categories'] = $listCategoryIncome;
        $data['accounts'] = $listAccountIncome;
        $data['incomes'] = $listIncome;
        $data['get_category'] = $getCategory;
        $data['get_account'] = $getAccount;
        $data['get_from'] = $getFrom;
        $data['get_to'] = $getTo;

        return view('list/income_list', $data);
    }

    public function add()
    {
        $listCategoryIncome = $this->categoryModel->listCategoryIncome();
        $listAccountIncome = $this->accountsModel->listAccountIncomeActive();
        $data['categories'] = $listCategoryIncome;
        $data['accounts'] = $listAccountIncome;
        return view('forms/income_add', $data);
    }

    public function insert()
    {
        $data = array(
            'income_date' => date('Y-m-d', strtotime($this->request->getPost('income_date'))),
            'category_id' => $this->request->getPost('category_id'),
            'category_name' => $this->request->getPost('category_name'),
            'account_id' => $this->request->getPost('account_id'),
            'amount' => str_replace(",", "", $this->request->getPost('amount')),
            'income_title' => $this->request->getPost('income_title'),
            'income_description' => $this->request->getPost('income_description'),
            'createdby' => 1,
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('income/add'));
        } else {
            $simpan = $this->incomeModel->insertIncome($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Insert Pemasukan Berhasil');
                return redirect()->to(session()->get('current_page'));
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $income = $this->incomeModel->getIncome($id);
        $listCategoryIncome = $this->categoryModel->listCategoryIncome();
        $listAccountIncome = $this->accountsModel->listAccountIncomeActive();
        $data['categories'] = $listCategoryIncome;
        $data['accounts'] = $listAccountIncome;
        $data['income'] = $income;
        if (session()->getFlashdata('inputs') == null) {
            session()->setFlashdata('inputs', $income);
        }
        return view('forms/income_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $incomeBefore = $this->incomeModel->getIncome($id);
        $accountBefore = $this->accountsModel->getAccount($incomeBefore['account_id']);
        $mutationBefore = $this->mutationModel->getMutationByTypeAndIdTransaction('income', $id);
        $data = array(
            'income_date' => date('Y-m-d', strtotime($this->request->getPost('income_date'))),
            'category_id' => $this->request->getPost('category_id'),
            'category_name' => $this->request->getPost('category_name'),
            'account_id' => $this->request->getPost('account_id'),
            'amount' => str_replace(",", "", $this->request->getPost('amount')),
            'income_title' => $this->request->getPost('income_title'),
            'income_description' => $this->request->getPost('income_description'),
            'updatedby' => 1,
            'updated' => date('Y-m-d h:i:s')
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('income/edit') . "?id=" . $id);
        } else {
            $simpan = $this->incomeModel->updateIncome($data, $id);
            if ($simpan) {
                //update mutasi
                $dataMut['mutation_text'] = $this->request->getPost('income_title');
                $dataMut['mutation_date'] = date('Y-m-d', strtotime($this->request->getPost('income_date')));
                $dataMut['mutation_amount'] = str_replace(",", "", $this->request->getPost('amount'));
                $this->mutationModel->updateMutation($dataMut, $mutationBefore['id']);

                //update saldo
                $dataSaldo['updated'] = date('Y-m-d h:i:s');
                $dataSaldo['updatedby'] = 1;
                $dataSaldo['account_balance'] = $accountBefore['account_balance'] - ($incomeBefore['amount'] - str_replace(",", "", $this->request->getPost('amount')));
                $this->accountsModel->updateAccount($dataSaldo, $this->request->getPost('account_id'));

                session()->setFlashdata('success', 'Update Pemasukan Berhasil');
                return redirect()->to(session()->get('current_page'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');
        $incomeBefore = $this->incomeModel->getIncome($id);
        $accountBefore = $this->accountsModel->getAccount($incomeBefore['account_id']);
        $mutationBefore = $this->mutationModel->getMutationByTypeAndIdTransaction('income', $id);

        //update saldo
        $dataSaldo['updated'] = date('Y-m-d h:i:s');
        $dataSaldo['updatedby'] = 1;
        $dataSaldo['account_balance'] = $accountBefore['account_balance'] - $incomeBefore['amount'];
        $this->accountsModel->updateAccount($dataSaldo, $accountBefore['account_id']);

        //delete mutasi
        $this->mutationModel->deleteMutation($mutationBefore['id']);

        //delete income
        $this->incomeModel->deleteIncome($id);

        //notif
        session()->setFlashdata('success', 'Delete Pemasukan Berhasil');
        return redirect()->to(session()->get('current_page'));


    }

    private function getError($post)
    {
        $error = array();
        if ($post['income_date'] == "") {
            $error[] = "Tanggal Pemasukan Wajib Diisi";
        }
        if ($post['category_id'] == "") {
            $error[] = "Kategori Wajib Diisi";
        }
        if ($post['account_id'] == "") {
            $error[] = "Akun Pemasukan Wajib Diisi";
        }
        if ($post['amount'] == "") {
            $error[] = "Nominal Pemasukan Wajib Diisi";
        }
        if ($post['income_title'] == "") {
            $error[] = "Nama Pemasukan Wajib Diisi";
        }
        if ($post['amount'] == "0") {
            $error[] = "Nominal Pemasukan tidak boleh 0";
        }

        return $error;
    }
} 