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

    public function get_username($username)
    {
        $sql = "select * from " . $this->table . " where username=:username: and isactive=:isactive:";
        $query = $this->db->query($sql, ['username' => $username, 'isactive' => 'Y']);
        return $query->getRowArray();
    }
} 