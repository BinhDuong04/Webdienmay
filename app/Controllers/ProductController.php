<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;
use App\Models\CommentsModel;

class ProductController extends Controller
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data['categories'] = $categoryModel->findAll(); // Lấy danh mục từ database
        $data['products'] = $productModel->orderBy('RAND()')->findAll(); // Hiển thị sản phẩm ngẫu nhiên

        return view('templates/header') // Header
            . view('templates/menu', $data) // Gọi menu và truyền dữ liệu danh mục
            . view('product/index', $data) // Nội dung chính
            . view('templates/footer'); // Footer
    }
    
}
