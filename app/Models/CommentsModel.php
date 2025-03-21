<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';  // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id';   // Khóa chính của bảng
    protected $allowedFields = ['user_id', 'product_id', 'comment', 'created_at', 'reply_to'];  // Các trường có thể được gán giá trị
    protected $useTimestamps = false;

    // Lấy các bình luận của sản phẩm kèm full_name
    public function getComments($productId)
    {
        try {
            $builder = $this->db->table($this->table);
            $builder->select('comments.*, users.full_name') // Thay username bằng full_name
                    ->join('users', 'users.id = comments.user_id', 'left')
                    ->where('comments.product_id', $productId)
                    ->orderBy('comments.created_at', 'DESC');

            $query = $builder->get();

            if ($query === false) {
                log_message('error', 'Query failed in getComments: ' . $this->db->getLastQuery());
                return [];
            }

            return $query->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Exception in getComments: ' . $e->getMessage());
            return [];
        }
    }

    // Thêm bình luận
    public function addComment($userId, $productId, $comment)
    {
        return $this->insert([
            'user_id' => $userId,
            'product_id' => $productId,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    // Thêm trả lời cho bình luận
    public function addReply($commentId, $userId, $reply)
    {
        $comment = $this->find($commentId);
        $productId = $comment ? $comment['product_id'] : 0;

        return $this->insert([
            'reply_to' => $commentId,
            'user_id' => $userId,
            'product_id' => $productId,
            'comment' => $reply,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}