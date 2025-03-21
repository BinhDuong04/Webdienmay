<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'payment_method', 'payment_status', 'transaction_id', 'payment_date'];

    public function createPayment($orderId, $paymentMethod)
    {
        $data = [
            'order_id' => $orderId,
            'payment_method' => $paymentMethod,
            'payment_status' => 'pending',
            'transaction_id' => uniqid('txn_'),
            'payment_date' => date('Y-m-d H:i:s')
        ];
        return $this->insert($data, true); // Trả về ID của thanh toán vừa tạo
    }

    public function updatePaymentStatus($transactionId, $status)
    {
        return $this->where('transaction_id', $transactionId)
                    ->set(['payment_status' => $status, 'payment_date' => date('Y-m-d H:i:s')])
                    ->update();
    }
}