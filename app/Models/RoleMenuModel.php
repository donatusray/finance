<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 05/03/2024
 * Time: 11:35
 */

namespace App\Models;


use CodeIgniter\Model;

class RoleMenuModel extends Model
{
    protected $table = "role_menu";

    public function insertRoleMenu($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function selectRoleMenuByRole($idRole)
    {
        $sql = "select * from " . $this->table . " where role_id=:role_id:";
        $query = $this->db->query($sql, ['role_id' => $idRole]);
        return $query->getResultArray();
    }

    public function deleteRoleMenu($id)
    {
        return $this->db->table($this->table)->delete(['role_menu_id' => $id]);
    }

    public function deleteRoleMenuByIdRole($idRole)
    {
        return $this->db->table($this->table)->delete(['role_id' => $idRole]);
    }
} 