<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 12/08/2025
 * Time: 10:17
 */

namespace App\Controllers;


use App\Models\AccountsModel;
use App\Models\BillModel;
use App\Models\MutationCreditModel;

class Bill extends BaseController
{
    private $billModel;
    private $accountModel;
    private $mutationCreditModel;

    public function __construct()
    {
        $this->billModel = new BillModel();
        $this->accountModel = new AccountsModel();
        $this->mutationCreditModel = new MutationCreditModel();
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
        $billItem = $this->mutationCreditModel->getMutationByBillId($id);
        $data['bill'] = $bill;
        $data['account'] = $account;
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
            'updated' => date('Y-m-d h:i:s')
        );

        $dataErrors = $this->getError($data);
        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('bill/edit') . "?id=" . $id);
        } else {
            $simpan = $this->billModel->updateBill($data, $id);
            if ($simpan) {
                session()->setFlashdata('success', 'Update Bill Berhasil');
                return redirect()->to(base_url('bill/edit') . "?id=" . $id);
            }
        }

    }

    public function getError($post)
    {
        $error = array();
        if ($post['payment'] > 0) {
            $error[] = "Tidak bisa update pembayaran karena sudah melakukan pembayaran";
        }
        return $error;
    }
} 