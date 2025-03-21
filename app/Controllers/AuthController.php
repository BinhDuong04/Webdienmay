<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        // Xóa cookie session nếu có khi người dùng đến trang login
        setcookie(session_name(), '', time() - 3600, '/'); // Xóa cookie session
        
        return view('auth/login');
    }

    public function checkLogin()
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

            // Chuyển hướng đến trang phù hợp dựa trên vai trò của người dùng
            if ($user['role'] === 'admin') {
                // Nếu là admin, chuyển hướng đến trang quản trị
                return redirect()->to('/admin/dashboard');
            } else {
                // Nếu là customer, chuyển hướng đến trang chủ
                return redirect()->to('/home/index');
            }
        } else {
            // Nếu đăng nhập thất bại, hiển thị thông báo lỗi
            $session->setFlashdata('error', 'Sai tài khoản hoặc mật khẩu!');
            return redirect()->to(base_url('login'));
        }
    }


    public function register()
    {
        return view('auth/register');
    }

    public function registerSave()
    {
        $userModel = new UserModel();

        // Kiểm tra xem email đã tồn tại chưa
        $email = $this->request->getPost('email');
        if ($userModel->where('email', $email)->first()) {
            return redirect()->to('/register')->with('error', 'Email đã tồn tại. Vui lòng sử dụng email khác.');
        }

        // Lấy vai trò từ form, chỉ cho phép 'admin' hoặc 'customer'
        $role = $this->request->getPost('role');
        if (!in_array($role, ['admin', 'customer'])) {
            $role = 'customer'; // Nếu giá trị không hợp lệ, mặc định là customer
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $email,
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'phone'     => $this->request->getPost('phone'),
            'address'   => $this->request->getPost('address'),
            'role'      => $role
        ];

        if ($userModel->insert($data)) {
            return redirect()->to('/register')->with('success', 'Đăng ký thành công! <a href="' . base_url('login') . '">Đăng nhập</a>');
        } else {
            return redirect()->to('/register')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function logout()
    {
        $session = session();
    
        // Xóa session
        log_message('debug', 'Before Destroy: ' . print_r($session->get(), true));
        $session->destroy();  // Xóa session
    
        // Xóa cookie session nếu có
        if (isset($_COOKIE[session_name()])) {
            log_message('debug', 'Before Deleting Cookie: ' . session_name());
            setcookie(session_name(), '', time() - 3600, '/'); // Đặt thời gian hết hạn cookie về quá khứ
        }
    
        // Đảm bảo cookie đã được xóa
        log_message('debug', 'After Deleting Cookie: ' . print_r($_COOKIE, true));
    
        // Chuyển hướng về trang đăng nhập
        return redirect()->to('/login');
    }
    
}
