<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <main class="content p-4">
        <h2>Bảng điều khiển</h2>

        <!-- Thống kê hệ thống -->
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Sản phẩm</div>
                    <div class="card-body">
                        <h5 class="card-title">150</h5>
                        <p class="card-text">Sản phẩm đang bán</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Đơn hàng</div>
                    <div class="card-body">
                        <h5 class="card-title">320</h5>
                        <p class="card-text">Đơn hàng đã xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Khách hàng</div>
                    <div class="card-body">
                        <h5 class="card-title">580</h5>
                        <p class="card-text">Khách hàng đăng ký</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Doanh thu</div>
                    <div class="card-body">
                        <h5 class="card-title">500M</h5>
                        <p class="card-text">Tổng doanh thu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card">
            <div class="card-header">
                <h3>Danh sách sản phẩm</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Loại</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>101</td>
                            <td><img src="<?= base_url('uploads/product1.jpg'); ?>" width="50"></td>
                            <td>iPhone 14 Pro Max</td>
                            <td>Điện thoại</td>
                            <td>28,000,000₫</td>
                            <td><span class="badge bg-success">Còn hàng</span></td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                            </td>
                        </tr>
                        <tr>
                            <td>102</td>
                            <td><img src="<?= base_url('uploads/product2.jpg'); ?>" width="50"></td>
                            <td>Samsung Galaxy S23</td>
                            <td>Điện thoại</td>
                            <td>25,000,000₫</td>
                            <td><span class="badge bg-danger">Hết hàng</span></td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
