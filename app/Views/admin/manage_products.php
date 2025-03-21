<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
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
            <h2>🛒 Quản lý sản phẩm</h2>
            <input type="text" id="searchProduct" class="form-control mb-3" placeholder="🔍 Tìm kiếm sản phẩm...">
            <button id="addProductBtn" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
            <div id="notification"></div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product) : ?>
                            <tr id="product-<?= $product['id']; ?>">
                                <td><?= $product['id']; ?></td>
                                <td>
                                    <?php 
                                    $images = json_decode($product['image'], true);
                                    if (!empty($images) && is_array($images)) {
                                        $firstImage = base_url(str_replace('\/', '/', $images[0]));
                                    } else {
                                        $firstImage = base_url('uploads/images/no-img.png');
                                    }
                                    ?>
                                    <img src="<?= esc($firstImage); ?>" width="50" height="50" class="rounded"
                                         data-images='<?= json_encode($images, JSON_UNESCAPED_SLASHES); ?>'>
                                </td>
                                <td><?= esc($product['name']); ?></td>
                                <td><?= esc($product['category_name']); ?></td>
                                <td><?= number_format($product['price'], 0, ',', '.'); ?>₫</td>
                                <td><?= $product['stock']; ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm detail-product-btn" data-id="<?= $product['id']; ?>">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </button>
                                    <button class="btn btn-warning btn-sm edit-product-btn"
                                            data-id="<?= $product['id']; ?>"
                                            data-name="<?= esc($product['name']); ?>"
                                            data-category="<?= $product['category_id']; ?>"
                                            data-price="<?= $product['price']; ?>"
                                            data-stock="<?= $product['stock']; ?>"
                                            data-desc="<?= esc($product['description']); ?>">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-product-btn" data-id="<?= $product['id']; ?>">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Không có sản phẩm nào!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal Thêm sản phẩm -->
    <div class="modal fade" id="addProductModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="newProductName" class="form-control mb-3" placeholder="Tên sản phẩm" required>
                    <select id="newProductCategory" class="form-control mb-3">
                        <option value="">Chọn danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id']; ?>"><?= esc($category['category_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" id="newProductPrice" class="form-control mb-3" placeholder="Giá" required onkeyup="formatCurrency(this)">
                    <input type="number" id="newProductStock" class="form-control mb-3" placeholder="Số lượng" required>
                    <textarea id="newProductDesc" class="form-control mb-3" placeholder="Mô tả"></textarea>
                    <input type="file" id="newProductImage" class="form-control mb-3" multiple>
                </div>
                <div class="modal-footer">
                    <button id="saveProductBtn" class="btn btn-success">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sửa sản phẩm -->
    <div class="modal fade" id="editProductModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editProductId">
                    <input type="text" id="editProductName" class="form-control mb-3" required>
                    <select id="editProductCategory" class="form-control mb-3">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id']; ?>"><?= esc($category['category_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" id="editProductPrice" class="form-control mb-3" required onkeyup="formatCurrency(this)">
                    <input type="number" id="editProductStock" class="form-control mb-3" required>
                    <textarea id="editProductDesc" class="form-control mb-3"></textarea>

                    <label>Ảnh hiện tại:</label>
                    <div id="editProductImagesPreview" class="mb-3"></div>

                    <label>Chọn ảnh mới (Nếu cần thay đổi):</label>
                    <input type="file" id="editProductImage" class="form-control mb-3" multiple>
                </div>
                <div class="modal-footer">
                    <button id="updateProductBtn" class="btn btn-warning">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Chi tiết sản phẩm -->
    <div class="modal fade" id="productDetailModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h5 id="detailProductName"></h5>
                    <p><strong>Danh mục:</strong> <span id="detailProductCategory"></span></p>
                    <p><strong>Giá:</strong> <span id="detailProductPrice"></span></p>
                    <p><strong>Số lượng:</strong> <span id="detailProductStock"></span></p>
                    <p><strong>Mô tả:</strong> <span id="detailProductDesc"></span></p>

                    <h6>Thông số kỹ thuật</h6>
                    <input type="hidden" id="detailProductId">
                    <input type="text" id="detailBrand" class="form-control mb-2" placeholder="Thương hiệu">
                    <input type="text" id="detailOrigin" class="form-control mb-2" placeholder="Xuất xứ">
                    <input type="text" id="detailWarranty" class="form-control mb-2" placeholder="Bảo hành">
                    <input type="text" id="detailWeight" class="form-control mb-2" placeholder="Khối lượng (kg)">
                    <input type="text" id="detailDimensions" class="form-control mb-2" placeholder="Kích thước (DxRxC)">
                    <textarea id="detailAdditionalInfo" class="form-control mb-2" placeholder="Thông tin bổ sung"></textarea>

                    <h6>Hình ảnh chi tiết</h6>
                    <div id="detailProductImages" class="d-flex flex-wrap"></div>

                    <h6>Tải lên hình ảnh</h6>
                    <input type="file" id="uploadProductImages" class="form-control mb-2" multiple>
                    <textarea id="uploadImageDescriptions" class="form-control mb-2" placeholder="Mô tả cho ảnh"></textarea>
                    <button id="uploadImagesBtn" class="btn btn-primary">Tải lên</button>

                    </div>
                    <div class="modal-footer">
                        <button id="saveProductDetails" class="btn btn-success">Lưu thay đổi</button>
                    </div>
            </div>
        </div>
</div>

    <script> var base_url = "<?= base_url(); ?>"; </script>
    <script src="<?= base_url('assets/js/products.js'); ?>"></script>

</body>
</html>
