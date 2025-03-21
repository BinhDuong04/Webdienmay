<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'total_price', 'status', 'full_name', 'address', 'phone'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function createOrder($userId, $totalPrice, $fullName, $address, $phone, $email = null)
    {
        $data = [
            'user_id' => $userId,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'full_name' => $fullName,
            'address' => $address,
            'phone' => $phone,

        ];
        return $this->insert($data, true); // Trả về ID của đơn hàng vừa tạo
    }
}