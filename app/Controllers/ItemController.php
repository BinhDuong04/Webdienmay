<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductDetailsModel;
use App\Models\ProductImagesModel;
use App\Models\CommentsModel;

class ItemController extends BaseController
{
    protected $productModel;
    protected $productDetailsModel;
    protected $productImagesModel;
    protected $commentsModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->productDetailsModel = new ProductDetailsModel();
        $this->productImagesModel = new ProductImagesModel();
        $this->commentsModel = new CommentsModel();
    }

    public function show($productId)
    {
        $productData = $this->productModel->getProductDetails($productId);

        if (!$productData) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Sản phẩm không tồn tại.");
        }

        $comments = $this->commentsModel->getComments($productId);
        $productStatus = ($productData['product']['stock'] > 0) ? 'Còn hàng' : 'Hết hàng';

        $data = [
            'product' => $productData['product'],
            'productDetails' => $productData['details'],
            'productImages' => $productData['images'],
            'comments' => $comments,
            'additionalInfo' => $productData['details']['additional_info'],
            'productStatus' => $productStatus,
        ];

        return view('home/item_details', $data);
    }
    public function addReview($productId)
    {
        $session = session();
        if (!$session->get('logged_in')) { // Đồng bộ với view
            return redirect()->to(base_url('login'))->with('error', 'Vui lòng đăng nhập để viết đánh giá!');
        }

        $userId = $session->get('user_id');
        $review = $this->request->getPost('review');

        if (!empty($review)) {
            $this->commentsModel->addComment($userId, $productId, $review);
            return redirect()->to(base_url("home/item_details/$productId"))->with('success', 'Đánh giá đã được gửi!');
        }

        return redirect()->to(base_url("home/item_details/$productId"))->with('error', 'Vui lòng nhập nội dung đánh giá!');
    }

    public function replyReview($commentId)
    {
        $session = session();
        if (!$session->get('logged_in')) { // Đồng bộ với view
            return redirect()->to(base_url('login'))->with('error', 'Vui lòng đăng nhập để trả lời!');
        }

        $userId = $session->get('user_id');
        $reply = $this->request->getPost('reply');

        if (!empty($reply)) {
            $comment = $this->commentsModel->find($commentId);
            if (!$comment) {
                return redirect()->back()->with('error', 'Bình luận không tồn tại!');
            }

            $this->commentsModel->addReply($commentId, $userId, $reply);
            return redirect()->to(base_url("home/item_details/{$comment['product_id']}"))->with('success', 'Trả lời đã được gửi!');
        }

        return redirect()->back()->with('error', 'Vui lòng nhập nội dung trả lời!');
    }

    // Hàm hỗ trợ lấy trạng thái sản phẩm (nếu cần)
    private function getProductStatus($productId)
    {
        $product = $this->productModel->find($productId);
        return $product['stock'] > 0 ? 'Còn hàng' : 'Hết hàng';
    }
}