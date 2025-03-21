<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/cart.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
        .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; }
        .close-btn { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; }
        .submit-order-btn { background-color: #4CAF50; color: white; padding: 10px; border: none; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <?= view('templates/header'); ?>

    <!-- Hiển thị thông báo thành công -->
    <?php if (session()->has('success')): ?>
        <div style="background-color: #dff0d8; color: #3c763d; padding: 15px; margin-bottom: 20px; border: 1px solid #d6e9c6; border-radius: 4px;">
            <?= session('success'); ?>
        </div>
    <?php endif; ?>
    <div class="breadcrumb">
        <a href="<?= base_url('/'); ?>">Trang chủ</a> / 
        <span>Giỏ hàng</span>
    </div>
    <div class="container__cart">
        <div class="page-title">
            <h1>Giỏ Hàng</h1>
            <div class="cart-info">
                <p>Tổng sản phẩm: <span id="cart-count"><?= count($cart_items); ?></span></p>
                <p>Tổng tiền: <span id="total-price">0</span> VNĐ</p>
            </div>
        </div>

        <div class="content-page">
            <form id="cart-form" method="POST">
                <table class="cart-table" style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"> Chọn tất cả</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cart_items)) : ?>
                            <?php foreach ($cart_items as $item) : ?>
                                <tr id="product-<?= esc($item['id']); ?>">
                                    <td><input type="checkbox" name="product_ids[]" value="<?= esc($item['id']); ?>" data-product-id="<?= esc($item['product_id']); ?>" data-price="<?= esc($item['price']); ?>" data-quantity="<?= esc($item['quantity']); ?>" onchange="updateTotalPrice()"></td>
                                    <td>
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="<?= base_url($item['image'][0]); ?>" alt="<?= esc($item['name']); ?>" style="width: 100px; height: auto;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['name']); ?></td>
                                    <td><?= number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                    <td>
                                        <button type="button" class="decrease" data-id="<?= esc($item['id']); ?>">-</button>
                                        <input type="number" name="quantity[<?= esc($item['product_id']); ?>]" value="<?= esc($item['quantity']); ?>" min="1" required class="quantity-input" style="width: 50px;" onchange="updateItemTotal(this, '<?= esc($item['id']); ?>')">
                                        <button type="button" class="increase" data-id="<?= esc($item['id']); ?>">+</button>
                                    </td>
                                    <td class="total-price" data-price="<?= esc($item['price']); ?>" data-quantity="<?= esc($item['quantity']); ?>">
                                        <?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">Giỏ hàng của bạn hiện đang trống.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                <button type="button" id="checkout-btn" class="btn btn-primary" style="background-color: #e60000; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s; margin-left: auto; display: block;">
                    Thanh toán
                </button>

                <button type="button" id="remove-selected" class="btn btn-danger" style="background-color:rgb(225, 158, 156); margin-top: 15px ;color: white; border: none; padding: 10px 20px; font-size: 14px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s; margin-left: auto; display: block;">
                    Xóa đã chọn
                </button>

                </div>
            </form>
        </div>

        <!-- Modal Form Đặt Hàng -->
        <div id="order-form-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn" id="close-modal-btn">×</span>
                <h2>Thông tin đặt hàng</h2>
                <form action="<?= base_url('cart/buyNow'); ?>" method="post" id="order-form">
                    <input type="hidden" name="total_price" id="modal-total-price">
                    <input type="hidden" name="cart_ids" id="modal-cart-ids">

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
                    <input type="hidden" name="cart_ids" id="vnpay-cart-ids">
                    <input type="hidden" name="order_id" id="vnpay-order-id">
                    <button type="submit" id="vnpay-submit"></button>
                </form>
            </div>
        </div>
    </div>

    <?= view('templates/footer'); ?>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            document.querySelectorAll('input[name="product_ids[]"]').forEach(checkbox => {
                checkbox.checked = this.checked;
                updateTotalPrice();
            });
        });

        const decreaseButtons = document.querySelectorAll('.decrease');
        decreaseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cartId = this.getAttribute('data-id');
                const inputField = this.nextElementSibling;
                let quantity = parseInt(inputField.value);
                if (quantity > 1) {
                    inputField.value = quantity - 1;
                    updateItemTotal(inputField, cartId);
                }
            });
        });

        const increaseButtons = document.querySelectorAll('.increase');
        increaseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cartId = this.getAttribute('data-id');
                const inputField = this.previousElementSibling;
                let quantity = parseInt(inputField.value);
                inputField.value = quantity + 1;
                updateItemTotal(inputField, cartId);
            });
        });

        function updateItemTotal(input, cartId) {
            const row = document.getElementById(`product-${cartId}`);
            if (row) {
                const price = parseInt(row.querySelector('.total-price').getAttribute('data-price'));
                const quantity = parseInt(input.value);
                const totalPrice = price * quantity;
                row.querySelector('.total-price').textContent = new Intl.NumberFormat('vi-VN').format(totalPrice) + ' VNĐ';
                row.querySelector('input[name="product_ids[]"]').setAttribute('data-quantity', quantity);
                updateTotalPrice();
            }
        }

        function updateTotalPrice() {
            const selectedCheckboxes = document.querySelectorAll('input[name="product_ids[]"]:checked');
            let total = 0;
            selectedCheckboxes.forEach(checkbox => {
                const price = parseInt(checkbox.getAttribute('data-price'));
                const quantity = parseInt(checkbox.getAttribute('data-quantity'));
                total += price * quantity;
            });
            document.getElementById('total-price').textContent = new Intl.NumberFormat('vi-VN').format(total);
        }

        document.getElementById('remove-selected').addEventListener('click', function() {
            const selectedCheckboxes = document.querySelectorAll('input[name="product_ids[]"]:checked');
            if (selectedCheckboxes.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm để xóa!');
                return;
            }

            if (!confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?')) {
                return;
            }

            const cartIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
            fetch('<?= base_url('/cart/removeProduct'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'cart_ids=' + encodeURIComponent(JSON.stringify(cartIds))
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    cartIds.forEach(id => {
                        const row = document.getElementById(`product-${id}`);
                        if (row) row.remove();
                    });
                    document.getElementById('cart-count').textContent = data.cartItems.length;
                    updateTotalPrice();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xóa sản phẩm: ' + error.message);
            });
        });

        document.getElementById('checkout-btn').addEventListener('click', function() {
            const selectedCheckboxes = document.querySelectorAll('input[name="product_ids[]"]:checked');
            if (selectedCheckboxes.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
                return;
            }

            const cartIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
            const totalPrice = parseInt(document.getElementById('total-price').textContent.replace(/[^0-9]/g, ''));

            document.getElementById('modal-total-price').value = totalPrice;
            document.getElementById('modal-cart-ids').value = JSON.stringify(cartIds);
            document.getElementById('vnpay-amount').value = totalPrice;
            document.getElementById('vnpay-cart-ids').value = JSON.stringify(cartIds);

            document.getElementById('order-form-modal').style.display = 'block';
        });

        document.getElementById('close-modal-btn').addEventListener('click', function() {
            document.getElementById('order-form-modal').style.display = 'none';
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('order-form-modal')) {
                document.getElementById('order-form-modal').style.display = 'none';
            }
        };

        document.getElementById('order-form').addEventListener('submit', function(event) {
            const paymentMethod = document.getElementById('payment_method').value;
            if (paymentMethod === 'vnpay') {
                event.preventDefault();
                fetch('<?= base_url('cart/buyNow'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams(new FormData(this)).toString()
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('vnpay-order-id').value = data.order_id;
                        document.getElementById('vnpay-submit').click();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi xử lý thanh toán!');
                });
            }
        });

        updateTotalPrice(); // Cập nhật tổng tiền ban đầu
    </script>
</body>
</html>