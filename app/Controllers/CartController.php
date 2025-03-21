<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\PaymentModel;

class CartController extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId || !$session->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $cartModel = new CartModel();
        $cartItems = $cartModel->getCartItems($userId);

        foreach ($cartItems as &$item) {
            if (!empty($item['image'])) {
                $item['image'] = json_decode($item['image'], true);
            }
        }

        return view('home/cart', ['cart_items' => $cartItems]);
    }

    public function addToCart($productId)
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId || !$session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
        }

        $quantity = $this->request->getPost('quantity', FILTER_SANITIZE_NUMBER_INT);
        if (!$quantity || $quantity < 1) {
            $quantity = 1;
        }

        $cartModel = new CartModel();
        $cartModel->addToCart($userId, $productId, $quantity);

        $cartCount = $cartModel->getCartItemCount($userId);
        return $this->response->setJSON([
            'success' => true,
            'count' => $cartCount,
            'message' => 'Đã thêm vào giỏ hàng thành công!'
        ]);
    }

    public function removeProduct()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId || !$session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
        }

        $cartIds = json_decode($this->request->getPost('cart_ids'), true);

        if (empty($cartIds) || !is_array($cartIds)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Không có sản phẩm nào được chọn!']);
        }

        $cartModel = new CartModel();
        $affectedRows = $cartModel->where('user_id', $userId)
                                  ->whereIn('id', $cartIds)
                                  ->delete();

        if ($affectedRows > 0) {
            $cartItems = $cartModel->getCartItems($userId);
            return $this->response->setJSON([
                'success' => true,
                'cartItems' => $cartItems,
                'message' => 'Đã xóa ' . $affectedRows . ' sản phẩm thành công!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Không thể xóa sản phẩm!'
            ]);
        }
    }

    public function buyNow()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId || !$session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
        }

        $totalPrice = $this->request->getPost('total_price');
        $cartIds = json_decode($this->request->getPost('cart_ids'), true);
        $paymentMethod = $this->request->getPost('payment_method');
        $fullName = $this->request->getPost('full_name');
        $address = $this->request->getPost('address');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');

        if (empty($cartIds) || !$totalPrice || !$paymentMethod || !$fullName || !$address || !$phone) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin!']);
        }

        $cartModel = new CartModel();
        $orderModel = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();
        $paymentModel = new PaymentModel();

        // Tạo đơn hàng với thông tin đặt hàng
        $orderId = $orderModel->createOrder($userId, $totalPrice, $fullName, $address, $phone, $email);

        // Thêm chi tiết đơn hàng
        $cartItems = $cartModel->where('user_id', $userId)
                               ->whereIn('cart.id', $cartIds)
                               ->join('products', 'cart.product_id = products.id')
                               ->select('cart.*, products.price')
                               ->findAll();

        if (empty($cartItems)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!']);
        }

        foreach ($cartItems as $item) {
            $orderDetailsModel->addOrderDetail($orderId, $item['product_id'], $item['quantity'], $item['price']);
        }

        // Tạo thanh toán
        $paymentId = $paymentModel->createPayment($orderId, $paymentMethod);

        if ($paymentMethod === 'cash') {
            $paymentModel->update($paymentId, [
                'payment_status' => 'paid',
                'payment_date' => date('Y-m-d H:i:s')
            ]);
            $orderModel->update($orderId, ['status' => 'processing']);
            $cartModel->whereIn('id', $cartIds)->delete();

            // Lưu thông báo vào session flashdata và redirect
            $session->setFlashdata('success', 'Đặt hàng thành công!');
            return redirect()->to(base_url('cart')); // Redirect về trang giỏ hàng
        } else if ($paymentMethod === 'vnpay') {
            return $this->response->setJSON([
                'success' => true,
                'order_id' => $orderId,
                'message' => 'Chuẩn bị chuyển hướng đến VNPAY...'
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Phương thức thanh toán không hợp lệ!']);
    }
}