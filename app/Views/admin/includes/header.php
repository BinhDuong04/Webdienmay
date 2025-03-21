<?php $session = session(); ?>
<header class="admin-header bg-dark text-white py-2">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="logo">
            <a href="<?= base_url('admin/dashboard') ?>" class="text-white text-decoration-none fw-bold fs-4">
                <i class="fas fa-cogs"></i> Điện Máy Tiết Kiệm
            </a>
        </div>
        <div class="admin-actions d-flex align-items-center">
            <span class="me-3">Xin chào, <strong><?= esc($session->get('admin_name') ?? 'Admin'); ?></strong></span>
            <a href="<?= base_url('login') ?>" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>
    </div>
</header>
