<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImagesModel extends Model
{
    protected $table = 'product_images';  // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id';         // Khoá chính của bảng
    protected $allowedFields = ['product_id', 'image_url', 'description'];  // Các trường có thể được gán giá trị

    // Thiết lập các quan hệ
    protected $useTimestamps = false;

    // Lấy danh sách hình ảnh của sản phẩm
    public function getProductImages($productId)
    {
        return $this->where('product_id', $productId)->findAll();
    }

    // Thêm hình ảnh vào sản phẩm
    public function addProductImage($productId, $imageUrl, $description = null)
    {
        return $this->insert([
            'product_id' => $productId,
            'image_url' => $imageUrl,
            'description' => $description
        ]);
    }
}
