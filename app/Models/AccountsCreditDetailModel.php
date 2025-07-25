<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 24/07/2025
 * Time: 17:56
 */

namespace App\Models;


use CodeIgniter\Model;

class AccountsCreditDetailModel extends Model
{
    protected $table = "accounts_credit_detail";

    public function getAccountCreditDetail($id)
    {
        $sql = "select * from " . $this->table . " where account_id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function insertAccount($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateAccount($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['account_id' => $id]);
    }

    public function deleteAccount($id)
    {
        return $this->db->table($this->table)->delete(['account_id' => $id]);
    }
} 