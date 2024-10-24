<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 15/08/2024
 * Time: 18:53
 */
namespace App\Models;

use CodeIgniter\Model;

class ViewTransactionModel extends Model
{
    protected $table = "view_transaction";

    public function totalIncomeToday()
    {
        $date = date('Y-m-d');
        $sql = "select case when (sum(amount) is null) then 0 else sum(amount) end total_amount from " . $this->table . " where tipe=:tipe_transaction: and tanggal=:tanggal:";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Income', 'tanggal' => $date]);
        return $query->getRowArray();
    }

    public function totalExpenseToday()
    {
        $date = date('Y-m-d');
        $sql = "select case when (sum(amount) is null) then 0 else sum(amount) end total_amount from " . $this->table . " where tipe=:tipe_transaction: and tanggal=:tanggal:";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Expense', 'tanggal' => $date]);
        return $query->getRowArray();
    }

    public function lineIncomeHarian($limit)
    {
        $sql = "select date_format(tanggal,'%Y-%m-%d') waktu,
case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction:
group by date_format(tanggal,'%Y-%m-%d')
order by date_format(tanggal,'%Y-%m-%d') desc limit :limit:";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Income', 'limit' => $limit]);
        return $query->getResultArray();
    }

    function lineExpenseHarian($limit)
    {
        $date = date('Y-m-d');
        $sql = "select date_format(tanggal,'%Y-%m-%d') waktu,
case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and tanggal < :tanggal:
group by date_format(tanggal,'%Y-%m-%d')
order by date_format(tanggal,'%Y-%m-%d') desc limit :limit:";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Expense', 'tanggal' => $date, 'limit' => $limit]);
        return $query->getResultArray();
    }

    public function totalIncomeMonthToday()
    {
        $date = date('Y-m');
        $sql = "select case when (sum(amount) is null) then 0 else sum(amount) end total_amount from " . $this->table . " where tipe=:tipe_transaction: and date_format(tanggal,'%Y-%m')=:bulan:";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Income', 'bulan' => $date]);
        return $query->getRowArray();
    }

    public function totalExpenseMonthToday()
    {
        $date = date('Y-m');
        $sql = "select case when (sum(amount) is null) then 0 else sum(amount) end total_amount from " . $this->table . " where tipe=:tipe_transaction: and date_format(tanggal,'%Y-%m')=:bulan:";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Expense', 'bulan' => $date]);
        return $query->getRowArray();
    }

    public function LineIncomeBulanan($limit)
    {
        $bulan = date("Ym");
        $sql = "select date_format(tanggal,'%Y-%m') waktu,
case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and date_format(tanggal,'%Y%m') < :bulan:
group by date_format(tanggal,'%Y-%m')
order by date_format(tanggal,'%Y-%m') desc
limit :limit:";
        $query = $this->db->query($sql, ['bulan' => $bulan, 'tipe_transaction' => 'Income', 'limit' => $limit]);
        return $query->getResultArray();
    }

    function LineExpenseBulanan($limit)
    {
        $bulan = date("Ym");
        $sql = "select date_format(tanggal,'%Y-%m') waktu,
case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and date_format(tanggal,'%Y%m') < :bulan:
group by date_format(tanggal,'%Y-%m')
order by date_format(tanggal,'%Y-%m') desc
limit :limit:";
        $query = $this->db->query($sql, ['bulan' => $bulan, 'tipe_transaction' => 'Expense', 'limit' => $limit]);
        return $query->getResultArray();
    }

    function categoryExpenseHarian()
    {
        $date = date('Y-m-d');
        $sql = "select kategori, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and tanggal = :tanggal:
group by kategori
order by total_amount desc";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Expense', 'tanggal' => $date]);
        return $query->getResultArray();
    }

    public function categoryExpenseBulanan()
    {
        $bulan = date("Ym");
        $sql = "select kategori, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction where tipe=:tipe_transaction: and date_format(tanggal,'%Y%m') = :bulan:
group by kategori
order by total_amount desc";
        $query = $this->db->query($sql, ['bulan' => $bulan, 'tipe_transaction' => 'Expense']);
        return $query->getResultArray();
    }

    function categoryIncomeHarian()
    {
        $date = date('Y-m-d');
        $sql = "select kategori, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and tanggal = :tanggal:
group by kategori
order by total_amount desc";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Income', 'tanggal' => $date]);
        return $query->getResultArray();
    }

    public function categoryIncomeBulanan()
    {
        $bulan = date("Ym");
        $sql = "select kategori, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction where tipe=:tipe_transaction: and date_format(tanggal,'%Y%m') = :bulan:
group by kategori
order by total_amount desc";
        $query = $this->db->query($sql, ['bulan' => $bulan, 'tipe_transaction' => 'Income']);
        return $query->getResultArray();
    }

    function accountExpenseHarian()
    {
        $date = date('Y-m-d');
        $sql = "select akun, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and tanggal = :tanggal:
group by akun
order by total_amount desc";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Expense', 'tanggal' => $date]);
        return $query->getResultArray();
    }

    public function accountExpenseBulanan()
    {
        $bulan = date("Ym");
        $sql = "select akun, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction where tipe=:tipe_transaction: and date_format(tanggal,'%Y%m') = :bulan:
group by akun
order by total_amount desc";
        $query = $this->db->query($sql, ['bulan' => $bulan, 'tipe_transaction' => 'Expense']);
        return $query->getResultArray();
    }

    function accountIncomeHarian()
    {
        $date = date('Y-m-d');
        $sql = "select akun, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and tanggal = :tanggal:
group by akun
order by total_amount desc";
        $query = $this->db->query($sql, ['tipe_transaction' => 'Income', 'tanggal' => $date]);
        return $query->getResultArray();
    }

    public function accountIncomeBulanan()
    {
        $bulan = date("Ym");
        $sql = "select akun, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction where tipe=:tipe_transaction: and date_format(tanggal,'%Y%m') = :bulan:
group by akun
order by total_amount desc";
        $query = $this->db->query($sql, ['bulan' => $bulan, 'tipe_transaction' => 'Income']);
        return $query->getResultArray();
    }
}