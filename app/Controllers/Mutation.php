<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 22/04/2024
 * Time: 23:37
 */

namespace App\Controllers;


use App\Models\AccountsModel;
use App\Models\MutationModel;

class Mutation extends BaseController
{
    private $mutationModel;
    private $accountsModel;

    public function __construct()
    {
        $this->accountsModel = new AccountsModel();
        $this->mutationModel = new MutationModel();
    }

    public function index()
    {
        $getFrom = $this->request->getGet('from');
        $getTo = $this->request->getGet('to');
        $getAccount = $this->request->getGet('account');
        if ($getFrom == '') {
            $getFrom = date('Y-m-d');
        }
        if ($getTo == '') {
            $getTo = date('Y-m-d');
        }

        $mutation = $this->mutationModel->listMutationByAccountDate($getFrom, $getTo, $getAccount);

        $data['accounts'] = $this->accountsModel->listAccount();
        $data['get_to'] = $getTo;
        $data['get_from'] = $getFrom;
        $data['mutation'] = $mutation;
        return view('list/mutation_list', $data);
    }
} 