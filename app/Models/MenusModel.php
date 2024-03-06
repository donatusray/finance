<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 18/02/2024
 * Time: 01:18
 */

namespace App\Models;


use CodeIgniter\Model;

class MenusModel extends Model
{
    protected $table = "menus";

    public function listData()
    {
        $sql = "select menus.*, parent.menu_name parent_name
from menus
left join menus parent on parent.menu_id=menus.menu_parent
order by menus.menu_order asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function listDataWithRoleMenu($idRole)
    {
        $sql = "SELECT m.menu_id, m.menu_order, m.menu_name, rm.role_id, rm.menu_id menu_id_role
FROM menus m
left join role_menu rm on rm.menu_id=m.menu_id and rm.role_id=:id_role:";
        $query = $this->db->query($sql, ['id_role' => $idRole]);
        return $query->getResultArray();
    }

    public function getMenu($id)
    {
        $sql = "select * from " . $this->table . " where menu_id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function listDataParent()
    {
        $sql = "select * from " . $this->table . " where menu_parent is null order by menu_id asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function listDataAction($act)
    {
        $sql = "select * from " . $this->table . " where menu_action=:act:";
        $query = $this->db->query($sql, ['act' => $act]);
        return $query->getResultArray();
    }

    public function insertMenu($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateMenu($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['menu_id' => $id]);
    }

    public function deleteMenu($id)
    {
        return $this->db->table($this->table)->delete(['menu_id' => $id]);
    }
} 