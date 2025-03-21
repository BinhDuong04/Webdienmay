<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= esc($category['category_name']); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/category_product.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?= base_url('assets/js/category_product.js'); ?>"></script>
</head>
<body>

    <?= view('templates/header'); ?>

    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="<?= base_url(); ?>">Trang chủ</a> / 
            <span><?= esc($category['category_name']); ?></span>
        </nav>

        <div class="main-container">
            <!-- Bộ lọc sản phẩm -->
            <div class="filter-menu">
                <h3>HÃNG</h3>
                <ul class="brand-list">
                    <?php if (!empty($brands)): ?>
                        <?php foreach ($brands as $brand) : ?>
                            <?php if (!empty($brand['brand'])) : ?> 
                                <li>
                                    <input type="checkbox" class="filter-brand" value="<?= esc($brand['brand']); ?>"> 
                                    <?= esc($brand['brand']); ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Không có hãng nào</li>
                    <?php endif; ?>
                </ul>

                <h3>MỨC GIÁ</h3>
                <ul class="price-list">
                    <li><input type="checkbox" class="filter-price" value="under-5000000"> Giá dưới 5.000.000đ</li>
                    <li><input type="checkbox" class="filter-price" value="5000000-10000000"> 5.000.000đ - 10.000.000đ</li>
                    <li><input type="checkbox" class="filter-price" value="over-10000000"> Trên 10.000.000đ</li>
                </ul>
            </div>

            <!-- Hiển thị sản phẩm -->
            <div class="content">
                <h2><?= esc($category['category_name']); ?></h2>

                <!-- Sắp xếp sản phẩm -->
                <div class="sort-options">
                    <span>Sắp xếp:</span>
                    <button class="sort-btn" data-sort="name-asc">Tên A → Z</button>
                    <button class="sort-btn" data-sort="name-desc">Tên Z → A</button>
                    <button class="sort-btn" data-sort="price-asc">Giá tăng dần</button>
                    <button class="sort-btn" data-sort="price-desc">Giá giảm dần</button>
                    
                </div>

                <div id="filtered-products">
                    <div id="filtered-category-<?= esc($category['id']); ?>" class="filtered-category">
                    <div class="filtered-grid">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <a href="<?= base_url('home/item_details/' . $product['id']); ?>" class="product-card" 
                                    data-brand="<?= esc($product['brand']); ?>" 
                                    data-price="<?= $product['price']; ?>"
                                    data-created-at="<?= esc($product['created_at']); ?>">

                                    <div class="product-image">
                                        <?php 
                                            $images = json_decode($product['image'], true);
                                            $imageUrl = !empty($images) ? base_url($images[0]) : base_url('assets/images/no-image.png');
                                        ?>
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
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="no-product-message">Không có sản phẩm nào phù hợp với bộ lọc của bạn.</p>
                        <?php endif; ?>
                    </div>

                    </div>
                </div>

                <input type="hidden" id="currentPage" value="<?= esc($currentPage); ?>">
                <input type="hidden" id="totalPages" value="<?= esc($totalPages); ?>">

                <!-- Phần phân trang -->
                <ul class="pagination"></ul>


            </div>
        </div>

        <!-- Sản phẩm khác -->
        <div class="other-products">
            <h2>Sản phẩm khác</h2>
            <div class="product-grid">
                <?php if (!empty($otherProducts)): ?>
                    <?php foreach ($otherProducts as $product) : ?>
                        <a href="<?= base_url('home/item_details/' . $product['id']); ?>" class="product-card">
                            <?php 
                                $images = json_decode($product['image'], true); 
                                $imageUrl = !empty($images) ? base_url($images[0]) : base_url('assets/images/no-image.png');
                            ?>
                            <?php if ($product['stock'] < 3) : ?>
                                <span class="low-stock">🔥 Sắp hết hàng!</span>
                            <?php endif; ?>
                            <img src="<?= $imageUrl; ?>" alt="<?= esc($product['name']); ?>">
                            <h4><?= esc($product['name']); ?></h4>
                            <p class="price"><?= number_format($product['price'], 0, ',', '.'); ?> VND</p>
                            <p class="old-price"><?= number_format($product['price'] * 1.2, 0, ',', '.'); ?> VND</p>
                            <p class="stock">Còn lại: <?= $product['stock']; ?> sản phẩm</p>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?= min(100, (100 - $product['stock'] * 5)) ?>%;"></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-product-message">Không có sản phẩm khác.</p>
                <?php endif; ?>
            </div>
        </div>


    <?= view('templates/footer'); ?>
</body>
</html>
