<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;

class OrderManagementController extends BaseController
{
    public function manageOrders()
    {
        $orderModel = new OrderModel();
        $paymentModel = new PaymentModel();

        $orders = $orderModel->findAll();
        foreach ($orders as &$order) {
            $payment = $paymentModel->where('order_id', $order['id'])->first();
            $order['payment_method'] = $payment ? $payment['payment_method'] : 'Unknown';
        }

        $data['orders'] = $orders;
        return view('admin/manage_orders', $data);
    }

    public function getOrderDetails($orderId)
    {
        $orderModel = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();
        $paymentModel = new PaymentModel();
        $productModel = new ProductModel();

        $order = $orderModel->find($orderId);
        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Đơn hàng không tồn tại']);
        }

        $orderDetails = $orderDetailsModel->where('order_id', $orderId)->findAll();
        foreach ($orderDetails as &$detail) {
            $product = $productModel->find($detail['product_id']);
            $detail['product_name'] = $product ? $product['name'] : 'Unknown';
        }

        $payment = $paymentModel->where('order_id', $orderId)->first();

        return $this->response->setJSON([
            'success' => true,
            'order' => $order,
            'order_details' => $orderDetails,
            'payment' => $payment
        ]);
    }

    public function updateOrderStatus()
    {
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');

        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Đơn hàng không tồn tại']);
        }

        $orderModel->update($orderId, ['status' => $status]);
        return $this->response->setJSON(['success' => true, 'message' => 'Cập nhật trạng thái thành công']);
    }

    public function deleteOrder()
    {
        $orderId = $this->request->getPost('order_id');

        $orderModel = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();
        $paymentModel = new PaymentModel();

        $order = $orderModel->find($orderId);
        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Đơn hàng không tồn tại']);
        }

        $orderDetailsModel->where('order_id', $orderId)->delete();
        $paymentModel->where('order_id', $orderId)->delete();
        $orderModel->delete($orderId);

        return $this->response->setJSON(['success' => true, 'message' => 'Xóa đơn hàng thành công']);
    }
}