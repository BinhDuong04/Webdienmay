<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
</head>
<body>

<?php include 'includes/header.php'; ?>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <main class="content p-4">
        <h2>Danh sách sản phẩm</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình</th>
                    <th>Tên sản phẩm</th>
                    <th>Loại</th>
                    <th>Trạng thái</th>
                    <th>Nhập hàng</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?= $product['id']; ?></td>
                        <td><img src="<?= base_url('uploads/' . $product['image']); ?>" width="50"></td>
                        <td><?= $product['name']; ?></td>
                        <td><?= $product['category']; ?></td>
                        <td><?= $product['status']; ?></td>
                        <td><button class="btn btn-success btn-sm">Nhập hàng</button></td>
                        <td><button class="btn btn-warning btn-sm">Sửa</button></td>
                        <td><button class="btn btn-danger btn-sm">Xóa</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
