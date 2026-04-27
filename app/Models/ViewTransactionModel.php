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


    public function lineBulanan($limit, $tipe)
    {
        $bulan = date("Ym");
        $sql = "select date_format(tanggal,'%Y-%m') waktu,
case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and date_format(tanggal,'%Y%m') < :bulan:
group by date_format(tanggal,'%Y-%m')
order by date_format(tanggal,'%Y-%m') desc
limit :limit:";
        $value['limit'] = $limit;
        $value['bulan'] = $bulan;
        $value['tipe_transaction'] = $tipe;
        $query = $this->db->query($sql, $value);
        return $query->getResultArray();
    }

    public function categoryDataTransaction($tipe, $bulantahun = "bulan", $date)
    {
        $sql = "select kategori, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction where tipe=:tipe_transaction: ";
        if ($bulantahun == "bulan") {
            $sql .= " and date_format(tanggal,'%Y-%m') = :bulan: ";
            $value['bulan'] = $date;
        } else {
            $sql .= " and date_format(tanggal,'%Y') = :tahun: ";
            $value['tahun'] = $date;
        }
        $sql .= " group by kategori order by total_amount desc limit 10";
        $value['tipe_transaction'] = $tipe;
        $query = $this->db->query($sql, $value);
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

    public function accountExpenseTahunan()
    {
        $tahun = date("Y");
        $sql = "select akun, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction where tipe=:tipe_transaction: and date_format(tanggal,'%Y') = :tahun:
group by akun
order by total_amount desc";
        $query = $this->db->query($sql, ['tahun' => $tahun, 'tipe_transaction' => 'Expense']);
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

    public function accountDataTransaction($tipe, $bulantahun = "bulan", $date)
    {
        $tahun = date("Y");
        $sql = "select akun, case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction where tipe=:tipe_transaction: ";
        if ($bulantahun == "bulan") {
            $sql .= " and date_format(tanggal,'%Y-%m') = :bulan: ";
            $value['bulan'] = $date;
        } else {
            $sql .= " and date_format(tanggal,'%Y') = :tahun: ";
            $value['tahun'] = $date;
        }
        $value['tipe_transaction'] = $tipe;
        $sql .= "group by akun
order by total_amount desc";
        $query = $this->db->query($sql, $value);
        return $query->getResultArray();
    }

    public function totalDataTransaction($tipe, $bulantahun = "bulan", $date)
    {
        $sql = "select 
    case when (sum(amount) is null) then 0 else sum(amount) end total_amount 
from " . $this->table . " 
where tipe=:tipe_transaction: ";
        if ($bulantahun == "bulan") {
            $sql .= " and date_format(tanggal,'%Y-%m') = :bulan: ";
            $value['bulan'] = $date;
        } else {
            $sql .= " and date_format(tanggal,'%Y') = :tahun: ";
            $value['tahun'] = $date;
        }
        $value['tipe_transaction'] = $tipe;
        $query = $this->db->query($sql, $value);
        return $query->getRowArray();
    }

    public function lineTahunan($limit, $tipe)
    {
        $tahun = date("Y");
        $sql = "select date_format(tanggal,'%Y') waktu,
case when (sum(amount) is null) then 0 else sum(amount) end total_amount
from view_transaction
where tipe=:tipe_transaction: and date_format(tanggal,'%Y') < :tahun:
group by date_format(tanggal,'%Y')
order by date_format(tanggal,'%Y') desc
limit :limit:";
        $value['limit'] = $limit;
        $value['tahun'] = $tahun;
        $value['tipe_transaction'] = $tipe;
        $query = $this->db->query($sql, $value);
        return $query->getResultArray();
    }
}