<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 08/03/2024
 * Time: 14:31
 */

namespace App\Models;


use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $table = "accounts";

    public function listAccount()
    {
        $sql = "select * from " . $this->table . " order by account_name asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function listAccountIncomeActive()
    {
        $sql = "select * from " . $this->table . " where account_income=:account_income: and account_active=:active:";
        $query = $this->db->query($sql, ['account_income' => 'Y', 'active' => 'Y']);
        return $query->getResultArray();
    }

    public function listAccountExpenseActive()
    {
        $sql = "select * from " . $this->table . " where account_expense=:account_expense: and account_active=:active:";
        $query = $this->db->query($sql, ['account_expense' => 'Y', 'active' => 'Y']);
        return $query->getResultArray();
    }

    public function getAccount($id)
    {
        $sql = "select * from " . $this->table . " where account_id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function insertAccount($data)
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
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