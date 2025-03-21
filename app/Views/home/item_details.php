<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/product_details.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .modal { display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
        .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; }
        .close-btn { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; }
        .submit-order-btn { background-color: #4CAF50; color: white; padding: 10px; border: none; cursor: pointer; width: 100%; }
        .notification { display: none; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; }
        .notification.success { background-color: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; }
        .notification.error { background-color: #f2dede; color: #a94442; border: 1px solid #ebccd1; }
        /* CSS cho phần bình luận */
        .product-reviews .review-item { margin-bottom: 20px; padding: 10px; border-bottom: 1px solid #ddd; }
        .replies { margin-left: 20px; margin-top: 10px; }
        .reply-item { padding: 5px; background-color: #f9f9f9; }
    </style>
</head>
<body>
    <?= view('templates/header'); ?>

    <!-- Hiển thị thông báo từ flashdata (nếu có từ redirect) -->
    <?php if (session()->has('success')): ?>
        <div style="background-color: #dff0d8; color: #3c763d; padding: 15px; margin-bottom: 20px; border: 1px solid #d6e9c6; border-radius: 4px;">
            <?= session('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Div để hiển thị thông báo từ AJAX -->
    <div id="notification" class="notification"></div>

    <!-- Breadcrumb navigation -->
    <div class="breadcrumb">
        <a href="<?= base_url('/'); ?>">Trang chủ</a> /
        <a href="<?= base_url('category/' . $product['category_id']); ?>"><?= esc($product['category_name']); ?></a> /
        <span><?= esc($product['name']); ?></span>
    </div>

    <div class="product-container">
        <div class="product-left">
            <!-- Phần Hình ảnh sản phẩm -->
            <div class="main-image-container">
                <?php 
                    $imagePath = json_decode($product['image'], true); 
                    $imageUrl = !empty($imagePath) ? base_url($imagePath[0]) : base_url('assets/images/default-image.png');
                ?>
                <img id="main-image" src="<?= $imageUrl; ?>" alt="<?= esc($product['name']); ?>" class="main-image">
            </div>

            <!-- Thumbnail images -->
            <div class="thumbnail-list">
                <div class="thumbnail-main">
                    <img src="<?= $imageUrl; ?>" alt="Hình ảnh chính" class="thumbnail">
                </div>
                <?php foreach ($productImages as $image) : ?>
                    <img src="<?= base_url($image['image_url']); ?>" alt="Ảnh phụ của <?= esc($product['name']); ?>" class="thumbnail" onclick="changeMainImage('<?= base_url($image['image_url']); ?>')">
                <?php endforeach; ?>
            </div>
        </div>

        <div class="product-right">
            <!-- Phần Thông tin sản phẩm -->
            <h1><?= esc($product['name']); ?></h1>

            <p class="price">
                <?= number_format($product['price'], 0, ',', '.') ?> 
                <span class="old-price"><?= number_format($product['price'] * 1.2, 0, ',', '.') ?></span>
            </p>
            <p class="status"><strong>Tình trạng:</strong> <?= esc($productStatus); ?></p>
            
            <p class="brand">
                <strong>Thương hiệu:</strong> 
                <?= isset($productDetails['brand']) ? esc($productDetails['brand']) : 'Chưa có thông tin'; ?>
            </p>

            <!-- Số lượng sản phẩm -->
            <div class="quantity-selector">
                <label for="quantity">Số lượng:</label>
                <div class="quantity-controls">
                    <button type="button" class="quantity-btn" id="decrease-btn">-</button>
                    <input type="number" id="quantity" value="1" min="1" max="<?= esc($product['stock']); ?>" readonly>
                    <button type="button" class="quantity-btn" id="increase-btn">+</button>
                </div>
            </div>

            <!-- Phần Thông tin sản phẩm -->
            <div class="actions">
                <form action="<?= base_url('cart/addToCart/' . $product['id']); ?>" method="post" class="add-to-cart-form">
                    <input type="hidden" name="quantity" id="cart-quantity-input" value="1">
                    <button type="submit" class="add-to-cart-btn">Thêm vào giỏ hàng</button>
                </form>

                <button id="buy-now-btn">Mua ngay</button>   
            </div>

            <!-- Modal Form Đặt Hàng -->
            <div id="order-form-modal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" id="close-modal-btn">×</span>
                    <h2>Thông tin đặt hàng</h2>
                    <form action="<?= base_url('order/buyNow'); ?>" method="post" id="order-form">
                        <input type="hidden" name="product_id" value="<?= esc($product['id']); ?>">
                        <input type="hidden" name="price" value="<?= esc($product['price']); ?>">
                        <input type="hidden" name="quantity" id="order-quantity-input" value="1">

                        <div class="form-group">
                            <label for="full_name">Họ và tên</label>
                            <input type="text" name="full_name" id="full_name" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <textarea name="address" id="address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Phương thức thanh toán</label>
                            <select name="payment_method" id="payment_method" required>
                                <option value="cash">Tiền mặt</option>
                                <option value="vnpay">VNPAY</option>
                            </select>
                        </div>
                        <button type="submit" class="submit-order-btn">Đặt hàng</button>
                    </form>

                    <!-- VNPAY Form (hidden) -->
                    <form id="vnpay-form" method="POST" action="<?= base_url('vnpay_php/vnpay_create_payment.php'); ?>" style="display: none;">
                        <input type="hidden" name="amount" id="vnpay-amount">
                        <input type="hidden" name="language" value="vn">
                        <input type="hidden" name="bankCode" value="">
                        <input type="hidden" name="order_id" id="vnpay-order-id">
                        <button type="submit" id="vnpay-submit"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="product-details-container">
        <!-- Phần Mô tả sản phẩm -->
        <div class="product-description">
            <h2>Mô tả sản phẩm</h2>
            <p><?= esc($product['description']); ?></p>
        </div>

        <!-- Phần Thông số chi tiết -->
        <div class="product-specifications">
            <h2>Thông số chi tiết</h2>
            <table>
                <tr>
                    <td>Thương hiệu:</td>
                    <td><?= esc($productDetails['brand']); ?></td>
                </tr>
                <tr>
                    <td>Kích thước:</td>
                    <td><?= esc($productDetails['dimensions']); ?></td>
                </tr>
                <tr>
                    <td>Khối lượng:</td>
                    <td><?= esc($productDetails['weight']); ?> kg</td>
                </tr>
                <tr>
                    <td>Nơi sản xuất:</td>
                    <td><?= esc($productDetails['origin']); ?></td>
                </tr>
                <tr>
                    <td>Bảo hành:</td>
                    <td><?= esc($productDetails['warranty']); ?></td>
                </tr>
                <tr>
                    <td>Thông tin bổ sung:</td>
                    <td>
                        <ul>
                            <?php foreach (explode("•", $productDetails['additional_info']) as $info) : ?>
                                <?php if (trim($info) !== '') : ?>
                                    <li><?= esc(trim($info)); ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Phần Đánh giá sản phẩm trong item_details.php -->
        <div class="product-reviews">
            <h2>Đánh giá sản phẩm</h2>
            
            <!-- Form viết đánh giá -->
            <?php if (session()->get('logged_in')): ?>
                <form id="review-form" action="<?= base_url('product/addReview/' . $product['id']); ?>" method="post">
                    <label for="review">Viết đánh giá của bạn:</label>
                    <textarea name="review" id="review" required style = "width: 95%"></textarea>
                    <button type="submit">Gửi đánh giá</button>
                </form>
            <?php else: ?>
                <p>Vui lòng <a href="<?= base_url('login'); ?>">đăng nhập</a> để viết đánh giá.</p>
            <?php endif; ?>

            <!-- Danh sách đánh giá -->
            <h3>Danh sách đánh giá</h3>
            <div class="reviews-list">
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <?php if (!$comment['reply_to']): // Chỉ hiển thị bình luận chính ?>
                            <div class="review-item" id="review-item-<?= esc($comment['id']); ?>">
                                <p><strong><?= esc($comment['full_name'] ?? 'Ẩn danh'); ?>:</strong></p> <!-- Thay username bằng full_name -->
                                <p><?= esc($comment['comment']); ?></p>
                                <p><small><?= date('d/m/Y H:i', strtotime($comment['created_at'])); ?></small></p>

                                <!-- Danh sách trả lời -->
                                <div class="replies">
                                    <?php foreach ($comments as $reply): ?>
                                        <?php if ($reply['reply_to'] == $comment['id']): ?>
                                            <div class="reply-item">
                                                <p><strong><?= esc($reply['full_name'] ?? 'Ẩn danh'); ?>:</strong></p> <!-- Thay username bằng full_name -->
                                                <p><?= esc($reply['comment']); ?></p>
                                                <p><small><?= date('d/m/Y H:i', strtotime($reply['created_at'])); ?></small></p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Form trả lời đánh giá -->
                                <?php if (session()->get('logged_in')): ?>
                                    <form action="<?= base_url('product/replyReview/' . $comment['id']); ?>" method="post">
                                        <label for="reply-<?= $comment['id']; ?>">Trả lời:</label>
                                        <textarea name="reply" id="reply-<?= $comment['id']; ?>" required style="width: 90%;"></textarea>
                                        <button type="submit">Gửi trả lời</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Function to change main image when thumbnail is clicked
        function changeMainImage(imageUrl) {
            document.getElementById('main-image').src = imageUrl;
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach(thumbnail => thumbnail.classList.remove('selected'));
            const selectedThumbnail = document.querySelector(`img[src='${imageUrl}']`);
            selectedThumbnail.classList.add('selected');
        }

        // Function to show notification
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = 'notification ' + type; // success hoặc error
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000); // Ẩn sau 3 giây
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Xử lý tăng giảm số lượng sản phẩm
            const quantityInput = document.getElementById("quantity");
            const decreaseBtn = document.getElementById("decrease-btn");
            const increaseBtn = document.getElementById("increase-btn");
            const cartQuantityInput = document.getElementById("cart-quantity-input");
            const orderQuantityInput = document.getElementById("order-quantity-input");

            // Tăng số lượng
            increaseBtn.addEventListener("click", function() {
                let currentQuantity = parseInt(quantityInput.value);
                let maxQuantity = parseInt(quantityInput.getAttribute('max'));
                if (currentQuantity < maxQuantity) {
                    quantityInput.value = currentQuantity + 1;
                    cartQuantityInput.value = quantityInput.value;
                    orderQuantityInput.value = quantityInput.value;
                }
            });

            // Giảm số lượng
            decreaseBtn.addEventListener("click", function() {
                let currentQuantity = parseInt(quantityInput.value);
                if (currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                    cartQuantityInput.value = quantityInput.value;
                    orderQuantityInput.value = quantityInput.value;
                }
            });

            // Xử lý thêm vào giỏ hàng
            const addToCartForm = document.querySelector('.add-to-cart-form');
            addToCartForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const quantity = quantityInput.value;
                fetch("<?= base_url('cart/addToCart/' . $product['id']); ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: `quantity=${quantity}`
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.querySelector(".cart-count").textContent = data.count;
                        showNotification('Sản phẩm đã được thêm vào giỏ hàng!', 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi thêm vào giỏ hàng:', error);
                    showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
                });
            });

            // Xử lý "Mua ngay"
            document.getElementById('buy-now-btn').addEventListener('click', function() {
                document.getElementById('order-form-modal').style.display = 'block';
            });

            document.getElementById('close-modal-btn').addEventListener('click', function() {
                document.getElementById('order-form-modal').style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === document.getElementById('order-form-modal')) {
                    document.getElementById('order-form-modal').style.display = 'none';
                }
            });

            // Xử lý form đặt hàng
            document.getElementById('order-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Ngăn submit mặc định cho cả "cash" và "vnpay"
                const paymentMethod = document.getElementById('payment_method').value;
                const quantity = parseInt(quantityInput.value);
                const price = parseInt(<?= esc($product['price']); ?>);
                const totalAmount = price * quantity;

                fetch('<?= base_url('order/buyNow'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams(new FormData(this)).toString()
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response:', data); // Debug dữ liệu trả về
                    if (data.success) {
                        if (paymentMethod === 'cash') {
                            showNotification('Đặt hàng thành công!', 'success');
                            document.getElementById('order-form-modal').style.display = 'none';
                            // Reset form nếu cần
                            document.getElementById('order-form').reset();
                        } else if (paymentMethod === 'vnpay') {
                            document.getElementById('vnpay-amount').value = totalAmount;
                            document.getElementById('vnpay-order-id').value = data.order_id;
                            document.getElementById('vnpay-form').submit();
                        }
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi xử lý thanh toán:', error);
                    showNotification('Có lỗi xảy ra khi xử lý thanh toán!', 'error');
                });
            });
        });
    </script>

    <?= view('templates/footer'); ?>
</body>
</html>