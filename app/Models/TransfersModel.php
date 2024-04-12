<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 10/04/2024
 * Time: 22:38
 */

namespace App\Models;


use CodeIgniter\Model;

class TransfersModel extends Model
{
    protected $table = "transfers";

    public function listTransfers()
    {
        $sql = "select t.*, debet.account_name debet_name, credit.account_name credit_name from transfers t
                inner join accounts debet on debet.account_id=t.account_debet
                inner join accounts credit on credit.account_id=t.account_credit
                order by t.transfer_date asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getTransfer($id)
    {
        $sql = "select * from " . $this->table . " where id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function insertTransfer($data)
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    public function updateTransfer($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['id' => $id]);
    }

    public function deleteTransfer($id)
    {
        return $this->db->table($this->table)->delete(['id' => $id]);
    }
} 