<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý danh mục</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <?php include 'includes/header.php'; ?>
    <div class="d-flex">
        <?php include 'includes/sidebar.php'; ?>

        <main class="content p-4">
            <h2>📂 Quản lý danh mục</h2>

            <!-- Tìm kiếm -->
            <input type="text" id="search" class="form-control mb-3" placeholder="🔍 Tìm kiếm danh mục...">

            <!-- Nút thêm danh mục -->
            <button id="addCategoryBtn" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Thêm danh mục
            </button>

            <!-- Bảng danh mục -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="categoryTable">
                    <?php foreach ($categories as $category) : ?>
                        <tr id="category-<?= $category['id']; ?>">
                            <td><?= $category['id']; ?></td>
                            <td><?= esc($category['category_name']); ?></td>
                            <td><?= esc($category['description']); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn"
                                        data-id="<?= $category['id']; ?>"
                                        data-name="<?= esc($category['category_name']); ?>"
                                        data-desc="<?= esc($category['description']); ?>">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn"
                                        data-id="<?= $category['id']; ?>">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal Thêm danh mục -->
    <div class="modal fade" id="addCategoryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="newCategoryName" class="form-control mb-3" placeholder="Tên danh mục" required>
                    <textarea id="newCategoryDesc" class="form-control" placeholder="Mô tả"></textarea>
                </div>
                <div class="modal-footer">
                    <button id="saveCategoryBtn" class="btn btn-success">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Sửa danh mục -->
    <div class="modal fade" id="editCategoryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id">
                    <input type="text" id="edit_name" class="form-control mb-3" required>
                    <textarea id="edit_desc" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button id="updateCategoryBtn" class="btn btn-warning">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

<script>
    var base_url = "<?= base_url(); ?>";
</script>
<script src="<?= base_url('assets/js/categories.js'); ?>"></script>


</body>
</html>
