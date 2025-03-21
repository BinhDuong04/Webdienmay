<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductDetailsModel;
use CodeIgniter\Controller;

class AdminProductController extends Controller
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data['products'] = $productModel->getProducts();
        $data['categories'] = $categoryModel->findAll();

        return view('admin/manage_products', $data);
        
    }

    public function store()
    {
        $productModel = new ProductModel();

        $price = str_replace('.', '', $this->request->getPost('price'));
        $price = str_replace(',', '.', $price);

        $productData = [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'price' => $price,
            'stock' => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
        ];

        $productId = $productModel->insert($productData);

        // Kiểm tra nếu insert thất bại
        if (!$productId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Không thể thêm sản phẩm!']);
        }

        // Xử lý upload ảnh
        $uploadPath = FCPATH . 'uploads/images/imgProduct/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $imagePaths = [];
        $files = $this->request->getFiles();
        if ($files && isset($files['images'])) {
            foreach ($files['images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move($uploadPath, $newName);
                    $imagePaths[] = 'uploads/images/imgProduct/' . $newName;
                }
            }
        }

        if (!empty($imagePaths)) {
            $productModel->update($productId, ['image' => json_encode($imagePaths, JSON_UNESCAPED_SLASHES)]);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Thêm sản phẩm thành công!']);
    }


    public function update()
    {
        $productModel = new ProductModel();
        $id = $this->request->getPost('id');

        $price = str_replace('.', '', $this->request->getPost('price')); 
        $price = str_replace(',', '.', $price);

        $productData = [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'price' => $price,
            'stock' => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
        ];

        $productModel->update($id, $productData);
        return redirect()->to('/admin/manage_products')->with('success', 'Cập nhật sản phẩm thành công!');

    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        if ($productModel->find($id)) {
            $productModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Sản phẩm đã bị xóa!']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Sản phẩm không tồn tại!']);
    }

    public function productDetails($id)
    {
        $productModel = new ProductModel();
        $productData = $productModel->getProductDetails($id);

        if ($productData) {
            return $this->response->setJSON(['status' => 'success', 'data' => $productData]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm!']);
        }
    }

    public function updateProductDetails()
    {
        $productId = $this->request->getPost('id');

        $data = [
            'specifications' => $this->request->getPost('specifications'),
            'warranty' => $this->request->getPost('warranty'),
            'brand' => $this->request->getPost('brand'),
            'origin' => $this->request->getPost('origin'),
            'weight' => $this->request->getPost('weight'),
            'dimensions' => $this->request->getPost('dimensions'),
            'additional_info' => $this->request->getPost('additional_info'),
        ];

        $productDetailsModel = new ProductDetailsModel();
        
        // Kiểm tra xem chi tiết sản phẩm đã tồn tại hay chưa
        if ($productDetailsModel->getProductDetails($productId)) {
            // Nếu tồn tại, cập nhật chi tiết sản phẩm
            $productDetailsModel->updateProductDetails($productId, $data);
        } else {
            // Nếu không có chi tiết sản phẩm, thêm mới
            $data['product_id'] = $productId;
            $productDetailsModel->insert($data);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Cập nhật chi tiết sản phẩm thành công!']);
    }



    public function uploadProductImages()
    {
        $productId = $this->request->getPost('product_id');
        $descriptions = $this->request->getPost('descriptions');

        $uploadPath = FCPATH . 'uploads/images/product_details/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $imageFiles = $this->request->getFiles();
        $uploadedImages = [];

        if ($imageFiles && isset($imageFiles['images'])) {
            $productModel = new ProductModel();
            foreach ($imageFiles['images'] as $index => $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move($uploadPath, $newName);
                    $imageUrl = 'uploads/images/product_details/' . $newName;

                    $description = $descriptions[$index] ?? '';
                    $productModel->addProductImage($productId, $imageUrl, $description);

                    $uploadedImages[] = [
                        'image_url' => base_url($imageUrl),
                        'description' => $description
                    ];
                }
            }
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Tải ảnh thành công!',
                'images' => $uploadedImages
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Không có ảnh nào được tải lên!']);
    }


}
