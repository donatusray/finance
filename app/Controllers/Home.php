<?php

namespace App\Controllers;

use App\Models\ViewTransactionModel;

class Home extends BaseController
{
    private $viewTransactionModel;

    public function __construct()
    {
        $this->viewTransactionModel = new ViewTransactionModel();
    }

    public function index()
    {
        $limit = 3;
        $filterWaktu = array('harian', 'bulanan');
        $get_waktu = $this->request->getGet('waktu');
        if ($get_waktu == null) {
            $get_waktu = current($filterWaktu);
        }

        if ($this->checkLogin() == false) {
            session()->setFlashdata('error_login', $this->alertLogin);
            return redirect()->to(base_url());
        }

        $arrayHeaderIncome = array();
        $arrayValueIncome = array();
        $arrayHeaderExpense = array();
        $arrayValueExpense = array();
        $compareExpenseBefore = 0;
        $compareIncomeBefore = 0;

        if ($get_waktu == "harian") {
            $showIncome = $this->viewTransactionModel->totalIncomeToday();
            $showExpense = $this->viewTransactionModel->totalExpenseToday();
            $listIncome = $this->viewTransactionModel->lineIncomeHarian($limit);
            $listExpense = $this->viewTransactionModel->lineExpenseHarian($limit);
        } else if ($get_waktu == 'bulanan') {
            $showIncome = $this->viewTransactionModel->totalIncomeMonthToday();
            $showExpense = $this->viewTransactionModel->totalExpenseMonthToday();
            $listIncome = $this->viewTransactionModel->lineIncomeBulanan($limit);
            $listExpense = $this->viewTransactionModel->lineExpenseBulanan($limit);
        }

        if (count($listIncome) > 0) {
            for ($i = $limit - 1; $i >= 0; $i--) {
                $arrayHeaderIncome[] = "'" . $listIncome[$i]['waktu'] . "'";
                $arrayValueIncome[] = "'" . $listIncome[$i]['total_amount'] . "'";
            }
            $compareIncomeBefore = str_replace("'", "", end($arrayValueIncome));
        }

        if (count($listExpense) > 0) {
            for ($i = $limit - 1; $i >= 0; $i--) {
                $arrayHeaderExpense[] = "'" . $listExpense[$i]['waktu'] . "'";
                $arrayValueExpense[] = "'" . $listExpense[$i]['total_amount'] . "'";
            }
            $compareExpenseBefore = str_replace("'", "", end($arrayValueExpense));
        }

        $data['percent_income'] = round((($showIncome['total_amount'] - $compareIncomeBefore) / $compareIncomeBefore), 2) * 100;
        $data['show_income'] = number_format($showIncome['total_amount'], 0, '.', ',');
        $data['array_value_income'] = implode(",", $arrayValueIncome);
        $data['array_header_income'] = implode(",", $arrayHeaderIncome);

        $data['show_expense'] = number_format($showExpense['total_amount'], 0, '.', ',');
        $data['array_value_expense'] = implode(",", $arrayValueExpense);
        $data['array_header_expense'] = implode(",", $arrayHeaderExpense);
        $data['percent_expense'] = round((($showExpense['total_amount'] - $compareExpenseBefore) / $compareExpenseBefore), 2) * 100;

        $data['filter_waktu'] = $filterWaktu;
        $data['get_waktu'] = $get_waktu;

        return view('home', $data);
    }
}
