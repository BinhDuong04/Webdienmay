<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
        // Hiển thị trang login
        return view('login');
    }

    public function processLogin()
    {
        $session = session();
        $request = $this->request;

        // Lấy thông tin đăng nhập từ form
        $email = $request->getPost('email');
        $password = $request->getPost('password');

        // Kiểm tra xem email và mật khẩu có được gửi từ form không
        if (!$email || !$password) {
            return redirect()->to(base_url('login'))->with('error', 'Vui lòng nhập đầy đủ thông tin.');
        }

        // Tạo một instance của UserModel để truy vấn cơ sở dữ liệu
        $userModel = new UserModel();

        // Lấy thông tin người dùng từ CSDL theo email
        $user = $userModel->getUserByEmail($email);

        // Kiểm tra nếu người dùng tồn tại và mật khẩu đúng
        if ($user && password_verify($password, $user['password'])) {
            // Lưu thông tin vào session khi đăng nhập thành công
            $session->set([
                'logged_in' => true,
                'full_name' => $user['full_name'],
                'user_id' => $user['id'],
                'email' => $user['email'],
                'isLoggedIn' => true, // Đánh dấu người dùng đã đăng nhập
            ]);

            // Ghi log thông tin session sau khi đăng nhập thành công
            log_message('debug', 'Session after login: ' . print_r($session->get(), true));

            // Chuyển hướng về trang chủ sau khi đăng nhập thành công
            return redirect()->to(base_url());
        } else {
            // Nếu đăng nhập thất bại, hiển thị thông báo lỗi
            $session->setFlashdata('error', 'Sai tài khoản hoặc mật khẩu!');
            return redirect()->to(base_url('login'));
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy(); // Hủy session khi người dùng đăng xuất
        return redirect()->to(base_url()); // Chuyển hướng về trang chủ sau khi đăng xuất
    }
}
