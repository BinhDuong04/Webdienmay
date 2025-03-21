<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductDetailsModel extends Model
{
    protected $table = 'product_details';  // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id';          // Khoá chính của bảng
    protected $allowedFields = [
        'product_id', 'warranty', 'brand', 'origin', 'weight', 'dimensions', 'additional_info'
    ];  // Các trường có thể được gán giá trị

    // Thiết lập các quan hệ
    protected $useTimestamps = false;  // Không sử dụng timestamps nếu không có các trường created_at/updated_at

    // Quan hệ với bảng `products`
    public function getProductDetails($productId)
    {
        return $this->where('product_id', $productId)->first();
    }
    
    public function updateProductDetails($productId, $data)
    {
        return $this->where('product_id', $productId)->set($data)->update();
    }

}
