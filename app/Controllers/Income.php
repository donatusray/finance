<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 01/04/2024
 * Time: 09:46
 */

namespace App\Controllers;


use App\Models\IncomeModel;

class Income extends BaseController{
    private $incomeModel;

    public function __construct()
    {
        $this->incomeModel = new IncomeModel();
    }

    public function index()
    {
        $listIncome = $this->incomeModel->listIncome();
        $data['incomes'] = $listIncome;
        return view('list/income_list', $data);
    }
} 