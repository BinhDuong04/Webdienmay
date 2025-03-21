<?php
$session = session(); 
$isLoggedIn = $session->get('logged_in') ?? false; // Kiểm tra session 'logged_in' thay vì 'isLoggedIn'
$fullName = $session->get('full_name') ?? ''; // Kiểm tra session 'full_name'
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điện Máy Tiết Kiệm</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/header.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Thêm thư viện jQuery -->
</head>
<body>
    <!-- Banner trên cùng -->
    <div class="top-banner">
        <img src="<?= base_url('uploads/images/banner.png'); ?>" alt="Ưu đãi lớn">
    </div>

    <!-- Thanh điều hướng chính -->
    <header class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="<?= base_url(); ?>">
                        <img src="<?= base_url('uploads/images/logo.png'); ?>" alt="DienMayDo">
                    </a>
                </div>

                <!-- Thanh tìm kiếm -->
                <div class="search-bar">
                    <form action="<?= site_url('home/search'); ?>" method="get">
                        <input type="text" name="query" placeholder="Tìm kiếm sản phẩm..." value="<?= isset($query) ? esc($query) : ''; ?>">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>

                <!-- Hỗ trợ khách hàng + tài khoản + giỏ hàng -->
                <div class="top-right">
                    <!-- Hỗ trợ khách hàng (Hiển thị theo chiều dọc) -->
                    <div class="support">
                        <i class="fa-solid fa-phone-volume"></i>
                        <div class="support-text">
                            <span>Hỗ trợ khách hàng</span>
                            <strong>034.559.1612</strong>
                        </div>
                    </div>

                    <!-- Tài khoản/Đăng nhập/Đăng xuất (Hiển thị theo chiều dọc) -->
                    <div class="account">
                        <i class="fa-solid fa-circle-user"></i>
                        <div class="account-text">
                            <?php if ($isLoggedIn): ?>
                                <span class="username"><?= esc($fullName); ?></span>
                                <a href="<?= base_url('logout'); ?>" class="logout">Đăng xuất</a>
                            <?php else: ?>
                                <span>Tài Khoản</span>
                                <a href="<?= base_url('login'); ?>">Đăng nhập</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Giỏ hàng -->
                    <div class="cart">
                        <a href="<?= base_url('cart'); ?>"> <!-- Chuyển hướng đến trang giỏ hàng -->
                            <i class="fa-solid fa-bag-shopping"></i> Giỏ hàng 
                            <span class="cart-count" id="cart-count"></span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <nav class="menu">
        <div class="container">
            <div class="menu-content">
                <div class="marquee-container">
                    <marquee>🛒 ĐIỆN MÁY ĐỎ nói KHÔNG với GIÁ ẢO 🏅 | 💳 Trả Góp 0% Tại Nhà 🏠 | 🚚 Giao Lắp Đặt Miễn Phí</marquee>
                </div>
                <ul class="nav-links">
                    <li><a href="<?= base_url('home/index'); ?>">Trang Chủ</a></li>
                    <li><a href="<?= base_url('home/introduce'); ?>">Giới Thiệu</a></li>
                    <li><a href="<?= base_url('home/news'); ?>">Tin Tức</a></li>
                    <li><a href="<?= base_url('order/history'); ?>">Lịch sử đơn hàng</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <script>
        // Sử dụng AJAX để lấy số lượng sản phẩm trong giỏ hàng
        $(document).ready(function() {
            $.ajax({
                url: '<?= site_url('cart/getCartCount'); ?>', // Gọi phương thức getCartCount trong CartController
                type: 'GET',
                success: function(response) {
                    // Cập nhật số lượng sản phẩm trong giỏ hàng
                    $('#cart-count').text(response.count); 
                },
                error: function(xhr, status, error) {
                    console.error("Có lỗi xảy ra: " + error);
                }
            });
        });
    </script>
</body>
</html>
