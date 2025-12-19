<?php

namespace App\Controllers;

use App\Models\AccountsModel;
use App\Models\BillModel;
use App\Models\ExpenseModel;
use App\Models\MutationCreditModel;
use App\Models\MutationModel;

class MutationCredit extends BaseController
{
    private $mutationCreditModel;
    private $accountsModel;
    private $mutationModel;
    private $expenseModel;
    private $billModel;

    public function __construct()
    {
        $this->mutationCreditModel = new MutationCreditModel();
        $this->accountsModel = new AccountsModel();
        $this->mutationModel = new MutationModel();
        $this->expenseModel = new ExpenseModel();
        $this->billModel = new BillModel();
    }

    public function delete()
    {
        $id = $this->request->getGet('id');
        $mutationCreditBefore = $this->mutationCreditModel->getMutationCreditById($id);
        $accountDebtBefore = $this->accountsModel->getAccount($mutationCreditBefore['account_debt_id']);
        $expenseBefore = $this->expenseModel->getExpense($mutationCreditBefore['transaction_id']);
        $mutationBefore = $this->mutationModel->getMutationByTypeAndIdTransaction('expense', $expenseBefore['id']);
        $billBefore = $this->billModel->getBill($mutationCreditBefore['bill_id']);
        if ($billBefore['status'] != 0) {
            session()->setFlashdata('errors', array("Bill Sudah Bukan Open Lagi"));
            return redirect()->to(base_url('bill/edit') . "?id=" . $billBefore['bill_id']);
        } else {
            $dataBill['updatedby'] = 1;
            $dataBill['updated'] = date('Y-m-d h:i:s');
            $dataBill['grand_total'] = $billBefore['grand_total'] - $expenseBefore['amount'];
            $this->billModel->updateBill($dataBill, $billBefore['bill_id']);

            if ($mutationCreditBefore['account_receivable_id'] != 0) {
                $accountReceivableBefore = $this->accountsModel->getAccount($mutationCreditBefore['account_receivable_id']);
                //update saldo receivable
                $dataSaldoReceivable['updated'] = date('Y-m-d h:i:s');
                $dataSaldoReceivable['updatedby'] = 1;
                $dataSaldoReceivable['account_balance'] = $accountReceivableBefore['account_balance'] - $expenseBefore['amount'];
                $this->accountsModel->updateAccount($dataSaldoReceivable, $mutationCreditBefore['account_debt_id']);
            }

            //update saldo
            $dataSaldo['updated'] = date('Y-m-d h:i:s');
            $dataSaldo['updatedby'] = 1;
            $dataSaldo['account_balance'] = $accountDebtBefore['account_balance'] + $expenseBefore['amount'];
            $this->accountsModel->updateAccount($dataSaldo, $mutationCreditBefore['account_debt_id']);

            //delete mutasi
            $this->mutationModel->deleteMutation($mutationBefore['id']);

            //delete mutasi before
            $this->mutationCreditModel->deleteMutation($id);

            //delete expense
            $this->expenseModel->deleteExpense($expenseBefore['id']);

            //notif
            session()->setFlashdata('success', 'Delete Item Tagihan Berhasil');
            return redirect()->to(base_url('bill/edit') . "?id=" . $billBefore['bill_id']);
        }

    }
}