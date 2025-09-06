<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 02/04/2024
 * Time: 10:29
 */

namespace App\Controllers;


use App\Models\AccountsCreditDetailModel;
use App\Models\AccountsModel;
use App\Models\BillModel;
use App\Models\CategoryModel;
use App\Models\ExpenseModel;
use App\Models\MutationCreditModel;
use App\Models\MutationModel;

class Expense extends BaseController
{
    private $expenseModel;
    private $categoryModel;
    private $accountsModel;
    private $accountCreditDetailModel;
    private $mutationModel;
    private $mutationCreditModel;
    private $billModel;

    public function __construct()
    {
        $this->expenseModel = new ExpenseModel();
        $this->categoryModel = new CategoryModel();
        $this->accountsModel = new AccountsModel();
        $this->mutationModel = new MutationModel();
        $this->accountCreditDetailModel = new AccountsCreditDetailModel();
        $this->billModel = new BillModel();
        $this->mutationCreditModel = new MutationCreditModel();
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
                $this->checkInsertDebt($data, $simpan);
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

                $this->checkUpdateDebt($data, $id);
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

        //delete mutation credit
        $this->deleteCheckDebt($expenseBefore, $id);

        //notif
        session()->setFlashdata('success', 'Delete Pengeluaran Berhasil');
        return redirect()->to(session()->get('current_page'));
    }

    private function checkInsertDebt($expense, $expenseId)
    {
        $account = $this->accountsModel->getAccount($expense['account_id']);
        if ($account['is_credit'] == 1) {
            $accountDetail = $this->accountCreditDetailModel->getAccountCreditDetail($account['account_id']);
            $billingDate = date('Y-m-d', strtotime($expense['expense_date']));
            if ($accountDetail['billing_date'] == "END_MONTH") {
                $billingDate = date('Y-m-t', strtotime($billingDate));
            } else {
                $billingDate = date('Y-m', strtotime($billingDate)) . "-" . $accountDetail['billing_date'];
                if ($expense['expense_date'] > $billingDate) {
                    $billingDate = date('Y-m', strtotime('+1 month', strtotime($billingDate))) . "-" . $accountDetail['billing_date'];
                }
            }

            $checkCreateBill = $this->billModel->checkBill($expense['account_id'], $billingDate);
            if ($checkCreateBill) {
                $billId = $checkCreateBill['bill_id'];
                $data['grand_total'] = $checkCreateBill['grand_total'] + $expense['amount'];
                $data['updatedby'] = 1;
                $data['updated'] = date('Y-m-d h:i:s');
                $this->billModel->updateBill($data, $billId);
            } else {
                $dueDate = date('Y-m-d', strtotime($billingDate . ' + ' . $accountDetail['due_date'] . ' days'));
                $data['account_id'] = $expense['account_id'];
                $data['recording_date'] = $billingDate;
                $data['due_date'] = $dueDate;
                $data['grand_total'] = $expense['amount'];
                $data['createdby'] = 1;
                $data['updatedby'] = 1;
                $billId = $this->billModel->insertBill($data);
            }
            $mutation['account_debt_id'] = $expense['account_id'];
            $mutation['mutation_date'] = $expense['expense_date'];
            $mutation['mutation_description'] = $expense['expense_title'];
            $mutation['mutation_nominal'] = $expense['amount'];
            $mutation['bill_id'] = $billId;
            $mutation['transaction_id'] = $expenseId;
            $mutation['installment_total'] = 1;
            $mutation['installment_number'] = 1;
            $mutation['createdby'] = 1;
            $mutation['updatedby'] = 1;
            $this->mutationCreditModel->insertMutation($mutation);
        }
    }

    private function checkUpdateDebt($expense, $expenseId)
    {
        $account = $this->accountsModel->getAccount($expense['account_id']);
        if ($account['is_credit'] == 1) {
            $accountDetail = $this->accountCreditDetailModel->getAccountCreditDetail($account['account_id']);
            $billingDate = date('Y-m-d', strtotime($expense['expense_date']));
            if ($accountDetail['billing_date'] == "END_MONTH") {
                $billingDate = date('Y-m-t', strtotime($billingDate));
            } else {
                $billingDate = date('Y-m', strtotime($billingDate)) . "-" . $accountDetail['billing_date'];
                if ($expense['expense_date'] > $billingDate) {
                    $billingDate = date('Y-m', strtotime('+1 month', strtotime($billingDate))) . "-" . $accountDetail['billing_date'];
                }
            }

            $checkCreateBill = $this->billModel->checkBill($expense['account_id'], $billingDate);
            if ($checkCreateBill) {
                $billId = $checkCreateBill['bill_id'];
                $data['grand_total'] = $checkCreateBill['grand_total'] + $expense['amount'];
                $data['updatedby'] = 1;
                $data['updated'] = date('Y-m-d h:i:s');
                $this->billModel->updateBill($data, $billId);
            } else {
                $dueDate = date('Y-m-d', strtotime($billingDate . ' + ' . $accountDetail['due_date'] . ' days'));
                $data['account_id'] = $expense['account_id'];
                $data['recording_date'] = $billingDate;
                $data['due_date'] = $dueDate;
                $data['grand_total'] = $expense['amount'];
                $data['createdby'] = 1;
                $data['updatedby'] = 1;
                $billId = $this->billModel->insertBill($data);
            }
            $mutationCredit = $this->mutationCreditModel->getMutationByIdTransaction($expenseId);
            $mutationCredit['account_debt_id'] = $expense['account_id'];
            $mutationCredit['mutation_date'] = $expense['expense_date'];
            $mutationCredit['mutation_description'] = $expense['expense_title'];
            $mutationCredit['mutation_nominal'] = $expense['amount'];
            $mutationCredit['bill_id'] = $billId;
            $mutationCredit['transaction_id'] = $expenseId;
            $mutationCredit['updatedby'] = 1;
            $mutationCredit['updated'] = date('Y-m-d h:i:s');
            $this->mutationCreditModel->updateMutation($mutationCredit, $mutationCredit['mutation_credit_id']);
        }
    }

    private function deleteCheckDebt($expense, $expenseId)
    {
        $account = $this->accountsModel->getAccount($expense['account_id']);
        if ($account['is_credit'] == 1) {
            $mutationCredit = $this->mutationCreditModel->getMutationByIdTransaction($expenseId);
            if ($mutationCredit) {
                $this->mutationCreditModel->deleteMutation($mutationCredit['mutation_credit_id']);
            }
        }
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