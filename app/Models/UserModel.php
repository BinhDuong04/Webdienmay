<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['full_name', 'email', 'password', 'phone', 'address', 'role', 'last_login'];

    // Lấy thông tin người dùng từ email
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
    // Cập nhật thời gian đăng nhập
    public function updateLastLogin($userId)
    {
        $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
}
