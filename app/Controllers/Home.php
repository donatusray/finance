<?php

namespace App\Controllers;

use App\Models\AccountsModel;
use App\Models\BillModel;
use App\Models\ViewTransactionModel;

class Home extends BaseController
{
    private $viewTransactionModel;
    private $billModel;
    private $accountModel;

    public function __construct()
    {
        $this->viewTransactionModel = new ViewTransactionModel();
        $this->billModel = new BillModel();
        $this->accountModel = new AccountsModel();
    }

    public function index()
    {
        $limit = 3;
        $dateNow = date('Y-m-d');
        $limitMaturity = 30;
        $limitMaturityDate = date('Y-m-d', strtotime("+$limitMaturity day", strtotime($dateNow)));
        $filterWaktu = array('bulanan', 'tahunan');
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
        $showHutang = $this->billModel->getTotalHutang();
        $showTagihan = $this->billModel->getTotalTagihan($limitMaturityDate);
        $showDataTagihan = $this->billModel->listTagihanWillMaturity($limitMaturityDate);
        $showAccount = $this->accountModel->totalAccountBalance(0);

        if ($get_waktu == "tahunan") {
            $showIncome = $this->viewTransactionModel->totalDataTransaction('Income', 'tahun', date('Y'));
            $showExpense = $this->viewTransactionModel->totalDataTransaction('Expense', 'tahun', date('Y'));
            $listIncome = $this->viewTransactionModel->lineTahunan($limit, 'Income');
            $listExpense = $this->viewTransactionModel->lineTahunan($limit, 'Expense');
            $listCategoryIncome = $this->viewTransactionModel->categoryDataTransaction('Income', 'tahun', date('Y'));
            $listCategoryExpense = $this->viewTransactionModel->categoryDataTransaction('Expense', 'tahun', date('Y'));
            $listAccountIncome = $this->viewTransactionModel->accountDataTransaction('Income', 'tahun', date('Y'));
            $listAccountExpense = $this->viewTransactionModel->accountDataTransaction('Expense', 'tahun', date('Y'));
        } else if ($get_waktu == 'bulanan') {
            $showIncome = $this->viewTransactionModel->totalDataTransaction('Income', 'bulan', date('Y-m'));
            $showExpense = $this->viewTransactionModel->totalDataTransaction('Expense', 'bulan', date('Y-m'));
            $listIncome = $this->viewTransactionModel->lineBulanan($limit, 'Income');
            $listExpense = $this->viewTransactionModel->lineBulanan($limit, 'Expense');
            $listCategoryIncome = $this->viewTransactionModel->categoryDataTransaction('Income', 'bulan', date('Y-m'));
            $listCategoryExpense = $this->viewTransactionModel->categoryDataTransaction('Expense', 'bulan', date('Y-m'));
            $listAccountIncome = $this->viewTransactionModel->accountDataTransaction('Income', 'bulan', date('Y-m'));
            $listAccountExpense = $this->viewTransactionModel->accountDataTransaction('Expense', 'bulan', date('Y-m'));
        }

        if (count($listIncome) > 0) {
            for ($i = $limit - 1; $i >= 0; $i--) {
                if (isset($listIncome[$i])) {
                    $arrayHeaderIncome[] = "'" . $listIncome[$i]['waktu'] . "'";
                    $arrayValueIncome[] = "'" . $listIncome[$i]['total_amount'] . "'";
                } else {
                    $arrayHeaderIncome[] = "''";
                    $arrayValueIncome[] = "'0'";
                }
            }
            $compareIncomeBefore = str_replace("'", "", end($arrayValueIncome));
        }


        if (count($listExpense) > 0) {
            for ($i = $limit - 1; $i >= 0; $i--) {
                if (isset($listExpense[$i])) {
                    $arrayHeaderExpense[] = "'" . $listExpense[$i]['waktu'] . "'";
                    $arrayValueExpense[] = "'" . $listExpense[$i]['total_amount'] . "'";
                } else {
                    $arrayHeaderExpense[] = "''";
                    $arrayValueExpense[] = "'0'";
                }
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

        $data['show_hutang'] = number_format($showHutang['total_hutang'], 0, '.', ',');
        $data['show_tagihan'] = number_format($showTagihan['total_tagihan'], 0, '.', ',');
        $data['show_account'] = number_format($showAccount['total_balance'], 0, '.', ',');
        $data['filter_waktu'] = $filterWaktu;
        $data['get_waktu'] = $get_waktu;
        $data['show_data_tagihan'] = $showDataTagihan;
        $data['show_data_account_no_tagihan'] = $this->accountModel->listAccountNotCredit();
        if ($get_waktu == 'tahunan') {
            $data['get_waktu_text'] = date('Y');
        } else {
            $data['get_waktu_text'] = date('F Y');
        }

        return view('home', $data);
    }
}
