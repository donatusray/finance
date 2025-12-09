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
} 