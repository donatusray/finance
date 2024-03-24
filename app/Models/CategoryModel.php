<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 15/03/2024
 * Time: 17:39
 */

namespace App\Models;


use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = "category";

    public function listCategory()
    {
        $sql = "select * from " . $this->table . " order by category_name asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getCategory($id)
    {
        $sql = "select * from " . $this->table . " where category_id=:id:";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function insertCategory($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateCategory($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['category_id' => $id]);
    }

    public function deleteCategory($id)
    {
        return $this->db->table($this->table)->delete(['category_id' => $id]);
    }
} 