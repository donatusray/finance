<?php

namespace App\Controllers;

class MutationCredit extends BaseController
{
    public function cancel()
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
}