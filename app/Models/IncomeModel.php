<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 01/04/2024
 * Time: 09:46
 */

namespace App\Models;


use CodeIgniter\Model;

class IncomeModel extends Model
{
    protected $table = "income";

    public function listIncome()
    {
        $sql = "select * from " . $this->table . " order by income_date asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getIncome($id)
    {
        $sql = "select * from " . $this->table . " where id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function insertIncome($data)
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    public function updateIncome($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['id' => $id]);
    }

    public function deleteIncome($id)
    {
        return $this->db->table($this->table)->delete(['id' => $id]);
    }
} 