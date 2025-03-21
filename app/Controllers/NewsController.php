<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $newsModel = new NewsModel();
        $data['news'] = $newsModel->findAll(); // Lấy danh sách tin tức

        return view('admin/manage_News', $data); // Load giao diện quản lý tin tức
    }

    public function store()
    {
        $newsModel = new NewsModel();

        $file = $this->request->getFile('image');
        $imagePath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/news', $newName);
            $imagePath = 'uploads/news/' . $newName;
        }

        $data = [
            'title'   => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'image'   => $imagePath,
        ];

        if ($newsModel->insert($data)) {
            return redirect()->to(base_url('admin/manage_News'))->with('success', 'Thêm tin tức thành công');
        } else {
            return redirect()->back()->with('error', 'Lỗi khi thêm tin tức!');
        }
    }

    public function update()
    {
        $newsModel = new NewsModel();
        $id = $this->request->getPost('id');

        $data = [
            'title'   => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/news', $newName);
            $data['image'] = 'uploads/news/' . $newName;
        }

        if ($newsModel->update($id, $data)) {
            return redirect()->to(base_url('admin/manage_news'))->with('success', 'Cập nhật tin tức thành công');
        } else {
            return redirect()->back()->with('error', 'Lỗi khi cập nhật tin tức!');
        }
    }

    public function delete($id)
    {
        $newsModel = new NewsModel();
        
        if ($newsModel->delete($id)) {
            return redirect()->to(base_url('admin/manage_news'))->with('success', 'Xóa tin tức thành công');
        } else {
            return redirect()->back()->with('error', 'Lỗi khi xóa tin tức!');
        }
    }
}
