<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
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
            <h2>🛒 Quản lý đơn hàng</h2>
            <input type="text" id="searchOrder" class="form-control mb-3" placeholder="🔍 Tìm kiếm đơn hàng...">
            <div id="notification"></div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Hình thức thanh toán</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr id="order-<?= $order['id']; ?>">
                                <td><?= $order['id']; ?></td>
                                <td><?= esc($order['full_name']); ?></td>
                                <td><?= number_format($order['total_price'], 0, ',', '.'); ?>₫</td>
                                <td>
                                    <?= $order['payment_method'] === 'cash' ? 'Tiền mặt' : 'VNPAY'; ?>
                                </td>
                                <td><?= esc($order['address']); ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $order['status'] == 'pending' ? 'bg-warning' : 
                                            ($order['status'] == 'processing' ? 'bg-info' : 
                                            ($order['status'] == 'shipped' ? 'bg-primary' : 
                                            ($order['status'] == 'completed' ? 'bg-success' : 'bg-danger'))); ?>">
                                        <?= $order['status'] == 'pending' ? 'Chờ xử lý' : 
                                            ($order['status'] == 'processing' ? 'Đang xử lý' : 
                                            ($order['status'] == 'shipped' ? 'Đang giao hàng' : 
                                            ($order['status'] == 'completed' ? 'Hoàn thành' : 'Đã hủy'))); ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm detail-order-btn" data-id="<?= $order['id']; ?>">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </button>
                                    <button class="btn btn-warning btn-sm update-status-btn" data-id="<?= $order['id']; ?>" 
                                            data-status="<?= esc($order['status']); ?>">
                                        <i class="fas fa-sync"></i> Cập nhật
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-order-btn" data-id="<?= $order['id']; ?>">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center">Không có đơn hàng nào!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
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
                    <h5>Thông tin khách hàng</h5>
                    <p><strong>Họ tên:</strong> <span id="detailFullName"></span></p>
                    <p><strong>Địa chỉ:</strong> <span id="detailAddress"></span></p>
                    <p><strong>Số điện thoại:</strong> <span id="detailPhone"></span></p>
                    <p><strong>Tổng tiền:</strong> <span id="detailTotalPrice"></span></p>
                    <p><strong>Trạng thái:</strong> <span id="detailStatus"></span></p>
                    <p><strong>Ngày tạo:</strong> <span id="detailCreatedAt"></span></p>

                    <h6>Chi tiết sản phẩm</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
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

    <!-- Modal Cập nhật trạng thái -->
    <div class="modal fade" id="updateStatusModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật trạng thái đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateOrderId">
                    <label for="updateOrderStatus">Trạng thái:</label>
                    <select id="updateOrderStatus" class="form-control">
                        <option value="pending">Chờ xử lý</option>
                        <option value="processing">Đang xử lý</option>
                        <option value="shipped">Đang giao hàng</option>
                        <option value="completed">Hoàn thành</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button id="saveStatusBtn" class="btn btn-success">Lưu</button>
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
            // Tìm kiếm đơn hàng
            $('#searchOrder').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('#orderTable tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Xem chi tiết đơn hàng
            $('.detail-order-btn').on('click', function() {
                const orderId = $(this).data('id');
                $.ajax({
                    url: base_url + 'admin/getOrderDetails/' + orderId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
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
                                    <td>${detail.product_name || 'Unknown'}</td>
                                    <td>${detail.quantity}</td>
                                    <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(detail.price)}</td>
                                    <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(detail.quantity * detail.price)}</td>
                                </tr>`;
                        });
                        $('#orderDetailsTable').html(detailsHtml);

                        $('#detailPaymentMethod').text(data.payment.payment_method === 'cash' ? 'Tiền mặt' : 'VNPAY');
                        $('#detailPaymentStatus').text(data.payment.payment_status === 'pending' ? 'Chưa thanh toán' : 'Đã thanh toán');
                        $('#detailTransactionId').text(data.payment.transaction_id);
                        $('#detailPaymentDate').text(data.payment.payment_date ? new Date(data.payment.payment_date).toLocaleString('vi-VN') : 'Chưa thanh toán');

                        $('#orderDetailModal').modal('show');
                    },
                    error: function(xhr) {
                        showNotification('Không thể tải chi tiết đơn hàng: ' + xhr.statusText, 'danger');
                    }
                });
            });

            // Cập nhật trạng thái đơn hàng
            $('.update-status-btn').on('click', function() {
                const orderId = $(this).data('id');
                const currentStatus = $(this).data('status');
                $('#updateOrderId').val(orderId);
                $('#updateOrderStatus').val(currentStatus);
                $('#updateStatusModal').modal('show');
            });

            $('#saveStatusBtn').on('click', function() {
                const orderId = $('#updateOrderId').val();
                const newStatus = $('#updateOrderStatus').val();

                $.ajax({
                    url: base_url + 'admin/updateOrderStatus',
                    method: 'POST',
                    data: { order_id: orderId, status: newStatus },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const badgeClass = newStatus === 'pending' ? 'bg-warning' : 
                                            (newStatus === 'processing' ? 'bg-info' : 
                                            (newStatus === 'shipped' ? 'bg-primary' : 
                                            (newStatus === 'completed' ? 'bg-success' : 'bg-danger')));
                            const statusText = newStatus === 'pending' ? 'Chờ xử lý' : 
                                            (newStatus === 'processing' ? 'Đang xử lý' : 
                                            (newStatus === 'shipped' ? 'Đang giao hàng' : 
                                            (newStatus === 'completed' ? 'Hoàn thành' : 'Đã hủy')));
                            $(`#order-${orderId} .badge`).removeClass().addClass(`badge ${badgeClass}`).text(statusText);
                            $('#updateStatusModal').modal('hide');
                            showNotification('Cập nhật trạng thái thành công!', 'success');
                        } else {
                            showNotification(response.message, 'danger');
                        }
                    },
                    error: function(xhr) {
                        showNotification('Lỗi khi cập nhật trạng thái: ' + xhr.statusText, 'danger');
                    }
                });
            });

            // Xóa đơn hàng
            $('.delete-order-btn').on('click', function() {
                const orderId = $(this).data('id');
                if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
                    $.ajax({
                        url: base_url + 'admin/deleteOrder',
                        method: 'POST',
                        data: { order_id: orderId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $(`#order-${orderId}`).remove();
                                showNotification('Xóa đơn hàng thành công!', 'success');
                            } else {
                                showNotification(response.message, 'danger');
                            }
                        },
                        error: function(xhr) {
                            showNotification('Lỗi khi xóa đơn hàng: ' + xhr.statusText, 'danger');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>