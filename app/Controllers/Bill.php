<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 12/08/2025
 * Time: 10:17
 */

namespace App\Controllers;


use App\Models\AccountsCreditDetailModel;
use App\Models\AccountsModel;
use App\Models\BillModel;
use App\Models\ExpenseModel;
use App\Models\MutationCreditModel;

class Bill extends BaseController
{
    private BillModel $billModel;
    private AccountsModel $accountModel;
    private MutationCreditModel $mutationCreditModel;
    private ExpenseModel $expenseModel;
    private AccountsModel $accountsModel;
    private AccountsCreditDetailModel $accountCreditDetailModel;


    public function __construct()
    {
        $this->billModel = new BillModel();
        $this->accountModel = new AccountsModel();
        $this->mutationCreditModel = new MutationCreditModel();
        $this->expenseModel = new ExpenseModel();
        $this->accountsModel = new AccountsModel();
        $this->accountCreditDetailModel = new AccountsCreditDetailModel();
    }

    public function index()
    {
        /*
         * status :
         * 0 : open
         * 1 : bayar
         * 2 : closed
         * */
        $queryString = $_SERVER['QUERY_STRING'];
        session()->set('current_page', base_url('bill') . "?" . $queryString);

        $data['bills'] = $this->billModel->listBill();
        return view('list/bill_list', $data);
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $bill = $this->billModel->getBill($id);
        $account = $this->accountModel->getAccount($bill['account_id']);
        $accountDebit = $this->accountModel->listAccountIncomeActive();
        $billItem = $this->mutationCreditModel->getMutationByBillId($id);
        $data['bill'] = $bill;
        $data['account'] = $account;
        $data['account_debit'] = $accountDebit;
        $data['bill_item'] = $billItem;
        return view('forms/bill_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $data = array(
            'recording_date' => date('Y-m-d', strtotime($this->request->getPost('recording_date'))),
            'due_date' => date('Y-m-d', strtotime($this->request->getPost('due_date'))),
            'status' => $this->request->getPost('status'),
            'updatedby' => 1,
            'updated' => date('Y-m-d h:i:s'),
            'payment' => str_replace(",", "", $this->request->getPost('payment')),
            'balance_start' => str_replace(",", "", $this->request->getPost('balance_start')),
            'balance_end' => str_replace(",", "", $this->request->getPost('balance_end')),
            'account_id' => $this->request->getPost('account_id'),
        );

        $dataErrors = $this->getError($data);
        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('bill/edit') . "?id=" . $id);
        } else {
            $simpan = $this->billModel->updateBill($data, $id);
            if ($simpan) {
                //insert mutation credit
                $paymentAmount = str_replace(",", "", $this->request->getPost('payment_amount'));
                if ($paymentAmount > 0) {
                    $paymentDate = date('Y-m-d', strtotime($this->request->getPost('payment_date')));
                    $paymentAccountId = $this->request->getPost('payment_account_id');
                    $paymentTitle = $this->request->getPost('payment_title');
                    $this->insertMutationCredit($paymentAmount, $paymentDate, $paymentAccountId, $paymentTitle, $data, $id);
                }

                session()->setFlashdata('success', 'Update Bill Berhasil');
                return redirect()->to(base_url('bill/edit') . "?id=" . $id);
            }
        }
    }

    public function getError($post)
    {
        $error = array();
        return $error;
    }

    public function insertMutationCredit($amount, $date, $accountId, $title, $dataBill, $idBill)
    {
        $mc['account_receivable_id'] = $accountId;
        $mc['mutation_date'] = $date;
        $mc['mutation_description'] = $title;
        $mc['mutation_nominal'] = $amount;
        $mc['bill_id'] = $idBill;
        $mc['createdby'] = 1;
        $mc['created'] = date('Y-m-d h:i:s');
        $mc['updatedby'] = 1;
        $mc['updated'] = date('Y-m-d h:i:s');
        $mc['category_id'] = 158; // harcode untuk pembayaran hutang kategori
        $mc['mutation_type'] = 'credit';
        $this->mutationCreditModel->insertMutation($mc);

        //insert expense
        $dataExpense = array(
            'expense_date' => $date,
            'category_id' => 158,
            'account_id' => $accountId,
            'amount' => $amount,
            'expense_title' => $mc['mutation_description'],
            'expense_description' => "",
            'createdby' => 1,
            'updatedby' => 1
        );
        $this->expenseModel->insertExpense($dataExpense);

        if ($dataBill['balance_end'] > 0 && $dataBill['due_date'] < date('Y-m-d')) {
            $dataExpense['account_id'] = $dataBill['account_id'];
            $this->createBillOrUpdate($dataExpense, $dataBill['balance_end']);
        }
    }

    public function createBillOrUpdate($expense, $saldoAkhir)
    {
        $account = $this->accountsModel->getAccount($expense['account_id']);
        if ($account['is_credit'] == 1) {
            $accountDetail = $this->accountCreditDetailModel->getAccountCreditDetail($account['account_id']);
            $billingDate = date('Y-m-d', strtotime($expense['expense_date']));
            if ($accountDetail['billing_date'] == "END_MONTH") {
                $billingDate = date('Y-m-t', strtotime($billingDate));
            } else if ($accountDetail['billing_date'] == "NOW") {
                $billingDate = date('Y-m-d', strtotime($billingDate));
            } else {
                $billingDate = date('Y-m', strtotime($billingDate)) . "-" . $accountDetail['billing_date'];
                if ($expense['expense_date'] > $billingDate) {
                    $billingDate = date('Y-m', strtotime('+1 month', strtotime($billingDate))) . "-" . $accountDetail['billing_date'];
                }
            }

            if ($accountDetail['due_date'] == "FIRST_NEXT_MONTH") {
                $nextMonth = strtotime('+1 month', strtotime($billingDate));
                $dueDate = date('Y-m-01', $nextMonth);
            } else {
                $dueDate = date('Y-m-d', strtotime($billingDate . ' + ' . $accountDetail['due_date'] . ' days'));
            }
            $checkCreateBill = $this->billModel->checkBill($expense['account_id'], $billingDate);
            if ($checkCreateBill) {
                $billId = $checkCreateBill['bill_id'];
                $data['balance_start'] = $saldoAkhir;
                $data['updatedby'] = 1;
                $data['updated'] = date('Y-m-d h:i:s');
                $this->billModel->updateBill($data, $billId);
            } else {
                $data['account_id'] = $expense['account_id'];
                $data['recording_date'] = $billingDate;
                $data['due_date'] = $dueDate;
                $data['balance_start'] = $saldoAkhir;
                $data['createdby'] = 1;
                $data['updatedby'] = 1;
                $this->billModel->insertBill($data);
            }
        }
    }
} 