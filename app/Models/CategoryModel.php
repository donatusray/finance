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

    public function listCategoryParent()
    {
        $sql = "select * from " . $this->table . " where category_parent_id=:par: order by category_name asc";
        $query = $this->db->query($sql, ['par' => 0]);
        return $query->getResultArray();
    }

    public function listCategoryIncomeParent()
    {
        $sql = "select * from " . $this->table . " where category_type=:tipe: and category_parent_id=:par: order by category_name asc";
        $query = $this->db->query($sql, ['tipe' => 'INCOME', 'par' => 0]);
        return $query->getResultArray();
    }

    public function listCategoryIncome()
    {
        $sql = "select * from " . $this->table . " where category_type=:tipe: order by category_name asc";
        $query = $this->db->query($sql, ['tipe' => 'INCOME']);
        return $query->getResultArray();
    }

    public function listCategoryExpense()
    {
        $sql = "select * from " . $this->table . " where category_type=:tipe: order by category_name asc";
        $query = $this->db->query($sql, ['tipe' => 'EXPENSE']);
        return $query->getResultArray();
    }

    public function listCategoryExpenseParent()
    {
        $sql = "select * from " . $this->table . " where category_type=:tipe: and category_parent_id=:par: order by category_name asc";
        $query = $this->db->query($sql, ['tipe' => 'EXPENSE', 'par' => 0]);
        return $query->getResultArray();
    }

    public function listCategory()
    {
        $sql = "select * from " . $this->table . " order by category_name asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function listCategoryFilter($type, $parents)
    {
        $sql = "select * from " . $this->table;
        $arrValue = array();
        if ($type != "" || $parents != "") {
            $sql .= " where ";
            if ($type != '') {
                $arrCol[] = " category_type=:tipe: ";
                $arrValue['tipe'] = $type;
            }
            if ($parents != '') {
                $arrCol[] = " category_parent_id=:par: ";
                $arrValue['par'] = $parents;
            }
            $sql .= implode(" and ", $arrCol);
        }
        $sql .= " order by category_name asc";
        if (count($arrValue) > 0) {
            $query = $this->db->query($sql, $arrValue);
        } else {
            $query = $this->db->query($sql);
        }
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