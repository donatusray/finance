<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 11/08/2025
 * Time: 16:39
 */

namespace App\Models;


use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table = "bill";

    public function listBill()
    {
        $sql = "select bill.*, accounts.account_name  from " . $this->table." inner join accounts on accounts.account_id = bill.account_id order by due_date asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function checkBill($accountId, $recordingDate)
    {
        $sql = "select * from " . $this->table . " where account_id=:account_id: and recording_date=:recording_date:";
        $query = $this->db->query($sql, ['account_id' => $accountId, 'recording_date' => $recordingDate]);
        return $query->getRowArray();
    }

    public function getBill($id)
    {
        $sql = "select * from " . $this->table . " where bill_id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function insertBill($data)
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    public function updateBill($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['bill_id' => $id]);
    }

    public function deleteBill($id)
    {
        return $this->db->table($this->table)->delete(['bill_id' => $id]);
    }
} 