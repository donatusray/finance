<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 10/04/2024
 * Time: 22:38
 */

namespace App\Controllers;


use App\Models\AccountsModel;
use App\Models\MutationModel;
use App\Models\TransfersModel;

class Transfers extends BaseController
{
    private $transfersModel;
    private $accountsModel;
    private $mutationModel;

    public function __construct()
    {
        $this->transfersModel = new TransfersModel();
        $this->accountsModel = new AccountsModel();
        $this->mutationModel = new MutationModel();
    }

    public function index()
    {
        $getFrom = ($this->request->getGet('from') != "") ? $this->request->getGet('from') : date('Y-m-d');
        $getTo = ($this->request->getGet('to') != "") ? $this->request->getGet('to') : date('Y-m-d');
        $getAccountDebit = $this->request->getGet('debit');
        $getAccountCredit = $this->request->getGet('credit');

        $where[] = "t.transfer_date between :from_date: and :to_date:";
        $value['from_date'] = $getFrom;
        $value['to_date'] = $getTo;

        if ($getAccountDebit != "") {
            $where[] = " and t.account_debet=:debit:";
            $value['debit'] = $getAccountDebit;
        }

        if ($getAccountCredit != "") {
            $where[] = " and t.account_credit=:credit:";
            $value['credit'] = $getAccountCredit;
        }

        $listTransfer = $this->transfersModel->listTransfers($where, $value);
        $listAccountIncome = $this->accountsModel->listAccountIncomeActive();
        $listAccountExpense = $this->accountsModel->listAccountExpenseActive();
        $data['account_income'] = $listAccountIncome;
        $data['account_expense'] = $listAccountExpense;
        $data['get_from'] = $getFrom;
        $data['get_to'] = $getTo;
        $data['get_debit'] = $getAccountDebit;
        $data['get_credit'] = $getAccountCredit;
        $data['transfers'] = $listTransfer;
        return view('list/transfers_list', $data);
    }

    public function add()
    {
        $listAccountIncome = $this->accountsModel->listAccountIncomeActive();
        $listAccountExpense = $this->accountsModel->listAccountExpenseActive();
        $data['account_income'] = $listAccountIncome;
        $data['account_expense'] = $listAccountExpense;
        return view('forms/transfers_add', $data);
    }

