<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 02/04/2024
 * Time: 10:27
 */

namespace App\Models;


use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table = "expense";

    public function listExpense()
    {
        $sql = "select e.*,a.account_name
from " . $this->table . " e
inner join accounts a on a.account_id=e.account_id
order by e.expense_date asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function listExpenseCustom($where, $value)
    {
        $sql = "select e.*,a.account_name
from " . $this->table . " e
inner join accounts a on a.account_id=e.account_id ";
        if (count($where) > 0) {
            $sql .= " where " . implode(" ", $where);
        }
        $sql .= " order by e.expense_date asc";
        if (count($value) > 0) {
            $query = $this->db->query($sql, $value);
        } else {
            $query = $this->db->query($sql);
        }

        return $query->getResultArray();
    }

    public function getExpense($id)
    {
        $sql = "select * from " . $this->table . " where id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function insertExpense($data)
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    public function updateExpense($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['id' => $id]);
    }

    public function deleteExpense($id)
    {
        return $this->db->table($this->table)->delete(['id' => $id]);
    }
} 