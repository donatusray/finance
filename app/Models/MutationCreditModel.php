<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 11/08/2025
 * Time: 17:24
 */

namespace App\Models;


use CodeIgniter\Model;

class MutationCreditModel extends Model
{
    protected $table = "mutation_credit";

    public function listMutation()
    {
        $sql = "select * from " . $this->table . " order by mutation_date asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function listMutationByAccountDate($from, $to, $account)
    {
        $sql = "select m.*, debet.account_name account_debet, credit.account_name account_credit
from mutation m
left join accounts debet on debet.account_id = m.account_id_income
left join accounts credit on credit.account_id = m.account_id_expense
where m.mutation_date between :from_date: and :to_date: ";
        if ($account != "") {
            $sql .= " and (m.account_id_income=:account_id: or m.account_id_expense=:account_id:)";
        }
        $sql .= " order by mutation_date asc ";
        $column['from_date'] = $from;
        $column['to_date'] = $to;
        if ($account != '') {
            $column['account_id'] = $account;
        }
        $query = $this->db->query($sql, $column);
        return $query->getResultArray();
    }

    public function getMutation($id)
    {
        $sql = "select * from " . $this->table . " where id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function getMutationByTypeAndIdTransaction($type, $idTransaction)
    {
        $sql = "select * from " . $this->table . " where mutation_type=:tipe: and id_transaction=:id_trans:";
        $query = $this->db->query($sql, ['tipe' => $type, 'id_trans' => $idTransaction]);
        return $query->getRowArray();
    }

    public function insertMutation($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateMutation($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['id' => $id]);
    }

    public function deleteMutation($id)
    {
        return $this->db->table($this->table)->delete(['id' => $id]);
    }
} 