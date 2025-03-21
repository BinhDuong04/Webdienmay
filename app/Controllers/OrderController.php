<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class OrderController extends BaseController
{
    public function buyNow()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId || !$session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
        }

        // Lấy dữ liệu từ form
        $productId = $this->request->getPost('product_id');
        $price = $this->request->getPost('price');
        $quantity = $this->request->getPost('quantity');
        $paymentMethod = $this->request->getPost('payment_method');
        $fullName = $this->request->getPost('full_name');
        $address = $this->request->getPost('address');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');

        // Kiểm tra dữ liệu đầu vào
        if (!$productId || !$price || !$quantity || !$paymentMethod || !$fullName || !$address || !$phone) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin!']);
        }

        // Chuyển đổi quantity thành số nguyên
        $quantity = (int)$quantity;
        if ($quantity < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Số lượng không hợp lệ!']);
        }

        // Kiểm tra tồn kho
        $productModel = new ProductModel();
        $product = $productModel->find($productId);
        if (!$product || $product['stock'] < $quantity) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sản phẩm không đủ số lượng trong kho!']);
        }

        // Tính tổng giá trị đơn hàng
        $totalPrice = $price * $quantity;

        // Khởi tạo các model
        $orderModel = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();
        $paymentModel = new PaymentModel();

        // Tạo đơn hàng với thông tin đặt hàng
        $orderId = $orderModel->createOrder($userId, $totalPrice, $fullName, $address, $phone, $email);

        // Thêm chi tiết đơn hàng (chỉ 1 sản phẩm)
        $orderDetailsModel->addOrderDetail($orderId, $productId, $quantity, $price);

        // Tạo thanh toán
        $paymentId = $paymentModel->createPayment($orderId, $paymentMethod);

        if ($paymentMethod === 'cash') {
            $paymentModel->update($paymentId, [
                'payment_status' => 'paid',
                'payment_date' => date('Y-m-d H:i:s')
            ]);
            $orderModel->update($orderId, ['status' => 'processing']);

            // Cập nhật số lượng tồn kho
            $newStock = $product['stock'] - $quantity;
            $productModel->update($productId, ['stock' => $newStock]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Đặt hàng thành công!'
            ]);
        } else if ($paymentMethod === 'vnpay') {
            return $this->response->setJSON([
                'success' => true,
                'order_id' => $orderId,
                'message' => 'Chuẩn bị chuyển hướng đến VNPAY...'
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Phương thức thanh toán không hợp lệ!']);
    }

    public function orderHistory()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId || !$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng!');
        }

        $orderModel = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();
        $paymentModel = new PaymentModel();
        $productModel = new ProductModel();

        // Lấy danh sách đơn hàng của người dùng
        $orders = $orderModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
        foreach ($orders as &$order) {
            // Lấy thông tin thanh toán
            $payment = $paymentModel->where('order_id', $order['id'])->first();
            $order['payment_method'] = $payment ? $this->getPaymentMethodDisplay($payment) : 'Không xác định';

            // Lấy chi tiết đơn hàng và thông tin sản phẩm
            $details = $orderDetailsModel->where('order_id', $order['id'])->findAll();
            foreach ($details as &$detail) {
                $product = $productModel->select('products.*, categories.category_name')
                                       ->join('categories', 'categories.id = products.category_id', 'left')
                                       ->find($detail['product_id']);
                $detail['product_name'] = $product ? $product['name'] : 'Không xác định';
                $detail['image'] = $product && $product['image'] ? json_decode($product['image'], true)[0] : null;
                $detail['category_name'] = $product ? $product['category_name'] : 'Không xác định';
            }
            $order['details'] = $details;
        }

        $data['orders'] = $orders;
        return view('home/order_history', $data);
    }

    public function getOrderDetails($orderId)
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId || !$session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
        }

        $orderModel = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();
        $paymentModel = new PaymentModel();
        $productModel = new ProductModel();

        // Kiểm tra đơn hàng thuộc về người dùng
        $order = $orderModel->where('user_id', $userId)->find($orderId);
        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Đơn hàng không tồn tại hoặc không thuộc về bạn!']);
        }

        // Lấy chi tiết đơn hàng
        $orderDetails = $orderDetailsModel->where('order_id', $orderId)->findAll();
        foreach ($orderDetails as &$detail) {
            $product = $productModel->select('products.*, categories.category_name')
                                   ->join('categories', 'categories.id = products.category_id', 'left')
                                   ->find($detail['product_id']);
            $detail['product_name'] = $product ? $product['name'] : 'Không xác định';
            $detail['image'] = $product && $product['image'] ? json_decode($product['image'], true)[0] : null;
            $detail['category_name'] = $product ? $product['category_name'] : 'Không xác định';
        }

        // Lấy thông tin thanh toán
        $payment = $paymentModel->where('order_id', $orderId)->first();
        $order['payment_method'] = $payment ? $this->getPaymentMethodDisplay($payment) : 'Không xác định';

        return $this->response->setJSON([
            'success' => true,
            'order' => $order,
            'order_details' => $orderDetails,
            'payment' => $payment
        ]);
    }

    public function cancelOrder()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId || !$session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
        }

        $orderId = $this->request->getPost('order_id');
        $orderModel = new OrderModel();

        // Kiểm tra đơn hàng
        $order = $orderModel->where('user_id', $userId)->find($orderId);
        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Đơn hàng không tồn tại hoặc không thuộc về bạn!']);
        }

        if ($order['status'] !== 'processing') {
            return $this->response->setJSON(['success' => false, 'message' => 'Chỉ có thể hủy đơn hàng khi đang ở trạng thái "Đang xử lý"!']);
        }

        $orderModel->update($orderId, ['status' => 'cancelled']);
        return $this->response->setJSON(['success' => true, 'message' => 'Hủy đơn hàng thành công']);
    }

    // Hàm hỗ trợ hiển thị phương thức thanh toán
    private function getPaymentMethodDisplay($payment)
    {
        if ($payment['payment_method'] === 'cash') {
            return 'Tiền mặt';
        } elseif ($payment['payment_method'] === 'vnpay' && $payment['payment_status'] === 'pending') {
            return 'Đã thanh toán (VNPAY)';
        } elseif ($payment['payment_method'] === 'vnpay') {
            return 'VNPAY (Chưa thanh toán)';
        }
        return 'Không xác định';
    }
}