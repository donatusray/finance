<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 12/02/2024
 * Time: 18:52
 */
class UserModel extends Model
{
    protected $table = "users";

    public function listUser()
    {
        $sql = "select u.*, r.role_name from users u inner join roles r on r.role_id=u.role_id order by u.username asc";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getUser($id)
    {
        $sql = "select * from " . $this->table . " where user_id=:id: ";
        $query = $this->db->query($sql, ['id' => $id]);
        return $query->getRowArray();
    }

    public function get_username($username)
    {
        $sql = "select * from " . $this->table . " where username=:username: and isactive=:isactive:";
        $query = $this->db->query($sql, ['username' => $username, 'isactive' => 'Y']);
        return $query->getRowArray();
    }

    public function getUsernameWithRoleName($username)
    {
        $sql = "select u.*, r.role_name from users u inner join roles r on r.role_id=u.role_id where u.username=:username: and u.isactive=:isactive:";
        $query = $this->db->query($sql, ['username' => $username, 'isactive' => 'Y']);
        return $query->getRowArray();
    }

    public function insertUser($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateUser($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['user_id' => $id]);
    }

    public function deleteUser($id)
    {
        return $this->db->table($this->table)->delete(['user_id' => $id]);
    }
} 