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
        $arrayLabelCategoryIncome = array();
        $arrayValueCategoryIncome = array();
        $arrayColorCategoryIncome = array();
        $arrayLabelCategoryExpense = array();
        $arrayValueCategoryExpense = array();
        $arrayColorCategoryExpense = array();
        $arrayLabelAccountIncome = array();
        $arrayValueAccountIncome = array();
        $arrayLabelAccountExpense = array();
        $arrayValueAccountExpense = array();
        $compareExpenseBefore = 0;
        $compareIncomeBefore = 0;

        if ($get_waktu == "harian") {
            $showIncome = $this->viewTransactionModel->totalIncomeToday();
            $showExpense = $this->viewTransactionModel->totalExpenseToday();
            $listIncome = $this->viewTransactionModel->lineIncomeHarian($limit);
            $listExpense = $this->viewTransactionModel->lineExpenseHarian($limit);
            $listCategoryIncome = $this->viewTransactionModel->categoryIncomeHarian();
            $listCategoryExpense = $this->viewTransactionModel->categoryExpenseHarian();
            $listAccountIncome = $this->viewTransactionModel->accountIncomeHarian();
            $listAccountExpense = $this->viewTransactionModel->accountExpenseHarian();
        } else if ($get_waktu == 'bulanan') {
            $showIncome = $this->viewTransactionModel->totalIncomeMonthToday();
            $showExpense = $this->viewTransactionModel->totalExpenseMonthToday();
            $listIncome = $this->viewTransactionModel->lineIncomeBulanan($limit);
            $listExpense = $this->viewTransactionModel->lineExpenseBulanan($limit);
            $listCategoryIncome = $this->viewTransactionModel->categoryIncomeBulanan();
            $listCategoryExpense = $this->viewTransactionModel->categoryExpenseBulanan();
            $listAccountIncome = $this->viewTransactionModel->accountIncomeBulanan();
            $listAccountExpense = $this->viewTransactionModel->accountExpenseBulanan();
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

        if (count($listCategoryExpense) > 0) {
            foreach ($listCategoryExpense as $lce) {
                $arrayLabelCategoryExpense[] = "'" . $lce['kategori'] . "'";
                $arrayValueCategoryExpense[] = $lce['total_amount'];
                $arrayColorCategoryExpense[] = "'#" . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT) . "'";
            }
        }
        if (count($listCategoryIncome) > 0) {
            foreach ($listCategoryIncome as $lci) {
                $arrayLabelCategoryIncome[] = "'" . $lci['kategori'] . "'";
                $arrayValueCategoryIncome[] = $lci['total_amount'];
                $arrayColorCategoryIncome[] = "'#" . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT) . "'";
            }
        }

        if (count($listAccountIncome) > 0) {
            foreach ($listAccountIncome as $lai) {
                $arrayLabelAccountIncome[] = "'" . $lai['akun'] . "'";
                $arrayValueAccountIncome[] = $lai['total_amount'];
            }
        }

        if (count($listAccountExpense) > 0) {
            foreach ($listAccountExpense as $lae) {
                $arrayLabelAccountExpense[] = "'" . $lae['akun'] . "'";
                $arrayValueAccountExpense[] = $lae['total_amount'];
            }
        }

        $data['show_income'] = number_format($showIncome['total_amount'], 0, '.', ',');
        $data['array_value_income'] = implode(",", $arrayValueIncome);
        $data['array_header_income'] = implode(",", $arrayHeaderIncome);
        $data['percent_income'] = round((($showIncome['total_amount'] - $compareIncomeBefore) / $compareIncomeBefore), 2) * 100;

        $data['show_expense'] = number_format($showExpense['total_amount'], 0, '.', ',');
        $data['array_value_expense'] = implode(",", $arrayValueExpense);
        $data['array_header_expense'] = implode(",", $arrayHeaderExpense);
        $data['percent_expense'] = round((($showExpense['total_amount'] - $compareExpenseBefore) / $compareExpenseBefore), 2) * 100;

        $data['array_value_category_expense'] = implode(",", $arrayValueCategoryExpense);
        $data['array_header_category_expense'] = implode(",", $arrayLabelCategoryExpense);
        $data['array_color_category_expense'] = implode(",", $arrayColorCategoryExpense);

        $data['array_value_category_income'] = implode(",", $arrayValueCategoryIncome);
        $data['array_header_category_income'] = implode(",", $arrayLabelCategoryIncome);
        $data['array_color_category_income'] = implode(",", $arrayColorCategoryIncome);

        $data['array_value_account_expense'] = implode(",", $arrayValueAccountExpense);
        $data['array_header_account_expense'] = implode(",", $arrayLabelAccountExpense);

        $data['array_value_account_income'] = implode(",", $arrayValueAccountIncome);
        $data['array_header_account_income'] = implode(",", $arrayLabelAccountIncome);

        $data['filter_waktu'] = $filterWaktu;
        $data['get_waktu'] = $get_waktu;

        return view('home', $data);
    }
}
