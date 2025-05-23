<?php
require_once("./config.php");
require_once("../app/Models/OrderModel.php");
require_once("../app/Models/PaymentModel.php");
require_once("../app/Models/CartModel.php");

$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

unset($inputData['vnp_SecureHash']);
ksort($inputData);
$hashData = "";
$i = 0;
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashData .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}

$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
$cartIds = json_decode($_GET['cart_ids'], true);
$orderId = $_GET['vnp_TxnRef'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VNPAY RESPONSE</title>
    <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
    <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">         
    <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <?php
            if ($secureHash == $vnp_SecureHash) {
                if ($_GET['vnp_ResponseCode'] == '00') {
                    $orderModel = new \App\Models\OrderModel();
                    $paymentModel = new \App\Models\PaymentModel();
                    $cartModel = new \App\Models\CartModel();

                    $paymentModel->updatePaymentStatus($_GET['vnp_TransactionNo'], 'paid');
                    $orderModel->update($orderId, ['status' => 'processing']);
                    $cartModel->whereIn('id', $cartIds)->delete();

                    echo "<span style='color:blue'>Giao dịch thành công</span>";
                } else {
                    echo "<span style='color:red'>Giao dịch không thành công</span>";
                }
            } else {
                echo "<span style='color:red'>Chữ ký không hợp lệ</span>";
            }
            ?>

            <div class="form-group">
                <label>Mã đơn hàng:</label>
                <label><?php echo $_GET['vnp_TxnRef']; ?></label>
            </div>    
            <div class="form-group">
                <label>Số tiền:</label>
                <label><?php echo number_format($_GET['vnp_Amount'] / 100, 0, ',', '.'); ?> VNĐ</label>
            </div>  
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label><?php echo $_GET['vnp_OrderInfo']; ?></label>
            </div> 
            <div class="form-group">
                <label>Mã phản hồi:</label>
                <label><?php echo $_GET['vnp_ResponseCode']; ?></label>
            </div> 
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label><?php echo $_GET['vnp_TransactionNo']; ?></label>
            </div> 
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label><?php echo $_GET['vnp_BankCode']; ?></label>
            </div> 
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label><?php echo $_GET['vnp_PayDate']; ?></label>
            </div> 
            <div class="form-group">
                <label>Kết quả:</label>
                <label>
                    <?php
                    if ($secureHash == $vnp_SecureHash) {
                        if ($_GET['vnp_ResponseCode'] == '00') {
                            echo "<span style='color:blue'>Giao dịch thành công</span>";
                        } else {
                            echo "<span style='color:red'>Giao dịch không thành công</span>";
                        }
                    } else {
                        echo "<span style='color:red'>Chữ ký không hợp lệ</span>";
                    }
                    ?>
                </label>
            </div> 
        </div>
        <footer class="footer">
            <p>© VNPAY <?php echo date('Y'); ?></p>
        </footer>
    </div>  
</body>
</html>