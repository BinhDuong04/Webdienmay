<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        return view('templates/menu', $data);
    }
    public function index()
    {
        
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        return view('admin/manage_categories', $data);
    }

    public function viewCategory($id)
    {
        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->find($id);
        $data['products'] = $productModel->where('category_id', $id)->findAll();

        return view('category', $data);
    }

    // 🟢 Thêm danh mục mới
    public function addCategory()
    {
        $categoryModel = new CategoryModel();

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'description' => $this->request->getPost('description')
        ];

        if ($categoryModel->insert($data)) {
            return $this->response->setJSON([
                'id' => $categoryModel->insertID(),
                'category_name' => $data['category_name'],
                'description' => $data['description']
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Không thể thêm danh mục']);
        }
    }

    // 🟡 Sửa danh mục
    public function editCategory()
    {
        $categoryModel = new CategoryModel();
        $id = $this->request->getPost('id');

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'description' => $this->request->getPost('description')
        ];

        if ($categoryModel->update($id, $data)) {
            return $this->response->setJSON(['message' => 'Danh mục đã cập nhật']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Không thể cập nhật danh mục']);
        }
    }

    // 🔴 Xóa danh mục
    public function deleteCategory($id)
    {
        $categoryModel = new CategoryModel();

        if ($categoryModel->delete($id)) {
            return $this->response->setJSON(['message' => 'Danh mục đã bị xóa']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Không thể xóa danh mục']);
        }
    }
}
