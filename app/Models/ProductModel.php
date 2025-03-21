<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'category_id', 'price', 'stock', 'description', 'image', 'created_at'];

    public function getProducts()
    {
        return $this->select('products.*, categories.category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->findAll();
    }

    public function getProductById($id)
    {
        return $this->find($id);
    }
    

    public function getProductDetails($id)
    {
        // Lấy thông tin sản phẩm chính
        $product = $this->select('products.*, categories.category_name')
                        ->join('categories', 'categories.id = products.category_id', 'left')
                        ->where('products.id', $id)
                        ->first();

        if (!$product) {
            return null; // Nếu không tìm thấy sản phẩm, trả về null
        }

        // Lấy thông tin chi tiết sản phẩm từ bảng product_details
        $db = \Config\Database::connect();
        $query = $db->table('product_details')->where('product_id', $id)->get();
        $productDetails = $query->getRowArray();

        // Lấy danh sách hình ảnh từ bảng product_images
        $query = $db->table('product_images')->where('product_id', $id)->get();
        $productImages = $query->getResultArray();

        // Trả về thông tin sản phẩm, chi tiết và hình ảnh
        return [
            'product' => $product,        // Thông tin sản phẩm
            'details' => $productDetails, // Thông tin chi tiết
            'images' => $productImages    // Hình ảnh sản phẩm
        ];
    }

    public function updateProductDetails($productId, $data)
    {
        $db = \Config\Database::connect();
        $query = $db->table('product_details')->where('product_id', $productId)->get();

        if ($query->getRowArray()) {
            $db->table('product_details')->where('product_id', $productId)->update($data);
        } else {
            $data['product_id'] = $productId;
            $db->table('product_details')->insert($data);
        }
    }
    public function addProductImage($productId, $imageUrl, $description)
    {
        $db = \Config\Database::connect();
        $db->table('product_images')->insert([
            'product_id' => $productId,
            'image_url' => $imageUrl,
            'description' => $description
        ]);
    }

    public function getProductImages($productId)
    {
        $db = \Config\Database::connect();
        return $db->table('product_images')->where('product_id', $productId)->get()->getResultArray();
    }



}
