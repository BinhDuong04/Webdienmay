<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/home.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <?= view('templates/header'); ?>

    <div class="container">
        <div class="main-container">
           <!-- Menu bên trái -->
            <div class="container-menu">
                <h3>Danh Mục Sản Phẩm</h3>
                <ul class="category-list">
                    <?php if (!empty($categories)) : ?>
                        <?php foreach ($categories as $category) : ?>
                            <li>
                                <i class="fa-solid fa-tv"></i> 
                                <a href="<?= base_url('category/' . $category['id']); ?>">
                                    <?= esc($category['category_name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li>Không có danh mục nào</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="container-content">
                <h2>DANH SÁCH SẢN PHẨM MỚI NHẤT</h2>
                <div class="product-list">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product) : ?>
                            <div class="product-item">
                                <a href="<?= base_url('home/item_details/' . $product['id']); ?>"> <!-- Add this anchor tag -->
                                    <?php 
                                        $images = json_decode($product['image'], true); 
                                        $imageUrl = !empty($images) ? base_url($images[0]) : base_url('assets/images/no-image.png');
                                    ?>
                                    <div class="product-image">
                                        <img src="<?= $imageUrl; ?>" alt="<?= esc($product['name']); ?>">
                                        <?php if ($product['stock'] < 3) : ?>
                                            <span class="low-stock">🔥 Sắp hết hàng!</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-details">
                                        <h3><?= esc($product['name']); ?></h3>
                                        <p class="price"><?= number_format($product['price'], 0, ',', '.'); ?> VND</p>
                                        <p class="old-price"><?= number_format($product['price'] * 1.2, 0, ',', '.'); ?> VND</p>
                                        <p class="stock">Còn lại: <?= $product['stock']; ?> sản phẩm</p>
                                        <div class="progress-bar">
                                            <div class="progress" style="width: <?= min(100, (100 - $product['stock'] * 5)) ?>%;"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không tìm thấy sản phẩm phù hợp với từ khóa.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div> <!-- End main-container -->

        <!-- SECTION BRAND -->
        <div class="section-brand">
            <div class="brand-container">
                <div class="brand-list">
                    <img src="<?= base_url('uploads/images/section_brand.png'); ?>" alt="Brand 1">
                    <img src="<?= base_url('uploads/images/section_brand1.png'); ?>" alt="Brand 2">
                    <img src="<?= base_url('uploads/images/section_brand2.png'); ?>" alt="Brand 3">
                    <img src="<?= base_url('uploads/images/section_brand3.png'); ?>" alt="Brand 4">
                </div>
            </div>
        </div>

        <section class="highlight-categories">
            <h2>Danh Mục Nổi Bật</h2>
            <div class="category-container">
                <?php foreach ($randomCategories as $category) : ?>
                    <div class="category-box">
                        <h3><?= esc($category['category_name']); ?></h3>
                        <div class="product-grid">
                            <?php foreach ($productsByCategory[$category['id']] as $product) : ?>
                                <?php 
                                    $images = json_decode($product['image'], true);
                                    $imageUrl = !empty($images) ? base_url($images[0]) : base_url('assets/images/no-image.png');
                                ?>
                                <!-- For product-card (Inside the highlight-categories and other-products) -->
                                <div class="product-card">
                                    <a href="<?= base_url('home/item_details/' . $product['id']); ?>"> <!-- Add this anchor tag -->
                                        <div class="product-image">
                                            <img src="<?= $imageUrl; ?>" alt="<?= esc($product['name']); ?>">
                                            <?php if ($product['stock'] < 3) : ?>
                                                <span class="low-stock">🔥 Sắp hết hàng!</span>
                                            <?php endif; ?>
                                        </div>
                                        <h4><?= esc($product['name']); ?></h4>
                                        <p class="price"><?= number_format($product['price'], 0, ',', '.'); ?> VND</p>
                                        <p class="old-price"><?= number_format($product['price'] * 1.2, 0, ',', '.'); ?> VND</p>
                                        <p class="stock">Còn lại: <?= $product['stock']; ?> sản phẩm</p>
                                        <div class="progress-bar">
                                            <div class="progress" style="width: <?= min(100, (100 - $product['stock'] * 5)) ?>%;"></div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= base_url('category/' . $category['id']); ?>" class="btn-view-all">Xem tất cả</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>



        <!-- SECTION BRAND -->
        <div class="section-brand">
            <div class="brand-container__2">
                <div class="brand-list__2">
                    <img src="<?= base_url('uploads/images/section_brand4.png'); ?>" alt="Brand 1">
                    <img src="<?= base_url('uploads/images/section_brand5.png'); ?>" alt="Brand 2">
                    <img src="<?= base_url('uploads/images/section_brand6.png'); ?>" alt="Brand 3">
                </div>
            </div>
        </div>

        <section class="other-products">
            <h2>Sản Phẩm Khác</h2>

            <!-- Button selection for categories -->
            <div id="category-menu">
                <?php foreach ($remainingCategories as $category) : ?>
                    <button id="category-btn-<?= $category['id']; ?>" class="category-btn" data-category-id="<?= $category['id']; ?>">
                        <?= esc($category['category_name']); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div id="category-products">
                <?php foreach ($remainingCategories as $category) : ?>
                    <div id="category-<?= $category['id']; ?>" class="product-category" style="display: <?= $category['id'] == $firstCategoryId ? 'block' : 'none'; ?>;">
                        <div class="product-grid">
                            <?php foreach ($otherProducts[$category['id']] as $product) : ?>
                                <?php 
                                    // Đảm bảo lấy đúng hình ảnh cho mỗi sản phẩm
                                    $images = json_decode($product['image'], true);
                                    $imageUrl = !empty($images) ? base_url($images[0]) : base_url('assets/images/no-image.png');
                                ?>
                                <div class="product-card">
                                    <a href="<?= base_url('home/item_details/' . $product['id']); ?>">
                                        <div class="product-image">
                                            <img src="<?= $imageUrl; ?>" alt="<?= esc($product['name']); ?>">
                                            <?php if ($product['stock'] < 3) : ?>
                                                <span class="low-stock">🔥 Sắp hết hàng!</span>
                                            <?php endif; ?>
                                        </div>
                                        <h4><?= esc($product['name']); ?></h4>
                                        <p class="price"><?= number_format($product['price'], 0, ',', '.'); ?> VND</p>
                                        <p class="old-price"><?= number_format($product['price'] * 1.2, 0, ',', '.'); ?> VND</p>
                                        <p class="stock">Còn lại: <?= $product['stock']; ?> sản phẩm</p>
                                        <div class="progress-bar">
                                            <div class="progress" style="width: <?= min(100, (100 - $product['stock'] * 5)) ?>%;"></div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="<?= base_url('category/' . $category['id']); ?>" class="btn-view-all">Xem tất cả</a>
        </section>




    </div>

    <?= view('templates/footer'); ?>

    <script>
        // Hàm để chuyển giữa các button danh mục
        function filterByCategory(categoryId) {
            // Ẩn tất cả các sản phẩm
            var allCategories = document.querySelectorAll('.product-category');
            allCategories.forEach(function (category) {
                category.style.display = 'none';
            });

            // Hiển thị sản phẩm theo danh mục được chọn
            document.getElementById('category-' + categoryId).style.display = 'block';

            // Đổi màu nền cho button được chọn
            var allButtons = document.querySelectorAll('.category-btn');
            allButtons.forEach(function (button) {
                button.style.backgroundColor = '';  // Reset tất cả màu nền
            });

            // Chọn button được nhấn và thay đổi màu nền
            var selectedButton = document.querySelector('.category-btn[data-category-id="' + categoryId + '"]');
            selectedButton.style.backgroundColor = 'red';  // Màu nền đỏ khi chọn
        }

        // Mặc định chọn button đầu tiên khi trang tải
        window.onload = function() {
            var firstCategoryId = <?= isset($firstCategoryId) ? json_encode($firstCategoryId) : 'null'; ?>;
            if (firstCategoryId) {
                // Hiển thị sản phẩm của danh mục đầu tiên
                filterByCategory(firstCategoryId);
            }

            // Đổi màu nền cho button của danh mục đầu tiên
            var firstButton = document.querySelector('.category-btn[data-category-id="' + firstCategoryId + '"]');
            if (firstButton) {
                firstButton.style.backgroundColor = 'red'; // Màu nền đỏ khi chọn
            }
        };

        // Xử lý click vào danh mục
        document.querySelectorAll('.category-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var categoryId = this.getAttribute('data-category-id');
                filterByCategory(categoryId);
            });
        });

    </script>

</body>
</html>

