<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 01/04/2024
 * Time: 16:37
 */

namespace App\Models;


use CodeIgniter\Model;

class MutationModel extends Model
{

    protected $table = "mutation";

    public function listMutation()
    {
        $sql = "select * from " . $this->table . " order by mutation_date asc";
        $query = $this->db->query($sql);
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