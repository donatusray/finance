<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 02/03/2024
 * Time: 23:48
 */

namespace App\Models;


use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table = "roles";

    public function listData()
    {
        $sql = "select * from " . $this->table . " order by role_id asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function selectRoleUser()
    {
        $sql = "select * from " . $this->table . " where isactive=:active: order by role_name asc";
        $query = $this->db->query($sql, ['active' => 'Y']);
        return $query->getResultArray();
    }

    public function getRole($id)
    {
        $sql = "select * from " . $this->table . " where role_id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function insertRole($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateRole($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['role_id' => $id]);
    }

    public function deleteRole($id)
    {
        return $this->db->table($this->table)->delete(['role_id' => $id]);
    }

} 