    public function insert()
    {
        $data = array(
            'transfer_date' => date('Y-m-d', strtotime($this->request->getPost('transfer_date'))),
            'account_debet' => $this->request->getPost('account_debet'),
            'account_credit' => $this->request->getPost('account_credit'),
            'nominal' => str_replace(",", "", $this->request->getPost('nominal')),
            'transfer_description' => $this->request->getPost('transfer_description'),
            'createdby' => 1,
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('transfers/add'));
        } else {
            $simpan = $this->transfersModel->insertTransfer($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Insert Transfer Berhasil');
                return redirect()->to(base_url('transfers'));
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $transfer = $this->transfersModel->getTransfer($id);
        $accountIncome = $this->accountsModel->getAccount($transfer['account_debet']);
        $accountExpense = $this->accountsModel->getAccount($transfer['account_credit']);
        $data['ai'] = $accountIncome;
        $data['ae'] = $accountExpense;
        $data['transfer'] = $transfer;
        if (session()->getFlashdata('inputs') == null) {
            session()->setFlashdata('inputs', $transfer);
        }
        return view('forms/transfers_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $transferBefore = $this->transfersModel->getTransfer($id);
        $accountIncomeBefore = $this->accountsModel->getAccount($transferBefore['account_debet']);
        $accountExpenseBefore = $this->accountsModel->getAccount($transferBefore['account_credit']);
        $mutationBefore = $this->mutationModel->getMutationByTypeAndIdTransaction('transfers', $id);
        $data = array(
            'transfer_date' => date('Y-m-d', strtotime($this->request->getPost('transfer_date'))),
            'account_debet' => $this->request->getPost('account_debet'),
            'account_credit' => $this->request->getPost('account_credit'),
            'nominal' => str_replace(",", "", $this->request->getPost('nominal')),
            'transfer_description' => $this->request->getPost('transfer_description'),
            'updatedby' => 1,
            'updated' => date('Y-m-d h:i:s')
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('transfers/edit') . "?id=" . $id);
        } else {
            $simpan = $this->transfersModel->updateTransfer($data, $id);
            if ($simpan) {
                //update mutasi
                $dataMut['mutation_text'] = $this->request->getPost('transfer_description');
                $dataMut['mutation_date'] = date('Y-m-d', strtotime($this->request->getPost('transfer_date')));
                $dataMut['mutation_amount'] = str_replace(",", "", $this->request->getPost('nominal'));
                $this->mutationModel->updateMutation($dataMut, $mutationBefore['id']);

                //update saldo credit
                $dataSaldo['updated'] = date('Y-m-d h:i:s');
                $dataSaldo['updatedby'] = 1;
                $dataSaldo['account_balance'] = $accountExpenseBefore['account_balance'] - (str_replace(",", "", $this->request->getPost('nominal'))) + $transferBefore['nominal'];
                $this->accountsModel->updateAccount($dataSaldo, $this->request->getPost('account_credit'));

                //update saldo debet
                $dataSaldo['updated'] = date('Y-m-d h:i:s');
                $dataSaldo['updatedby'] = 1;
                $dataSaldo['account_balance'] = $accountIncomeBefore['account_balance'] - ($transferBefore['nominal'] - str_replace(",", "", $this->request->getPost('nominal')));
                $this->accountsModel->updateAccount($dataSaldo, $this->request->getPost('account_debet'));

                session()->setFlashdata('success', 'Update Transfer Berhasil');
                return redirect()->to(base_url('transfers'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');
        $transferBefore = $this->transfersModel->getTransfer($id);
        $accountDebetBefore = $this->accountsModel->getAccount($transferBefore['account_debet']);
        $accountCreditBefore = $this->accountsModel->getAccount($transferBefore['account_credit']);
        $mutationBefore = $this->mutationModel->getMutationByTypeAndIdTransaction('transfers', $id);

        //update saldo credit
        $dataSaldo['updated'] = date('Y-m-d h:i:s');
        $dataSaldo['updatedby'] = 1;
        $dataSaldo['account_balance'] = $accountCreditBefore['account_balance'] + $transferBefore['nominal'];
        $this->accountsModel->updateAccount($dataSaldo, $accountCreditBefore['account_id']);

        //update saldo debet
        $dataSaldo['updated'] = date('Y-m-d h:i:s');
        $dataSaldo['updatedby'] = 1;
        $dataSaldo['account_balance'] = $accountDebetBefore['account_balance'] - $transferBefore['nominal'];
        $this->accountsModel->updateAccount($dataSaldo, $accountDebetBefore['account_id']);

        //delete mutasi
        $this->mutationModel->deleteMutation($mutationBefore['id']);

        //delete transfer
        $this->transfersModel->deleteTransfer($id);

        //notif
        session()->setFlashdata('success', 'Delete transfer Berhasil');
        return redirect()->to(base_url('transfers'));
    }

    private function getError($post)
    {
        $error = array();
        if ($post['transfer_date'] == "") {
            $error[] = "Tanggal Transfer Wajib Diisi";
        }
        if ($post['account_debet'] == "") {
            $error[] = "Akun Transfer Tujuan Wajib Diisi";
        }

        if ($post['account_credit'] == "") {
            $error[] = "Akun Transfer Dari Wajib Diisi";
        }
        if ($post['nominal'] == "") {
            $error[] = "Nominal Transfer Wajib Diisi";
        }
        if ($post['nominal'] == "0") {
            $error[] = "Nominal Transfer tidak boleh 0";
        }
        if ($post['account_debet'] == $post['account_credit']) {
            $error[] = "Debet dan Credit tidak boleh sama";
        }

        return $error;
    }
}
