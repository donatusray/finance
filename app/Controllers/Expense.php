<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 02/04/2024
 * Time: 10:29
 */

namespace App\Controllers;


use App\Models\AccountsModel;
use App\Models\CategoryModel;
use App\Models\ExpenseModel;
use App\Models\MutationModel;

class Expense extends BaseController
{
    private $expenseModel;
    private $categoryModel;
    private $accountsModel;
    private $mutationModel;

    public function __construct()
    {
        $this->expenseModel = new ExpenseModel();
        $this->categoryModel = new CategoryModel();
        $this->accountsModel = new AccountsModel();
        $this->mutationModel = new MutationModel();
    }

    public function index()
    {
        $queryString = $_SERVER['QUERY_STRING'];
        session()->set('current_page', base_url('expense') . "?" . $queryString);

        $getCategory = $this->request->getGet('category');
        $getAccount = $this->request->getGet('account');
        $getFrom = ($this->request->getGet('from') != "") ? $this->request->getGet('from') : date('Y-m-d');
        $getTo = ($this->request->getGet('to') != "") ? $this->request->getGet('to') : date('Y-m-d');
        $listCategoryExpense = $this->categoryModel->listCategoryExpense();
        $listAccountExpense = $this->accountsModel->listAccountExpenseActive();
        $where[] = "e.expense_date between :from_date: and :to_date:";
        $value['from_date'] = $getFrom;
        $value['to_date'] = $getTo;

        if ($getCategory != "") {
            $where[] = "and e.category_id=:category_id:";
            $value['category_id'] = $getCategory;
        }
        if ($getAccount != "") {
            $where[] = "and e.account_id=:account_id:";
            $value['account_id'] = $getAccount;
        }

        $listExpense = $this->expenseModel->listExpenseCustom($where, $value);

        $data['categories'] = $listCategoryExpense;
        $data['accounts'] = $listAccountExpense;
        $data['expenses'] = $listExpense;
        $data['get_category'] = $getCategory;
        $data['get_account'] = $getAccount;
        $data['get_from'] = $getFrom;
        $data['get_to'] = $getTo;
        return view('list/expense_list', $data);
    }

    public function add()
    {
        $listCategoryExpense = $this->categoryModel->listCategoryExpenseNoParent();
        $listAccountExpense = $this->accountsModel->listAccountExpenseActive();
        $data['categories'] = $listCategoryExpense;
        $data['accounts'] = $listAccountExpense;
        return view('forms/expense_add', $data);
    }

    public function copy()
    {
        $id = $this->request->getGet('id');

        $expense = $this->expenseModel->getExpense($id);
        $listCategoryExpense = $this->categoryModel->listCategoryExpenseNoParent();
        $listAccountExpense = $this->accountsModel->listAccountExpenseActive();
        $data['categories'] = $listCategoryExpense;
        $data['accounts'] = $listAccountExpense;
        $data['expense'] = $expense;
        if (session()->getFlashdata('inputs') == null) {
            session()->setFlashdata('inputs', $expense);
        }

        return view('forms/expense_add', $data);
    }

    public function insert()
    {
        $data = array(
            'expense_date' => date('Y-m-d', strtotime($this->request->getPost('expense_date'))),
            'category_id' => $this->request->getPost('category_id'),
            'account_id' => $this->request->getPost('account_id'),
            'amount' => str_replace(",", "", $this->request->getPost('amount')),
            'expense_title' => $this->request->getPost('expense_title'),
            'expense_description' => $this->request->getPost('expense_description'),
            'createdby' => 1,
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('expense/add'));
        } else {
            $simpan = $this->expenseModel->insertExpense($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Insert Pengeluaran Berhasil');
                return redirect()->to(session()->get('current_page'));
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $expense = $this->expenseModel->getExpense($id);
        $listCategoryExpense = $this->categoryModel->listCategoryExpenseNoParent();
        $listAccountExpense = $this->accountsModel->listAccountExpenseActive();
        $data['categories'] = $listCategoryExpense;
        $data['accounts'] = $listAccountExpense;
        $data['expense'] = $expense;
        if (session()->getFlashdata('inputs') == null) {
            session()->setFlashdata('inputs', $expense);
        }
        return view('forms/expense_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $expenseBefore = $this->expenseModel->getExpense($id);
        $accountBefore = $this->accountsModel->getAccount($expenseBefore['account_id']);
        $mutationBefore = $this->mutationModel->getMutationByTypeAndIdTransaction('expense', $id);
        $data = array(
            'expense_date' => date('Y-m-d', strtotime($this->request->getPost('expense_date'))),
            'category_id' => $this->request->getPost('category_id'),
            'account_id' => $this->request->getPost('account_id'),
            'amount' => str_replace(",", "", $this->request->getPost('amount')),
            'expense_title' => $this->request->getPost('expense_title'),
            'expense_description' => $this->request->getPost('expense_description'),
            'updatedby' => 1,
            'updated' => date('Y-m-d h:i:s')
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('expense/edit') . "?id=" . $id);
        } else {
            $simpan = $this->expenseModel->updateExpense($data, $id);
            if ($simpan) {
                //update mutasi
                $dataMut['mutation_text'] = $this->request->getPost('expense_title');
                $dataMut['mutation_date'] = date('Y-m-d', strtotime($this->request->getPost('expense_date')));
                $dataMut['mutation_amount'] = str_replace(",", "", $this->request->getPost('amount'));
                $this->mutationModel->updateMutation($dataMut, $mutationBefore['id']);

                //update saldo
                $dataSaldo['updated'] = date('Y-m-d h:i:s');
                $dataSaldo['updatedby'] = 1;
                $dataSaldo['account_balance'] = $accountBefore['account_balance'] - (str_replace(",", "", $this->request->getPost('amount'))) + $expenseBefore['amount'];
                $this->accountsModel->updateAccount($dataSaldo, $this->request->getPost('account_id'));

                session()->setFlashdata('success', 'Update Pengeluaran Berhasil');
                return redirect()->to(session()->get('current_page'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');
        $expenseBefore = $this->expenseModel->getExpense($id);
        $accountBefore = $this->accountsModel->getAccount($expenseBefore['account_id']);
        $mutationBefore = $this->mutationModel->getMutationByTypeAndIdTransaction('expense', $id);

        //update saldo
        $dataSaldo['updated'] = date('Y-m-d h:i:s');
        $dataSaldo['updatedby'] = 1;
        $dataSaldo['account_balance'] = $accountBefore['account_balance'] + $expenseBefore['amount'];
        $this->accountsModel->updateAccount($dataSaldo, $accountBefore['account_id']);

        //delete mutasi
        $this->mutationModel->deleteMutation($mutationBefore['id']);

        //delete income
        $this->expenseModel->deleteExpense($id);

        //notif
        session()->setFlashdata('success', 'Delete Pengeluaran Berhasil');
        return redirect()->to(session()->get('current_page'));


    }

    private function getError($post)
    {
        $error = array();
        if ($post['expense_date'] == "") {
            $error[] = "Tanggal Pengeluaran Wajib Diisi";
        }
        if ($post['category_id'] == "") {
            $error[] = "Kategori Wajib Diisi";
        }
        if ($post['account_id'] == "") {
            $error[] = "Akun Pengeluaran Wajib Diisi";
        }
        if ($post['amount'] == "") {
            $error[] = "Nominal Pengeluaran Wajib Diisi";
        }
        if ($post['expense_title'] == "") {
            $error[] = "Nama Pengeluaran Wajib Diisi";
        }
        if ($post['amount'] == "0") {
            $error[] = "Nominal Pengeluaran tidak boleh 0";
        }

        return $error;
    }
} 