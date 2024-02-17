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
        $sql = "select * from " . $this->table . " order by menu_id asc";
        $query = $this->db->query($sql);
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