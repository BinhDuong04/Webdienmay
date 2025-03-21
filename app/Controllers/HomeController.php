<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class HomeController extends Controller
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        // Khi trang tải lên, chúng ta lấy tất cả sản phẩm mới nhất
        $products = $this->productModel->orderBy('created_at', 'DESC')->findAll(8);  // Lấy 8 sản phẩm mới nhất

        // Giữ nguyên các phần khác như danh mục, sản phẩm theo danh mục
        $data = $this->prepareData();

        // Truyền sản phẩm mới nhất vào view
        $data['products'] = $products;

        return view('home/index', $data);
    }
    public function searchProducts($query)
    {
        // Tìm kiếm sản phẩm theo tên hoặc mô tả
        return $this->productModel
            ->like('name', $query)
            ->orLike('description', $query)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function search()
    {
        $query = $this->request->getGet('query');

        // Nếu có truy vấn tìm kiếm, tìm kiếm sản phẩm theo tên hoặc mô tả
        if (!empty($query)) {
            $products = $this->searchProducts($query);
        } else {
            // Nếu không có truy vấn tìm kiếm, hiển thị tất cả sản phẩm mới nhất
            $products = $this->productModel->orderBy('created_at', 'DESC')->findAll(8);  // Lấy 8 sản phẩm mới nhất
        }

        // Giữ nguyên các phần khác như danh mục, sản phẩm theo danh mục
        $data = $this->prepareData();

        // Truyền thêm dữ liệu tìm kiếm vào view
        $data['query'] = $query;
        $data['products'] = $products;

        return view('home/index', $data);
    }


    private function prepareData()
    {
        $categories = $this->categoryModel->findAll();
    
        // Giữ nguyên dữ liệu danh mục ngẫu nhiên và các sản phẩm theo danh mục
        $randomCategories = $categories;
        shuffle($randomCategories);
        $randomCategories = array_slice($randomCategories, 0, 3);
    
        $products = $this->productModel->orderBy('created_at', 'DESC')->findAll();
    
        // Lấy sản phẩm theo danh mục nổi bật
        $productsByCategory = [];
        foreach ($randomCategories as $category) {
            $filteredProducts = array_filter($products, function($product) use ($category) {
                return $product['category_id'] == $category['id'];
            });
            $productsByCategory[$category['id']] = array_slice($filteredProducts, 0, 5);
        }
    
        // Danh mục còn lại
        $remainingCategories = array_filter($categories, function($category) use ($randomCategories) {
            return !in_array($category, $randomCategories);
        });
    
        // Sản phẩm theo danh mục còn lại (giới hạn 5 sản phẩm mới nhất)
        $otherProducts = [];
        foreach ($remainingCategories as $category) {
            $filteredProducts = array_filter($products, function($product) use ($category) {
                return $product['category_id'] == $category['id'];
            });
            $otherProducts[$category['id']] = array_slice($filteredProducts, 0, 5); // Giới hạn chỉ 5 sản phẩm
        }
    
        // Lấy ID danh mục đầu tiên để truyền vào view
        $firstCategoryId = isset($randomCategories[0]) ? $randomCategories[0]['id'] : null;

    
        return [
            'categories' => $categories,
            'randomCategories' => $randomCategories,
            'remainingCategories' => $remainingCategories,
            'productsByCategory' => $productsByCategory,
            'otherProducts' => $otherProducts,
            'firstCategoryId' => $firstCategoryId, // Truyền ID danh mục đầu tiên
        ];
    }
    

    public function categoryProducts($categoryId)
    {
        $category = $this->categoryModel->find($categoryId);
        
        if (!$category) {
            return redirect()->to('/')->with('error', 'Danh mục không tồn tại.');
        }

        $db = \Config\Database::connect();

        // Lấy trang hiện tại từ query string (mặc định là trang 1 nếu không có)
        $currentPage = $this->request->getVar('page') ?? 1;
        $productsPerPage = 8;
        $offset = ($currentPage - 1) * $productsPerPage;

        // Lấy sản phẩm cho trang hiện tại với phân trang
        $productsQuery = $db->table('products')
                            ->select('products.*, product_details.brand, products.created_at')
                            ->join('product_details', 'product_details.product_id = products.id', 'left')
                            ->where('products.category_id', $categoryId)
                            ->orderBy('products.created_at', 'DESC')
                            ->limit($productsPerPage, $offset)
                            ->get();
        $products = $productsQuery->getResultArray();

        // Lấy tổng số sản phẩm trong danh mục để tính toán số trang
        $totalProductsQuery = $db->table('products')
                                ->where('products.category_id', $categoryId)
                                ->countAllResults();
        $totalProducts = $totalProductsQuery;

        // Lấy các hãng sản phẩm
        $brandsQuery = $db->table('product_details')
                        ->select('DISTINCT brand', false)
                        ->join('products', 'products.id = product_details.product_id')
                        ->where('products.category_id', $categoryId)
                        ->get();
        $brands = $brandsQuery->getResultArray();

        // Lấy các sản phẩm khác để hiển thị ở phần "Sản phẩm khác"
        $otherProductsQuery = $db->table('products')
                                ->select('products.*, product_details.brand, products.created_at')
                                ->join('product_details', 'product_details.product_id = products.id', 'left')
                                ->where('products.category_id !=', $categoryId)
                                ->orderBy('products.created_at', 'DESC')
                                ->limit(8)
                                ->get();
        $otherProducts = $otherProductsQuery->getResultArray();

        // Tính tổng số trang
        $totalPages = ceil($totalProducts / $productsPerPage);

        $data = [
            'category'      => $category,
            'products'      => $products,
            'brands'        => $brands,
            'otherProducts' => $otherProducts,
            'currentPage'   => $currentPage,
            'totalPages'    => $totalPages,
        ];

        return view('home/category_products', $data);
    }

}
