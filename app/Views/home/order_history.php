<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử đơn hàng - Tổng Kho Điện Máy Đỏ Hà Nội</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/introduction.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .order-table th, .order-table td { vertical-align: middle; }
        .badge { font-size: 14px; padding: 5px 10px; }
        .content-page { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .product-image { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
    <?= view('templates/header'); ?>

    <!-- Breadcrumb navigation -->
    <div class="breadcrumb">
        <a href="<?= base_url('/'); ?>">Trang chủ</a> / 
        <span>Lịch sử đơn hàng</span>
    </div>

    <!-- Page Title -->
    <div class="page-title">
        <h1>Lịch Sử Đơn Hàng</h1>
    </div>

    <!-- Content Section -->
    <div class="content-page">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success"><?= session('success'); ?></div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger"><?= session('error'); ?></div>
        <?php endif; ?>

        <div id="notification"></div>

        <table class="table table-striped order-table">
            <thead>
                <tr>
                    <th>ID Đơn hàng</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="orderTable">
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <?php foreach ($order['details'] as $index => $detail): ?>
                            <tr id="order-<?= $order['id']; ?>">
                                <?php if ($index === 0): ?>
                                    <td rowspan="<?= count($order['details']); ?>"><?= $order['id']; ?></td>
                                <?php endif; ?>
                                <td>
                                    <img src="<?= $detail['image'] ? base_url($detail['image']) : base_url('uploads/images/no-img.png'); ?>" class="product-image" alt="Hình ảnh sản phẩm">
                                </td>
                                <td><?= esc($detail['category_name']); ?></td>
                                <td><?= $detail['quantity']; ?></td>
                                <td><?= number_format($detail['price'], 0, ',', '.'); ?>₫</td>
                                <?php if ($index === 0): ?>
                                    <td rowspan="<?= count($order['details']); ?>"><?= number_format($order['total_price'], 0, ',', '.'); ?>₫</td>
                                    <td rowspan="<?= count($order['details']); ?>">
                                        <?= esc($order['payment_method']); ?>
                                    </td>
                                    <td rowspan="<?= count($order['details']); ?>">
                                        <span class="badge 
                                            <?= $order['status'] === 'pending' ? 'bg-warning' : 
                                                ($order['status'] === 'processing' ? 'bg-info' : 
                                                ($order['status'] === 'shipped' ? 'bg-primary' : 
                                                ($order['status'] === 'completed' ? 'bg-success' : 'bg-danger'))); ?>">
                                            <?= $order['status'] === 'pending' ? 'Chờ xử lý' : 
                                                ($order['status'] === 'processing' ? 'Đang xử lý' : 
                                                ($order['status'] === 'shipped' ? 'Đang giao hàng' : 
                                                ($order['status'] === 'completed' ? 'Hoàn thành' : 'Đã hủy'))); ?>
                                        </span>
                                    </td>
                                    <td rowspan="<?= count($order['details']); ?>"><?= date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td rowspan="<?= count($order['details']); ?>">
                                        <button class="btn btn-info btn-sm detail-order-btn" data-id="<?= $order['id']; ?>">
                                            <i class="fas fa-eye"></i> Chi tiết
                                        </button>
                                        <?php if ($order['status'] === 'processing'): ?>
                                            <button class="btn btn-danger btn-sm cancel-order-btn" data-id="<?= $order['id']; ?>">
                                                <i class="fas fa-times"></i> Hủy đơn
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="10" class="text-center">Bạn chưa có đơn hàng nào!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Chi tiết đơn hàng -->
    <div class="modal fade" id="orderDetailModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h5>Thông tin đơn hàng</h5>
                    <p><strong>ID Đơn hàng:</strong> <span id="detailOrderId"></span></p>
                    <p><strong>Họ tên:</strong> <span id="detailFullName"></span></p>
                    <p><strong>Địa chỉ:</strong> <span id="detailAddress"></span></p>
                    <p><strong>Số điện thoại:</strong> <span id="detailPhone"></span></p>
                    <p><strong>Tổng tiền:</strong> <span id="detailTotalPrice"></span></p>
                    <p><strong>Trạng thái:</strong> <span id="detailStatus"></span></p>
                    <p><strong>Ngày tạo:</strong> <span id="detailCreatedAt"></span></p>

                    <h6>Thông tin sản phẩm</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody id="orderDetailsTable"></tbody>
                    </table>

                    <h6>Thông tin thanh toán</h6>
                    <p><strong>Phương thức:</strong> <span id="detailPaymentMethod"></span></p>
                    <p><strong>Trạng thái:</strong> <span id="detailPaymentStatus"></span></p>
                    <p><strong>Mã giao dịch:</strong> <span id="detailTransactionId"></span></p>
                    <p><strong>Ngày thanh toán:</strong> <span id="detailPaymentDate"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var base_url = "<?= base_url(); ?>";
        
        // Function hiển thị thông báo
        function showNotification(message, type) {
            const notification = $('#notification');
            notification.html(message).addClass(`alert alert-${type}`).show();
            setTimeout(() => notification.removeClass(`alert alert-${type}`).hide(), 3000);
        }

        $(document).ready(function() {
            // Xem chi tiết đơn hàng
            $('.detail-order-btn').on('click', function() {
                const orderId = $(this).data('id');
                $.ajax({
                    url: base_url + 'order/getOrderDetails/' + orderId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#detailOrderId').text(data.order.id);
                        $('#detailFullName').text(data.order.full_name);
                        $('#detailAddress').text(data.order.address);
                        $('#detailPhone').text(data.order.phone);
                        $('#detailTotalPrice').text(new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data.order.total_price));
                        $('#detailStatus').text(data.order.status === 'pending' ? 'Chờ xử lý' : 
                                               (data.order.status === 'processing' ? 'Đang xử lý' : 
                                               (data.order.status === 'shipped' ? 'Đang giao hàng' : 
                                               (data.order.status === 'completed' ? 'Hoàn thành' : 'Đã hủy'))));
                        $('#detailCreatedAt').text(new Date(data.order.created_at).toLocaleString('vi-VN'));

                        let detailsHtml = '';
                        data.order_details.forEach(detail => {
                            detailsHtml += `
                                <tr>
                                    <td><img src="${detail.image ? base_url + detail.image : base_url + 'uploads/images/no-img.png'}" class="product-image" alt="Hình ảnh sản phẩm"></td>
                                    <td>${detail.product_name || 'Không xác định'}</td>
                                    <td>${detail.category_name || 'Không xác định'}</td>
                                    <td>${detail.quantity}</td>
                                    <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(detail.price)}</td>
                                    <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(detail.quantity * detail.price)}</td>
                                </tr>`;
                        });
                        $('#orderDetailsTable').html(detailsHtml);

                        $('#detailPaymentMethod').text(data.order.payment_method);
                        $('#detailPaymentStatus').text(data.payment.payment_status === 'pending' ? 'Chưa thanh toán' : 'Đã thanh toán');
                        $('#detailTransactionId').text(data.payment.transaction_id || 'Không có');
                        $('#detailPaymentDate').text(data.payment.payment_date ? new Date(data.payment.payment_date).toLocaleString('vi-VN') : 'Chưa thanh toán');

                        $('#orderDetailModal').modal('show');
                    },
                    error: function(xhr) {
                        showNotification('Không thể tải chi tiết đơn hàng: ' + xhr.statusText, 'danger');
                    }
                });
            });

            // Hủy đơn hàng
            $('.cancel-order-btn').on('click', function() {
                const orderId = $(this).data('id');
                if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
                    $.ajax({
                        url: base_url + 'order/cancelOrder',
                        method: 'POST',
                        data: { order_id: orderId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $(`#order-${orderId} .badge`).removeClass().addClass('badge bg-danger').text('Đã hủy');
                                $(`#order-${orderId} .cancel-order-btn`).remove();
                                showNotification('Hủy đơn hàng thành công!', 'success');
                            } else {
                                showNotification(response.message, 'danger');
                            }
                        },
                        error: function(xhr) {
                            showNotification('Lỗi khi hủy đơn hàng: ' + xhr.statusText, 'danger');
                        }
                    });
                }
            });
        });
    </script>

    <?= view('templates/footer'); ?>
</body>
</html>