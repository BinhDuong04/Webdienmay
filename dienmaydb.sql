-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 07, 2025 lúc 11:53 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dienmaydb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(16, 10, 37, 2, '2025-03-17 15:39:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `description`, `created_at`) VALUES
(6, 'Tivi', 'tv', '2025-03-03 03:25:32'),
(7, 'Tủ lạnh', 'Tủ Lạnh', '2025-03-03 14:04:34'),
(8, 'Máy giặt', 'Máy giặt', '2025-03-03 19:40:26'),
(9, 'Máy sấy', 'Máy sấy', '2025-03-04 13:31:54'),
(10, 'Máy rửa bát', 'Máy rửa bát', '2025-03-04 13:32:25'),
(11, 'Điều hòa', 'Điều hòa', '2025-03-04 13:32:45'),
(12, 'Đồ gia dụng', 'Đồ gia dụng', '2025-03-04 13:33:14'),
(13, 'Loa - dàn âm thanh', 'âm thanh', '2025-03-15 17:28:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `product_id`, `comment`, `created_at`, `reply_to`) VALUES
(1, 10, 36, 'Sản phẩm tốt', '2025-03-17 11:03:28', NULL),
(2, 10, 35, 'Sản phẩm tốt', '2025-03-17 11:24:28', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `author_id`, `created_at`, `updated_at`) VALUES
(21, 'Tủ Lạnh Tổng Kho Điện Máy Đỏ Hà Nội Hay Các Kho Hàng Khác Nên Chọn Mua Ở Đâu?', 'Khi bạn quyết định mua một chiếc tủ lạnh, việc lựa chọn giữa Tổng Kho Điện Máy Đỏ Hà Nội hay các kho hàng khác phụ thuộc vào một số yếu tố quan trọng sau:\r\n\r\n1. Chất lượng sản phẩm:\r\nTổng Kho Điện Máy Đỏ Hà Nội thường có danh tiếng về chất lượng sản phẩm và sự đa dạng các loại tủ lạnh từ các thương hiệu nổi tiếng. Nếu bạn mua từ một cửa hàng uy tín như vậy, bạn sẽ yên tâm hơn về nguồn gốc và chất lượng sản phẩm. Các kho hàng khác cũng có thể cung cấp sản phẩm chất lượng, nhưng cần kiểm tra kỹ thông tin về bảo hành và xuất xứ để tránh mua phải hàng giả hoặc kém chất lượng.\r\n\r\n2. Giá cả:\r\nTổng Kho Điện Máy Đỏ có thể cung cấp các mức giá cạnh tranh nhờ vào các chiến lược khuyến mãi hoặc giảm giá đặc biệt. Họ thường xuyên có các chương trình ưu đãi lớn cho khách hàng. Các kho hàng khác có thể cung cấp mức giá thấp hơn hoặc có những ưu đãi riêng, nhưng cần chú ý rằng giá rẻ đôi khi đi kèm với sản phẩm có chất lượng không đồng đều.\r\n\r\n3. Dịch vụ khách hàng và bảo hành:\r\nTổng Kho Điện Máy Đỏ nổi bật với dịch vụ chăm sóc khách hàng tốt và chính sách bảo hành rõ ràng. Nếu có sự cố về sản phẩm, họ thường xử lý nhanh chóng và chuyên nghiệp. Các kho hàng khác có thể có dịch vụ hỗ trợ khách hàng và bảo hành tốt, nhưng bạn nên xem xét các đánh giá từ những khách hàng trước để chắc chắn.\r\n\r\n4. Vị trí và giao hàng:\r\nNếu bạn ở Hà Nội hoặc khu vực gần Tổng Kho Điện Máy Đỏ, việc mua sắm và giao hàng sẽ thuận tiện hơn rất nhiều vì kho này có thể cung cấp dịch vụ giao hàng nhanh chóng. Các kho hàng khác ở xa có thể có dịch vụ giao hàng chậm hơn hoặc bạn sẽ phải trả thêm phí vận chuyển nếu ở xa.\r\n\r\n5. Khuyến mãi và quà tặng:\r\nTổng Kho Điện Máy Đỏ thường xuyên có các chương trình khuyến mãi hấp dẫn hoặc quà tặng kèm theo khi mua sản phẩm. Các kho hàng khác có thể có những ưu đãi riêng nhưng cần so sánh kỹ với các chương trình khuyến mãi từ Điện Máy Đỏ.', 'uploads/news/1742237843_efbd84162b357d4d31e4.png', NULL, '2025-03-17 11:57:23', '2025-03-17 11:57:23'),
(22, 'Hướng Dẫn Sử Dụng Tủ Lạnh Inverter Hiệu Quả Nhất - Tiết Kiệm Điện & Tăng Tuổi Thọ', 'Tủ lạnh Inverter ngày nay ngày càng trở nên phổ biến nhờ khả năng tiết kiệm năng lượng và duy trì nhiệt độ ổn định, giúp bảo quản thực phẩm lâu dài hơn. Tuy nhiên, để sử dụng tủ lạnh Inverter hiệu quả và kéo dài tuổi thọ của thiết bị, bạn cần tuân thủ một số nguyên tắc sau đây.\r\n\r\nĐầu tiên, bạn cần cài đặt nhiệt độ tủ lạnh ở mức lý tưởng. Nhiệt độ tủ lạnh nên dao động từ 3°C đến 5°C để bảo quản thực phẩm tốt nhất. Nếu tủ lạnh quá lạnh, nó sẽ tiêu tốn nhiều điện năng và có thể làm đông cứng thực phẩm. Ngăn đông của tủ lạnh cũng nên giữ ở mức -18°C, giúp bảo quản thực phẩm đông lạnh mà không làm mất chất lượng.\r\n\r\nTiếp theo, bạn phải đảm bảo cửa tủ lạnh luôn được đóng chặt. Kiểm tra và đảm bảo rằng cửa tủ lạnh không bị hở, vì khi đó hơi lạnh có thể thoát ra ngoài, gây tiêu tốn điện năng và làm giảm hiệu quả làm lạnh. Đặc biệt, gioăng cửa cần được vệ sinh định kỳ để đảm bảo chúng không bị mài mòn và giữ kín hơi lạnh trong tủ.\r\n\r\nVị trí đặt tủ lạnh cũng rất quan trọng. Bạn cần đặt tủ lạnh ở nơi thoáng mát, tránh để gần bếp hoặc các thiết bị tỏa nhiệt khác. Nếu tủ lạnh đặt gần nguồn nhiệt, nó sẽ phải làm việc nhiều hơn để duy trì nhiệt độ, làm tăng mức tiêu thụ điện. Ngoài ra, bạn cũng cần đảm bảo tủ lạnh không bị vướng vào các vật cản và để cách xa tường để giúp hệ thống làm mát hoạt động hiệu quả.\r\n\r\nMột yếu tố quan trọng trong việc sử dụng tủ lạnh là sắp xếp thực phẩm hợp lý. Không nên để thực phẩm quá chật trong tủ lạnh, vì điều này sẽ ngăn cản không khí lạnh lưu thông, khiến tủ lạnh phải làm việc liên tục. Nếu có thể, hãy để thực phẩm nguội hoàn toàn trước khi cho vào tủ lạnh để tránh làm tăng nhiệt độ bên trong tủ, điều này sẽ giúp tiết kiệm điện năng.\r\n\r\nVệ sinh tủ lạnh định kỳ là rất quan trọng. Vệ sinh cả bên trong và bên ngoài tủ sẽ giúp duy trì hiệu suất làm lạnh và ngăn ngừa sự phát triển của vi khuẩn. Ngoài ra, bạn cần kiểm tra dàn lạnh và dàn nóng của tủ lạnh, vì nếu chúng bị bám bụi sẽ làm giảm hiệu quả làm mát. Để tránh tình trạng băng tuyết bám vào ngăn đông, bạn cũng nên đóng băng tủ lạnh định kỳ.\r\n\r\nTủ lạnh Inverter thường có chế độ tiết kiệm năng lượng, giúp giảm mức tiêu thụ điện khi không cần làm lạnh quá mạnh. Bạn nên tận dụng các chế độ tiết kiệm điện này để giảm chi phí điện năng. Ngoài ra, một số tủ lạnh Inverter cũng có chế độ nghỉ đông, giúp giảm mức tiêu thụ điện trong các thời gian không sử dụng hoặc khi cửa tủ lạnh không mở lâu.\r\nKiểm tra dàn lạnh và máy nén của tủ lạnh cũng rất quan trọng. Dàn lạnh và máy nén cần được làm sạch và bảo dưỡng định kỳ để đảm bảo hiệu suất làm lạnh tối ưu. Nếu máy nén gặp trục trặc, tủ lạnh sẽ phải làm việc nhiều hơn để duy trì nhiệt độ, điều này sẽ gây tốn điện năng.\r\nNgoài ra, việc lựa chọn thực phẩm phù hợp cũng giúp tủ lạnh hoạt động hiệu quả hơn. Bạn nên tránh để thực phẩm lâu quá mức trong tủ lạnh, vì điều này sẽ không chỉ làm giảm chất lượng thực phẩm mà còn khiến tủ lạnh phải hoạt động nhiều hơn để bảo quản.\r\nMột số tủ lạnh Inverter hiện nay còn hỗ trợ kết nối với ứng dụng điện thoại, giúp bạn điều chỉnh nhiệt độ và các chế độ hoạt động từ xa. Việc sử dụng ứng dụng này sẽ giúp bạn dễ dàng kiểm soát mức độ tiêu thụ năng lượng và điều chỉnh các thiết lập để tiết kiệm điện.\r\nCuối cùng, bạn nên kiểm tra hiệu suất của tủ lạnh định kỳ để đảm bảo tủ lạnh luôn hoạt động ở mức tối ưu. Việc kiểm tra các bộ lọc và các thiết lập của tủ lạnh sẽ giúp duy trì tuổi thọ của tủ và tiết kiệm năng lượng.\r\nĐể sử dụng tủ lạnh Inverter hiệu quả nhất, bạn cần đảm bảo tủ lạnh được đặt ở nơi thoáng mát, duy trì nhiệt độ ổn định, sắp xếp thực phẩm hợp lý và thực hiện vệ sinh định kỳ. Điều này không chỉ giúp tiết kiệm điện mà còn giúp kéo dài tuổi thọ của tủ lạnh, giữ cho các thực phẩm được bảo quản lâu dài và tươi ngon.\r\n', 'uploads/news/1742237978_7790206dd32ef0f0c636.png', NULL, '2025-03-17 11:59:38', '2025-03-17 11:59:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `order_date`, `created_at`, `updated_at`, `full_name`, `address`, `phone`) VALUES
(12, 8, 4650000.00, 'shipped', '2025-03-17 19:05:35', '2025-03-17 19:05:35', '2025-03-17 19:11:25', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(13, 8, 1300000.00, 'pending', '2025-03-17 19:07:47', '2025-03-17 19:07:47', '2025-03-17 19:07:47', 'Tuấn Anh', '12A Đường Nguyễn Trãi, Quận 5, TP.HCM, Việt Nam', '0912345678'),
(14, 8, 3700000.00, 'processing', '2025-03-17 19:10:54', '2025-03-17 19:10:54', '2025-03-17 19:10:54', 'Hoàng Văn Duy', '333 Đường Cộng Hòa, Phường 13, Quận Tân Bình, TP.HCM, Việt Nam', '0843210987'),
(15, 8, 1200000.00, '', '2025-03-17 19:12:24', '2025-03-17 19:12:24', '2025-03-17 19:13:13', 'Lê Minh Quân', '78 Đường Phan Đình Phùng, Phường 7, Quận Phú Nhuận, TP.HCM, Việt Nam', '0987654321'),
(16, 10, 1300000.00, 'processing', '2025-03-17 19:14:31', '2025-03-17 19:14:31', '2025-03-17 19:14:31', 'Phạm Thị Mai Lan', '221 Đường Nguyễn Huệ, Phường Bến Thành, Quận 1, TP.HCM, Việt Nam', '0934567890'),
(17, 8, 4650000.00, 'pending', '2025-03-19 00:16:14', '2025-03-19 00:16:14', '2025-03-19 00:16:14', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(18, 8, 4650000.00, 'pending', '2025-03-19 00:16:15', '2025-03-19 00:16:15', '2025-03-19 00:16:15', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(19, 8, 6300000.00, 'pending', '2025-03-19 00:19:18', '2025-03-19 00:19:18', '2025-03-19 00:19:18', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(20, 8, 6300000.00, 'pending', '2025-03-19 00:19:19', '2025-03-19 00:19:19', '2025-03-19 00:19:19', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(21, 8, 7500000.00, 'pending', '2025-03-21 00:54:34', '2025-03-21 00:54:34', '2025-03-21 00:54:34', 'Tuấn Anh', 'Mỹ Đình, Nam Từ Liêm, Hà Nội', '0345591612'),
(22, 8, 7500000.00, 'pending', '2025-03-21 00:54:36', '2025-03-21 00:54:36', '2025-03-21 00:54:36', 'Tuấn Anh', 'Mỹ Đình, Nam Từ Liêm, Hà Nội', '0345591612'),
(23, 8, 7500000.00, 'pending', '2025-03-21 00:54:36', '2025-03-21 00:54:36', '2025-03-21 00:54:36', 'Tuấn Anh', 'Mỹ Đình, Nam Từ Liêm, Hà Nội', '0345591612'),
(24, 8, 10900000.00, 'pending', '2025-03-21 00:55:06', '2025-03-21 00:55:06', '2025-03-21 00:55:06', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(25, 8, 9300000.00, 'pending', '2025-03-21 01:01:57', '2025-03-21 01:01:57', '2025-03-21 01:01:57', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(26, 8, 10900000.00, 'pending', '2025-03-21 03:59:55', '2025-03-21 03:59:55', '2025-03-21 03:59:55', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(27, 8, 1300000.00, 'pending', '2025-03-21 04:17:09', '2025-03-21 04:17:09', '2025-03-21 04:17:09', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(28, 8, 6300000.00, 'processing', '2025-03-21 04:17:53', '2025-03-21 04:17:53', '2025-03-21 04:17:53', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612'),
(29, 8, 7500000.00, 'pending', '2025-03-21 04:25:57', '2025-03-21 04:25:57', '2025-03-21 04:25:57', 'Dương Bình', 'Thanh Hà, Thanh Chương, Nghê An', '0345591612');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(14, 12, 36, 2, 4650000.00),
(15, 13, 34, 1, 1300000.00),
(16, 14, 9, 1, 3700000.00),
(17, 15, 29, 1, 1200000.00),
(18, 16, 34, 1, 1300000.00),
(19, 17, 36, 1, 4650000.00),
(20, 18, 36, 1, 4650000.00),
(21, 19, 35, 1, 6300000.00),
(22, 20, 35, 1, 6300000.00),
(23, 21, 32, 1, 7500000.00),
(24, 22, 32, 1, 7500000.00),
(25, 23, 32, 1, 7500000.00),
(26, 24, 6, 1, 10900000.00),
(27, 25, 23, 1, 9300000.00),
(28, 26, 6, 1, 10900000.00),
(29, 27, 34, 1, 1300000.00),
(30, 28, 35, 1, 6300000.00),
(31, 29, 32, 1, 7500000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` enum('cash','vnpay') NOT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `payment_status`, `transaction_id`, `payment_date`) VALUES
(14, 12, 'cash', 'paid', 'txn_67d8727f65fdd', '2025-03-17 12:05:35'),
(15, 13, 'vnpay', 'pending', 'txn_67d8730325e52', '2025-03-17 12:07:47'),
(16, 14, 'cash', 'paid', 'txn_67d873bee038d', '2025-03-17 12:10:54'),
(17, 15, 'vnpay', 'pending', 'txn_67d874182ae92', '2025-03-17 12:12:24'),
(18, 16, 'cash', 'paid', 'txn_67d87497ce67c', '2025-03-17 12:14:31'),
(19, 17, 'vnpay', 'pending', 'txn_67da0cce568be', '2025-03-18 17:16:14'),
(20, 18, 'vnpay', 'pending', 'txn_67da0ccf74b5d', '2025-03-18 17:16:15'),
(21, 19, 'vnpay', 'pending', 'txn_67da0d86b98fe', '2025-03-18 17:19:18'),
(22, 20, 'vnpay', 'pending', 'txn_67da0d8782cc2', '2025-03-18 17:19:19'),
(23, 21, 'vnpay', 'pending', 'txn_67dcb8cadd202', '2025-03-20 17:54:34'),
(24, 22, 'vnpay', 'pending', 'txn_67dcb8cc3dc5a', '2025-03-20 17:54:36'),
(25, 23, 'vnpay', 'pending', 'txn_67dcb8cce2214', '2025-03-20 17:54:36'),
(26, 24, 'vnpay', 'pending', 'txn_67dcb8ea57952', '2025-03-20 17:55:06'),
(27, 25, 'vnpay', 'pending', 'txn_67dcba85ac7f7', '2025-03-20 18:01:57'),
(28, 26, 'vnpay', 'pending', 'txn_67dce43b9738c', '2025-03-20 20:59:55'),
(29, 27, 'vnpay', 'pending', 'txn_67dce845eaed3', '2025-03-20 21:17:09'),
(30, 28, 'cash', 'paid', 'txn_67dce87170ad9', '2025-03-20 21:17:53'),
(31, 29, 'vnpay', 'pending', 'txn_67dcea5564a44', '2025-03-20 21:25:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` decimal(15,0) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `stock`, `description`, `image`, `created_at`) VALUES
(1, 'Google Tivi TCL QLED 4K 75 Inch 75C655', 6, 14900000, 3, 'Google Tivi TCL QLED 4K 75 Inch 75C655 là dòng tivi cao cấp của TCL, mang đến chất lượng hình ảnh vượt trội với độ phân giải 4K, công nghệ màn hình QLED và Dolby Vision. Tivi sử dụng bộ xử lý AiPQ Pro thông minh, giúp tối ưu hình ảnh và âm thanh theo thời gian thực. Hệ điều hành Google TV cung cấp kho nội dung phong phú, dễ dàng điều khiển bằng giọng nói tiếng Việt. Với hàng loạt tiện ích hiện đại như Multi View, Hands-Free Voice Control, chế độ Game Master, sản phẩm hứa hẹn mang đến trải nghiệm giải trí tuyệt vời ngay tại nhà. Chi tiết sản phẩm có tại Tổng Kho Điện Máy Đỏ Hà Nội.', '[\"uploads/images/imgProduct/1741024610_a339a2c1b222ec2d6ea5.png\"]', '2025-03-03 17:56:50'),
(2, 'Google TV QD-Mini LED TCL 4K 75 inch 75C755', 6, 20900000, 3, 'Google TV QD-Mini LED TCL 4K 75 inch 75C755 là dòng tivi cao cấp sở hữu công nghệ màn hình Mini LED kết hợp với Quantum Dot, mang đến độ sáng ấn tượng, màu sắc rực rỡ và độ tương phản chân thực. Bộ xử lý AiPQ Pro nâng cấp chất lượng hình ảnh, giúp từng khung hình hiển thị sắc nét và sống động. Công nghệ âm thanh Dolby Atmosvà hệ thống loa Onkyo Hi-Fi mang lại trải nghiệm âm thanh vòm mạnh mẽ, sống động. Hệ điều hành Google TV trực quan, hỗ trợ kho ứng dụng đa dạng, điều khiển bằng giọng nói và tìm kiếm nội dung dễ dàng. Chi tiết sản phẩm tại Tổng Kho Điện Máy Đỏ Hà Nội.', '[\"uploads/images/imgProduct/1741024691_a523b164a2b0977430f7.png\"]', '2025-03-03 17:58:11'),
(3, 'Tủ lạnh Samsung Inverter 636 lít Bespoke RF65DB990012SV', 7, 79000000, 2, 'Tủ lạnh Samsung Family Hub 4 cánh 636 lít RF65DB990012SV là sản phẩm cao cấp, tích hợp nhiều công nghệ hiện đại, mang đến sự tiện nghi tối ưu cho gia đình bạn. Thiết kế 4 cánh sang trọng, mặt kính Bespoke màu trắng thạch anh tinh tế phù hợp với mọi không gian bếp.Công nghệ làm lạnh với 3 dàn lạnh độc lập giúp thực phẩm tươi ngon lâu hơn, ngăn FlexZone bảo quản thực phẩm với 5 chế độ chuyển đổi linh hoạt. Đặc biệt, màn hình Family Hub thông minh hỗ trợ quản lý thực phẩm, giải trí và kết nối với các thiết bị khác, nâng tầm trải nghiệm sống.', '[\"uploads/images/imgProduct/1741030790_cc5261aa69c25e50e985.png\"]', '2025-03-03 19:39:50'),
(4, 'Máy giặt sấy Panasonic Inverter 10/6 kg NA-S106FR1BV', 8, 14500000, 5, 'Máy giặt sấy Panasonic Inverter 10/6 kg NA-S106FR1BV là sản phẩm kết hợp giữa giặt và sấy, giúp tiết kiệm không gian và thời gian giặt giũ. Máy được trang bị nhiều công nghệ hiện đại như Blue Ag+, Hybrid Dry, AI Smart Wash, 3D Inverter, giúp giặt sạch tối ưu, diệt khuẩn hiệu quả và tiết kiệm năng lượng. Với khối lượng giặt 10kg và khối lượng sấy 6kg, máy phù hợp với gia đình 5 - 7 người. Khám phá ngay chi tiết sản phẩm tại Tổng Kho Điện Máy Đỏ Hà Nội.', '[\"uploads/images/imgProduct/1741030865_5ad02127840e24e4d354.png\"]', '2025-03-03 19:41:05'),
(5, 'Máy giặt Samsung Inverter 11 kg WW11CGP44DSHSV', 8, 8100000, 1, 'Máy giặt Samsung Inverter 11 kg WW11CGP44DSHSV là dòng sản phẩm cao cấp, tích hợp nhiều công nghệ hiện đại giúp giặt sạch hiệu quả và tiết kiệm điện nước. Với khối lượng giặt 11 kg cùng công nghệ AI EcoBubble+ tạo bong bóng siêu mịn, AI Wash tối ưu chu trình giặt, Hygiene Steam diệt khuẩn hiệu quả, Digital Inverter giúp máy vận hành êm ái, bền bỉ, tiết kiệm điện năng. SmartThings giúp điều khiển từ xa tiện lợi. Cùng Tổng Kho Điện Máy Đỏ Hà Nội chi tiết sản phẩm dưới đây.', '[\"uploads/images/imgProduct/1741095409_af2d435b994e25b1845f.png\"]', '2025-03-04 13:36:49'),
(6, 'Máy giặt Aqua Inverter 18 kg AQW-DR180UHT PS', 8, 10900000, 3, 'Máy giặt Aqua Inverter 18 kg AQW-DR180UHT PS là dòng máy giặt cửa trên lồng đứng với thiết kế hiện đại, sang trọng và tích hợp công nghệ giặt tiên tiến như DD Inverter tiết kiệm điện, lồng giặt Pillow bảo vệ quần áo, mâm giặt kháng khuẩn ABT, Smart Dosing tự động phân bổ nước giặt và nước xả. Với khối lượng giặt lớn 18 kg, sản phẩm phù hợp cho gia đình trên 7 người. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội tìm hiểu chi tiết về sản phẩm máy giặt Aqua 18 kg này.', '[\"uploads/images/imgProduct/1741095531_3d068d4e4b5a39d00b29.png\"]', '2025-03-04 13:38:51'),
(7, 'Điều hòa Panasonic Inverter 2 chiều 1 HP CU/CS-YZ9AKH-8', 11, 12500000, 6, 'Điều hòa Panasonic Inverter 2 chiều 1 HP CU/CS-YZ9AKH-8 là sự lựa chọn lý tưởng cho các không gian nhỏ dưới 15m² nhờ khả năng làm mát và sưởi ấm hiệu quả. Với công suất làm lạnh 9.040 BTU và công suất sưởi ấm 10.700 BTU, sản phẩm mang đến không gian thoải mái quanh năm. Ngoài ra, công nghệ Inverter và chế độ ECO tích hợp A.I giúp tiết kiệm điện năng tối ưu, trong khi công nghệ Nanoe-G lọc bụi mịn PM 2.5 bảo vệ sức khỏe gia đình bạn. Khám phá chi tiết về chiếc điều hòa Panasonic này cùng Tổng Kho Điện Máy Đỏ Hà Nội trong bài viết dưới đây.', '[\"uploads/images/imgProduct/1741095670_ea5a92d3ac522472d811.png\"]', '2025-03-04 13:41:10'),
(8, 'Điều hòa Gree Inverter 2 chiều 1.5 HP CHARM12HI', 11, 10500000, 3, 'Điều hòa 2 chiều Gree Inverter 1,5HP CHARM12HI được thương hiệu Gree ra mắt thị trường Việt Nam vào năm 20223. CHARM12HI được trang bị các công nghệ bảo vệ độ bền và duy trì hiệu năng như bảo vệ máy nén, chức năng tự làm sạch, lớp bảo vệ phủ Golden Fin,... Tất cả chi tiết được kỹ sư Gree thiết kế và sản xuất hoàn thiện, đảm bảo máy vận hành êm ái, bền bỉ theo thời gian đem đến những trải nghiệm thoải mái và tiện lợi nhất cho người dùng.', '[\"uploads/images/imgProduct/1741095771_7394cc2c997a49b8bb1e.png\"]', '2025-03-04 13:42:51'),
(9, 'Máy lọc nước RO Hòa Phát HPU488 11 lõi', 12, 3700000, 0, 'Máy lọc nước RO Hòa Phát HPU488 11 lõi là một sản phẩm chất lượng cao đến từ thương hiệu Việt Nam, được thiết kế với công nghệ thẩm thấu ngược RO tiên tiến kết hợp hệ thống 11 lõi lọc và tính năng kháng khuẩn Nano Silver, mang lại nguồn nước tinh khiết và an toàn cho sức khỏe gia đình. Với công suất lọc lớn, tiết kiệm điện năng và nhiều tiện ích thông minh như giàu Hydrogen chống oxy hóa và trung hòa độ pH, sản phẩm này đáp ứng tốt mọi nhu cầu sử dụng nước sạch. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội tìm hiểu chi tiết về Máy lọc nước RO Hòa Phát HPU488 11 lõi trong bài viết dưới đây!', '[\"uploads/images/imgProduct/1741095915_0540b9f6e211952958d6.png\"]', '2025-03-04 13:45:15'),
(10, 'Điều hòa Panasonic Inverter 2.5 HP CU/CS-XU24ZKH-8', 11, 33500000, 3, 'Điều hòa Panasonic Inverter 2.5 HP CU/CS-XU24ZKH-8 là lựa chọn lý tưởng cho không gian sống hiện đại với khả năng làm lạnh nhanh chóng nhờ công nghệ iAuto-X và P-TECH. Sản phẩm không chỉ giúp làm mát hiệu quả mà còn bảo vệ sức khỏe gia đình bạn với công nghệ lọc không khí Nanoe™ X thế hệ 3 và Nanoe-G. Thiết bị còn nổi bật với khả năng tiết kiệm điện vượt trội nhờ công nghệ Inverter và ECO tích hợp AI. Ngoài ra, điều hòa còn hỗ trợ điều khiển từ xa qua điện thoại, kết nối wifi tiện lợi, mang lại trải nghiệm sử dụng thông minh và tiện nghi. Để tìm hiểu chi tiết hơn về các tính năng nổi bật, hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá trong bài viết dưới đây.', '[\"uploads/images/imgProduct/1741103506_e87d39164f04767926df.png\"]', '2025-03-04 15:51:46'),
(11, 'Điều hòa Panasonic Inverter 2 chiều 1.5 HP CU/CS-YZ12AKH-8', 11, 15500000, 9, 'Điều hòa Panasonic Inverter 2 chiều 1.5 HP CU/CS-YZ12AKH-8 là sự lựa chọn lý tưởng cho những không gian từ 15 - 20m² nhờ khả năng làm mát và sưởi ấm hiệu quả. Với công suất làm lạnh 12.000 BTU và công suất sưởi ấm 13.100 BTU, sản phẩm mang đến không gian thoải mái quanh năm. Bên cạnh đó, công nghệ Inverter và chế độ ECO tích hợp A.I giúp tiết kiệm điện năng tối ưu, trong khi công nghệ Nanoe-G lọc bụi mịn PM 2.5 bảo vệ sức khỏe gia đình bạn. Cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết về chiếc điều hòa Panasonic này trong bài viết dưới đây.', '[\"uploads/images/imgProduct/1741103553_e90614ae73ff60a6e561.png\"]', '2025-03-04 15:52:33'),
(12, 'Điều hòa Casper Inverter 2.5 HP GC-24IS35', 11, 13900000, 3, '', '[\"uploads/images/imgProduct/1741103619_d0d8ae2e4acff9c6208f.png\"]', '2025-03-04 15:53:39'),
(13, 'Điều hòa Samsung Wind-Free Inverter 1 HP AR10CYFAAWKNSV', 11, 8300000, 3, '', '[\"uploads/images/imgProduct/1741104481_84de17d6650b7289da67.png\"]', '2025-03-04 16:08:01'),
(14, 'Google TV QD-Mini LED TCL 4K 55 inch 55C755', 6, 12900000, 1, 'Google TV QD-Mini LED TCL 4K 55 inch 55C755 mang đến trải nghiệm giải trí đỉnh cao với màn hình QD-Mini LED 4K UHD, độ phân giải sắc nét cùng công nghệ hình ảnh tiên tiến như Quantum Dot và HDR10+. Với hệ thống âm thanh Dolby Atmos chân thực và hệ điều hành Google TV, sản phẩm không chỉ hiển thị hình ảnh sống động mà còn mang lại âm thanh vang dội, tạo không gian giải trí tuyệt vời. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết các tính năng nổi bật của sản phẩm này qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741105087_ce6d1a6f3164ee658b11.png\"]', '2025-03-04 16:18:07'),
(15, 'Smart Tivi OLED LG 4K 55 inch 55B4PSA', 6, 19500000, 10, 'Smart Tivi OLED LG 4K 55 inch 55B4PSA  là sự kết hợp hoàn hảo giữa thiết kế tinh tế, công nghệ màn hình tiên tiến và các tính năng thông minh vượt trội. Sản phẩm nổi bật với màn hình OLED có khả năng tái tạo màu sắc và độ tương phản hoàn hảo, đi kèm với bộ xử lý α8 AI Processor 4K giúp tối ưu hóa hình ảnh và âm thanh. Công nghệ âm thanh Dolby Atmos mang lại trải nghiệm sống động như trong rạp chiếu phim. Với hệ điều hành webOS 24, tivi hỗ trợ kho ứng dụng đa dạng cùng tính năng nhận diện giọng nói thông minh LG Voice Recognition, đáp ứng mọi nhu cầu giải trí của gia đình. Hãy cùng khám phá chi tiết các điểm mạnh của sản phẩm qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741105142_15e705200a0ea7b13872.png\"]', '2025-03-04 16:19:02'),
(16, 'Smart Tivi LG 4K 55 inch 55UT8050PSB', 6, 9900000, 7, 'Smart Tivi LG 4K 55 inch 55UT8050PSB là dòng sản phẩm tivi thông minh hiện đại của LG, mang đến trải nghiệm giải trí đỉnh cao với hình ảnh sắc nét và âm thanh sống động. Sản phẩm được trang bị màn hình LED với độ phân giải 4K Ultra HD, tái hiện từng chi tiết với màu sắc trung thực. Với bộ xử lý α5 AI Processor 4K Gen7, tivi có khả năng tối ưu hóa hình ảnh và âm thanh thông minh. Hệ điều hành webOS 24 đi kèm trợ lý ảo AI ThinQ, cho phép điều khiển dễ dàng bằng giọng nói và quản lý các thiết bị thông minh trong gia đình. Sản phẩm này là lựa chọn hoàn hảo cho gia đình hiện đại với đầy đủ các tính năng tiện ích và công nghệ tiên tiến. Hãy cùng tìm hiểu chi tiết về sản phẩm qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741105203_afb695eb9cb8255148d1.png\"]', '2025-03-04 16:20:03'),
(17, 'Tủ lạnh LG Inverter 461 lít LTB46BLG', 7, 10700000, 2, 'Tủ lạnh LG Inverter 461 lít LTB46BLG là một trong những dòng tủ lạnh cao cấp được trang bị công nghệ làm lạnh đa chiều Multi Air Flow, công nghệ DoorCooling+ làm lạnh từ cánh cửa, công nghệ Linear Cooling duy trì nhiệt độ ổn định, giúp bảo quản thực phẩm tươi ngon lâu hơn. Dung tích 461 lít phù hợp cho gia đình từ 4 - 5 thành viên. Sản phẩm sở hữu thiết kế mặt gương sang trọng, công nghệ Inverter tiết kiệm điện, đi kèm với nhiều tiện ích thông minh như ngăn đông mềm Fresh 0 Zone không cần rã đông, hệ thống khử mùi than hoạt tính, chẩn đoán lỗi thông minh Smart Diagnosis. Xem ngay bài viết chi tiết tại Tổng Kho Điện Máy Đỏ Hà Nội để hiểu rõ hơn về sản phẩm.', '[\"uploads/images/imgProduct/1741105352_7df76e8a71fa8c90293e.png\"]', '2025-03-04 16:22:32'),
(18, 'Tủ lạnh Toshiba Inverter 596 lít GR-RS780WI-PGV(22)-XK', 7, 15100000, 4, 'Tủ lạnh Toshiba Inverter 596 lít GR-RS780WI-PGV(22)-XK là sản phẩm cao cấp, được thiết kế với kiểu dáng Side by Side 2 cánh, phù hợp cho các gia đình có không gian rộng. Với dung tích 596 lít, tủ lạnh đáp ứng nhu cầu bảo quản thực phẩm của gia đình trên 5 người. Sản phẩm nổi bật với công nghệ làm lạnh tấm hợp kim Alloy Cooling, luồng khí lạnh đa chiều Multi Air Flow, cùng nhiều tiện ích hiện đại như ngăn cấp ẩm Max-humid fresh, công nghệ Origin Inverter tiết kiệm điện. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội tìm hiểu chi tiết về sản phẩm này ngay sau đây.', '[\"uploads/images/imgProduct/1741105399_69c2cf73f20f7d9d7976.png\"]', '2025-03-04 16:23:19'),
(20, 'Tủ lạnh Panasonic Inverter 500 lít NR-BW530XMMV', 7, 26900000, 3, 'Tủ lạnh Panasonic Inverter 500 lít NR-BW530XMMV là dòng sản phẩm cao cấp thuộc thế hệ PRIME+ Edition, sở hữu thiết kế ngăn đá dưới tiện lợi, kết hợp mặt gương sáng bóng và gam màu đen sang trọng, tạo điểm nhấn nổi bật cho không gian bếp hiện đại. Với công nghệ nanoe™ X, cấp đông nhanh Prime Freeze, ngăn cấp đông mềm Prime Fresh, công nghệ Inverter tiết kiệm điện và nhiều tiện ích thông minh, sản phẩm mang đến giải pháp lưu trữ thực phẩm lý tưởng cho gia đình từ 4 - 5 người. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết về sản phẩm này ngay sau đây.', '[\"uploads/images/imgProduct/1741105693_2be10e0f3c316a1ac21c.png\"]', '2025-03-04 16:28:13'),
(21, 'Máy rửa bát Samsung Bespoke DW60CB750FAPSV', 10, 17500000, 3, 'Bạn đang tìm kiếm một chiếc máy rửa bát cao cấp với khả năng làm sạch hiệu quả và vận hành êm ái? Máy rửa bát Samsung Bespoke DW60CB750FAPSV chính là sự lựa chọn hoàn hảo dành cho gia đình bạn. Sản phẩm nổi bật với công nghệ rửa xoáy kép WaterJet Clean™, giúp làm sạch sâu từng ngóc ngách chén bát, cùng với tính năng sấy nhiệt dư và tự động hé cửa sau khi rửa, đảm bảo bát đĩa luôn khô ráo và thơm tho. Đặc biệt, máy được tích hợp 11 chương trình rửa đa dạng và khả năng kết nối SmartThings, cho phép điều khiển từ xa tiện lợi thông qua điện thoại thông minh. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết về sản phẩm này ngay dưới đây!', '[\"uploads/images/imgProduct/1741105801_d359d48a34b2e6c94595.png\"]', '2025-03-04 16:30:01'),
(22, 'Máy rửa bát mini Hafele HDW-T5531B', 10, 6500000, 5, 'Máy rửa bát mini Hafele HDW-T5531B là giải pháp hoàn hảo cho các gia đình nhỏ hoặc không gian bếp hạn chế. Với công nghệ rửa tiên tiến kết hợp khả năng sấy khô hiệu quả, sản phẩm mang đến sự tiện lợi vượt trội trong việc làm sạch bát đĩa. Hafele HDW-T5531B không chỉ tiết kiệm thời gian và công sức mà còn đảm bảo vệ sinh với hệ thống cảm biến hiện đại. Được phân phối bởi Tổng Kho Điện Máy Đỏ Hà Nội, máy rửa bát này xứng đáng trở thành trợ thủ đắc lực cho căn bếp của bạn. Hãy cùng khám phá chi tiết sản phẩm qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741105842_c294fa2da8cc5e0aa43f.png\"]', '2025-03-04 16:30:42'),
(23, 'Máy rửa bát Bosch SMS2ITW04E TGB', 10, 9300000, 2, 'Máy rửa bát Bosch SMS2ITW04E TGB  là sự lựa chọn hoàn hảo cho gia đình hiện đại với công nghệ rửa tiên tiến, tính năng sấy khô hiệu quả và loạt tiện ích đa dạng. Sản phẩm không chỉ tiết kiệm thời gian mà còn mang đến sự tiện lợi và an toàn tuyệt đối. Với thiết kế sang trọng, chất liệu cao cấp và công nghệ vượt trội, Máy rửa bát Bosch SMS2ITW04E TGB chắc chắn sẽ là người bạn đồng hành lý tưởng cho không gian bếp của bạn. Cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết sản phẩm qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741105899_dca0d1cef9b53ab50b18.png\"]', '2025-03-04 16:31:39'),
(24, 'Máy rửa bát Bosch SMS2ITI12E', 10, 8500000, 1, 'Máy rửa bát Bosch SMS2ITI12E là lựa chọn hoàn hảo cho những gia đình hiện đại, mang đến sự tiện nghi tối đa với khả năng rửa sạch hiệu quả, tiết kiệm thời gian và công sức. Với công nghệ rửa nước nóng Vario Speed, tính năng sấy nhiệt dư Inherent Heat, cùng khả năng điều khiển từ xa qua ứng dụng Home Connect, sản phẩm này đáp ứng mọi nhu cầu sử dụng. Ngoài ra, Máy rửa bát Bosch SMS2ITI12E còn được tích hợp hàng loạt tiện ích như bảo vệ ly thủy tinh Glass Protection, hệ thống chống rò rỉ nước AquaStop, và chức năng sấy tăng cường Extra Dry. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết sản phẩm ngay sau đây.', '[\"uploads/images/imgProduct/1741105947_3be7d47127bb8bd503fd.png\"]', '2025-03-04 16:32:27'),
(25, 'Máy sấy bơm nhiệt Electrolux 8 kg EDH803Q7WB', 9, 17500000, 4, 'Bạn đang tìm kiếm một chiếc máy sấy quần áo vừa hiệu quả vừa tiết kiệm điện? Máy sấy bơm nhiệt Electrolux 8 kg EDH803Q7WB chính là câu trả lời lý tưởng dành cho bạn. Sở hữu công nghệ sấy DelicateCare, SensiCare, và Reverse Tumbling, máy không chỉ giúp quần áo khô nhanh chóng mà còn giữ nguyên chất lượng vải. Với khối lượng sấy 8 kg và 13 chương trình sấy đa dạng, sản phẩm này phù hợp cho gia đình từ 3 – 5 người. Bên cạnh đó, các tiện ích thông minh như điều khiển từ xa qua ứng dụng Electrolux Life, sấy siêu im lặng Extra Silent và Hygienic Care diệt khuẩn quần áo sẽ nâng tầm trải nghiệm của bạn. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội tìm hiểu chi tiết sản phẩm ngay dưới đây!', '[\"uploads/images/imgProduct/1741106003_ac36ffff964dbf121672.png\"]', '2025-03-04 16:33:23'),
(26, 'Máy sấy bơm nhiệt Samsung 9 kg DV90TA240AX/SV', 9, 12100000, 4, 'Bạn đang tìm kiếm một chiếc máy sấy quần áo tích hợp công nghệ tiên tiến và tiết kiệm năng lượng? Máy sấy bơm nhiệt Samsung 9 kg DV90TA240AX/SV không chỉ sở hữu công nghệ sấy thông minh Optimal Dry, công nghệ Heatpump tiết kiệm 50% điện năng, mà còn cung cấp nhiều tiện ích như sấy nhanh Quick Dry 35 phút, chế độ chống nhăn Wrinkle Prevent, và cửa đảo chiều Reversible Door linh hoạt. Với khối lượng sấy 9 kg, sản phẩm đáp ứng hoàn hảo nhu cầu của gia đình từ 3 - 5 người. Cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết sản phẩm để hiểu rõ hơn về các tính năng nổi bật giúp tối ưu hóa cuộc sống gia đình bạn.', '[\"uploads/images/imgProduct/1741106056_3f08d5aa86bb1dca7fff.png\"]', '2025-03-04 16:34:16'),
(27, 'Bếp từ đôi Mutosi MI-88DI', 12, 3300000, 2, 'Bếp từ đôi Mutosi MI-88DI là dòng sản phẩm nổi bật với tổng công suất 4400W, mỗi vùng nấu đạt 2000W giúp nấu ăn nhanh chóng và hiệu quả hơn bao giờ hết. Sản phẩm được thiết kế hiện đại với mặt kính Ceramic chịu nhiệt cao cấp, khả năng chịu lực tốt và chống trầy xước, mang đến độ bền cao và dễ dàng vệ sinh. Tích hợp nhiều tính năng thông minh như khóa an toàn trẻ em, chế độ hẹn giờ 99 phút, cảnh báo nhiệt dư, và công nghệ Inverter tiết kiệm điện năng vượt trội, sản phẩm này đáp ứng mọi nhu cầu nấu nướng của gia đình bạn. Với thiết kế sang trọng và các tính năng hiện đại, Bếp từ đôi Mutosi MI-88DI là lựa chọn không thể bỏ qua, đi kèm dịch vụ hậu mãi và chính sách bảo hành hấp dẫn từ Tổng Kho Điện Máy Đỏ Hà Nội. Hãy cùng tìm hiểu chi tiết sản phẩm qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741106108_7923acbbd14fe5cc8a41.png\"]', '2025-03-04 16:35:08'),
(28, 'Máy hút mùi âm tủ Hafele HH-S70A', 12, 3500000, 2, 'Máy hút mùi âm tủ Hafele HH-S70A là sản phẩm mang thiết kế hiện đại, nhỏ gọn, tối ưu hóa diện tích, giúp không gian bếp trở nên tinh tế và thoáng đãng. Với công suất hút lên đến 440 m³/giờ, máy có khả năng loại bỏ mùi thức ăn hiệu quả, mang lại bầu không khí sạch sẽ và dễ chịu. Điểm nổi bật của sản phẩm nằm ở công nghệ hút mùi tiên tiến, kết hợp với bộ lọc than hoạt tính, giúp xử lý hiệu quả các mùi khó chịu và dầu mỡ trong không gian bếp. Ngoài ra, máy còn tích hợp nhiều tiện ích thông minh như đèn LED tiết kiệm điện và bảng điều khiển nút gạt cơ dễ sử dụng. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết sản phẩm này qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741106149_167d2a147d387b0bd176.png\"]', '2025-03-04 16:35:49'),
(29, 'Máy hút bụi LG VK8320GHAUQ', 12, 1200000, 3, 'Máy hút bụi LG VK8320GHAUQ là một trong những sản phẩm nổi bật trong dòng máy hút bụi của hãng LG. Với thiết kế hiện đại, công nghệ tiên tiến và nhiều tính năng tiện ích, máy hút bụi này đang được nhiều người tiêu dùng quan tâm và lựa chọn. Trong bài viết này, chúng ta sẽ đi sâu tìm hiểu về sản phẩm này và khám phá những ưu điểm nổi bật của nó.', '[\"uploads/images/imgProduct/1741106194_6e43cbb131c96e2455a6.png\"]', '2025-03-04 16:36:34'),
(30, 'Máy giặt sấy Samsung Heatpump 25/15 kg WD25DB8995BZSV', 8, 56900000, 3, 'Máy giặt sấy Samsung Heatpump 25/15 kg WD25DB8995BZSV là sản phẩm cao cấp, kết hợp tính năng giặt và sấy trong một, mang lại sự tiện lợi vượt trội. Với công nghệ AI Wash & Dry thông minh, khả năng giặt sấy tối ưu, máy đáp ứng tốt nhu cầu của các gia đình lớn trên 7 thành viên. Các công nghệ tiên tiến như Eco Bubble tạo bong bóng siêu mịn, AI Heatpump sấy bơm nhiệt bảo vệ sợi vải, và tính năng điều khiển thông minh qua ứng dụng SmartThings giúp việc giặt giũ trở nên dễ dàng hơn bao giờ hết. Hãy cùng khám phá chi tiết sản phẩm tại Tổng Kho Điện Máy Đỏ Hà Nội.', '[\"uploads/images/imgProduct/1741106363_9d5aabfb9be3c7a7f5a9.png\"]', '2025-03-04 16:39:23'),
(31, 'Máy giặt Electrolux UltimateCare 900 Inverter 11 kg EWF1141R9SB', 8, 14500000, 1, 'Máy giặt Electrolux UltimateCare 900 Inverter 11 kg EWF1141R9SB  là một sản phẩm vượt trội, đáp ứng hoàn hảo nhu cầu giặt giũ của gia đình đông thành viên. Với công nghệ tiên tiến như cảm biến khối lượng Load Sensor, giặt hơi nước Hygienic Care, và UltraMix hòa tan nước giặt hiệu quả, máy giặt này không chỉ làm sạch mà còn bảo vệ sợi vải và tiết kiệm năng lượng tối ưu. Bên cạnh đó, thiết kế hiện đại cùng khả năng điều khiển từ xa qua ứng dụng Electrolux mang lại sự tiện lợi tối đa cho người dùng. Hãy cùng khám phá chi tiết sản phẩm này tại Tổng Kho Điện Máy Đỏ Hà Nội qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741106404_64ca5daa744ecd4300d1.png\"]', '2025-03-04 16:40:04'),
(32, 'Máy rửa bát độc lập Hafele HDW-F60E', 10, 7500000, 5, 'Máy rửa bát độc lập Hafele HDW-F60E là sản phẩm được thiết kế dành riêng cho các gia đình hiện đại, mang đến sự tiện nghi và hiệu quả vượt trội trong việc làm sạch bát đĩa. Với khả năng rửa sạch bằng nước nóng và tính năng sấy tăng cường Extra Dry, sản phẩm không chỉ đảm bảo vệ sinh tối đa mà còn giúp bát đĩa luôn khô ráo và sẵn sàng sử dụng. Máy còn tích hợp nhiều chương trình rửa đa dạng như rửa nhanh, rửa tiết kiệm, rửa ngâm, và chương trình đặc biệt dành cho đồ thủy tinh. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội tìm hiểu chi tiết về dòng sản phẩm chất lượng này ngay dưới đây.', '[\"uploads/images/imgProduct/1741106467_73bada26350c05106c62.png\"]', '2025-03-04 16:41:07'),
(33, 'Tủ lạnh Hitachi Inverter 406 lít R-FVX510PGV9 MIR', 7, 12500000, 3, 'Tủ lạnh Hitachi Inverter 406 lít R-FVX510PGV9 MIR sở hữu thiết kế mặt kính hiện đại, tích hợp hệ thống làm lạnh quạt kép và công nghệ Inverter, giúp bảo quản thực phẩm hiệu quả và tiết kiệm điện năng. Với ngăn chuyển đổi đa năng Selectable Zone, bạn có thể tùy chỉnh nhiệt độ linh hoạt theo nhu cầu. Ngoài ra, sản phẩm còn được trang bị ngăn rau quả giữ ẩm và bộ lọc khử mùi Triple Power, giúp bảo quản thực phẩm tươi ngon lâu hơn. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết sản phẩm ngay dưới đây.', '[\"uploads/images/imgProduct/1741106532_9791277b640bdd61caa9.png\"]', '2025-03-04 16:42:12'),
(34, 'Lò vi sóng LG MS2032GIK 20 lít', 12, 1300000, 0, 'Lò vi sóng LG MS2032GIK 20 lít là sản phẩm hiện đại, giúp việc nấu nướng trở nên nhanh chóng và tiện lợi hơn. Với thiết kế tinh tế, công nghệ EasyClean™ vượt trội, cùng các chức năng hâm nóng, rã đông, nấu, sản phẩm đáp ứng mọi nhu cầu nấu ăn của gia đình. Hãy cùng Tổng Kho Điện Máy Đỏ Hà Nội khám phá chi tiết các tính năng nổi bật của sản phẩm qua bài viết dưới đây.', '[\"uploads/images/imgProduct/1741106586_5060dfef8f19f53dc01d.png\"]', '2025-03-04 16:43:06'),
(35, 'Điều hòa Funiki Inverter 1.5 HP HIC12TMU.ST3', 11, 6300000, 4, 'Máy lạnh Funiki Inverter 1.5 HP HIC12TMU.ST3 mang thiết kế sang trọng với gam màu trắng tinh tế kết hợp cùng màn hình hiển thị nhiệt độ trên dàn lạnh, dễ dàng lắp đặt phù hợp với mọi không gian nội thất trong nhà từ phòng khách đến nhà bếp hay phòng ngủ. Máy lạnh Funiki còn được trang bị các tính năng đặc biệt nhằm đảm bảo hiệu suất tối đa nhưng vẫn giữ được sự bền bỉ, tiết kiệm hơn, hiệu quả hơn.', '[\"uploads/images/imgProduct/1741627517_1c321b4b47f71545c053.png\"]', '2025-03-10 17:25:17'),
(36, 'Điều hòa Casper Inverter 1 HP TC-09IS35', 11, 4650000, 3, 'Điều hòa Casper 1 chiều Inverter 9000BTU TC-09IS35 sở hữu hàng loạt công nghệ tiên tiến như Inverter, I-Saving, iClean,... cùng các tính năng hiện đại như cảm biến nhiệt độ I Feel,... Đây là lựa chọn được nhiều người dùng quan tâm khi tìm kiếm sản phẩm chất lượng cho gia đình. Hãy theo dõi bài viết dưới đây để khám phá thêm về sản phẩm này!', '[\"uploads/images/imgProduct/1741627676_3af35826f4ca88450bf1.png\"]', '2025-03-10 17:27:56'),
(37, 'Điều hòa LG Inverter 1 HP V10APFUV', 11, 9300000, 3, '', '[\"uploads/images/imgProduct/1741627781_ff404c3b47a5bd601df6.png\"]', '2025-03-10 17:29:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warranty` varchar(50) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `dimensions` varchar(100) DEFAULT NULL,
  `additional_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `warranty`, `brand`, `origin`, `weight`, `dimensions`, `additional_info`) VALUES
(1, 1, '2 năm', 'TCL', 'Việt Nam', 23.40, 'Ngang 166.6 cm - Cao 103.5 cm - Dày 34.3 cm', ' Độ phân giải: 4K (Ultra HD)\n Công nghệ hình ảnh: QLED, Dolby Vision, HDR10+, AiPQ Engine, HLG, 120Hz MEMC, Local Dimming, chế độ Game Master\nCông nghệ âm thanh: Dolby Atmos, DTS-HD, DTS Virtual:X, hệ thống loa ONKYO Hi-Fi\nKích thước màn hình: 75 inch'),
(2, 2, '2 năm', 'TCL', 'Việt Nam', 30.40, 'Ngang 166.7 cm - Cao 95.22 cm - Dày 7.2 cm', 'Độ phân giải: 4K (Ultra HD)\nCông nghệ hình ảnh: Mini LED, Quantum Dot, AiPQ Pro, HDR10+, Dolby Vision IQ, Full Array Local Dimming, VRR 144Hz, FreeSync Premium Pro, Ai-Contrast, Ai-Color, Ai-MEMC, Ai-Clarity, Ai-HDR, IMAX Enhanced\nCông nghệ âm thanh: Dolby Atmos, DTS-HD, DTS Virtual:X, hệ thống loa Onkyo Hi-Fi\n'),
(3, 3, '2 năm', 'Samsung', 'Hàn Quốc', 159.00, 'Cao 185.3 cm - Ngang 91.2 cm - Sâu 73.1 cm', '• Tổng dung tích sử dụng: 636 lít\n• Dung tích ngăn lạnh: 386 lít\n• Dung tích ngăn đá: 250 lít\n• Kiểu tủ: Multi Door - 4 cánh\n• Chất liệu bên ngoài: Mặt gương soi (Kính Bespoke)\n• Mức tiêu thụ điện: 729 kWh/năm'),
(4, 4, '2 năm', 'Panasonic', 'Việt Nam', 69.00, 'Cao 84.5 cm - Ngang 59.6 cm - Sâu 64.6 cm', '• Khối lượng giặt: 10 kg\n• Khối lượng sấy: 6 kg\n• Kiểu máy giặt: Cửa trước (lồng ngang)\n• Kiểu động cơ: Truyền động gián tiếp (dây curoa)\n• Tốc độ quay vắt: 1400 vòng/phút\n• Công suất tiêu thụ: Hiệu suất sử dụng điện: 11.9 Wh/kg '),
(5, 6, '2 năm', 'Aqua', 'Trung Quốc', 36.00, 'Cao 108.5 cm - Ngang 62.5 cm - Sâu 64 cm', '• Khối lượng giặt: 18 kg\n• Kiểu máy giặt: Cửa trên (lồng đứng)\n• Kiểu động cơ: Truyền động trực tiếp - Inverter\n• Tốc độ quay vắt: 800 vòng/phút\n• Công suất tiêu thụ: Khoảng 1800W (tùy chế độ giặt)'),
(6, 5, '2 năm', 'Samsung', 'Việt Nam', 73.00, 'Cao 85 cm - Ngang 60 cm - Sâu 60 cm', '• Khối lượng giặt: 11 kg\n• Kiểu máy giặt: Cửa trước (lồng ngang)\n• Kiểu động cơ: Truyền động gián tiếp (dây Curoa)\n• Tốc độ quay vắt: 1400 vòng/phút\n• Công suất tiêu thụ: Hiệu suất sử dụng điện: 15.1 Wh/kg'),
(7, 7, '2 năm', 'Panasonic', 'Malaysia', 8.00, 'Dài 76.5 cm - Cao 29 cm - Dày 21.4 cm', '• Công suất làm lạnh: 1 HP (9.040 BTU)\n• Phạm vi làm lạnh hiệu quả: Dưới 15 m²\n• Loại điều hòa: 2 chiều (làm lạnh và sưởi ấm)\n• Công nghệ lọc khí:\n• nanoe-G: Loại bỏ hiệu quả 99% các hạt bụi mịn như PM2.5, mang lại không gian trong lành.\n• Công nghệ Inverter:\n• Inverter: Tiết kiệm điện năng, vận hành êm ái và duy trì nhiệt độ ổn định.\n• Chế độ ECO tích hợp AI: Tự động điều chỉnh công suất làm lạnh dựa trên điều kiện phòng, tiết kiệm điện năng hiệu quả.'),
(8, 8, '2 năm', 'Gree', 'Trung Quốc', 8.00, 'Dài 78.3 cm - Cao 26 cm - Dày 18.5 cm', '• Công suất làm lạnh: 1.5 HP (13.648 BTU)\n• Phạm vi làm lạnh hiệu quả: Từ 15 - 20 m²\n• Loại điều hòa: 2 chiều (làm lạnh và sưởi ấm)• Công nghệ lọc khí: Màng lọc mật độ cao kèm lưới lọc đa chức năng, loại bỏ bụi bẩn, vi khuẩn và nấm mốc, mang lại không gian trong lành.\n• Công nghệ Inverter: Real Inverter giúp tiết kiệm điện năng lên đến 60% so với điều hòa thông thường, hoạt động bền bỉ và kiểm soát nhiệt độ chính xác.'),
(9, 9, '2 năm', 'Hòa Phát', 'Việt Nam', 11.00, 'Ngang 16 cm - Cao 37 cm - Sâu 44.5 cm ', '• Loại máy lọc nước: Máy lọc nước RO để gầm hoặc để bàn\n• Công nghệ lọc nước: Công nghệ thẩm thấu ngược RO với màng lọc RO 75 GPD nhập khẩu Hàn Quốc, kết hợp với 11 lõi lọc, bao gồm 4 lõi lọc thô đúc liền và 6 lõi chức năng bổ sung khoáng chất và tăng cường sức khỏe\n• Công suất lọc nước: 15 lít/giờ\n• Dung tích bình chứa: 6,5 lít\n• Số lõi lọc: 11 lõi\n• Tỷ lệ lọc - thải: Hiệu suất lọc đạt 50-55%\n• Công suất tiêu thụ điện: 35W'),
(10, 10, '2 năm', 'Panasonic', 'Malaysia', 12.00, 'Dài 103 cm - Cao 29.5 cm - Dày 24.4 cm', '• Công suất làm lạnh: 2.5 HP (20.800 BTU)\n• Phạm vi làm lạnh hiệu quả: 30 - 40 m²\n• Loại điều hòa: 1 chiều (chỉ làm lạnh)\n• Công nghệ lọc khí:\n\n• nanoe™ X thế hệ III: Ức chế hiệu quả vi khuẩn, vi rút, nấm mốc và các chất gây dị ứng, đồng thời khử mùi nhanh chóng.\n• nanoe-G: Loại bỏ bụi mịn PM2.5, mang lại không khí trong lành.\n\n• Công nghệ Inverter:\n\n• Inverter: Tiết kiệm điện năng, vận hành êm ái và duy trì nhiệt độ ổn định.\n\n• Chế độ ECO tích hợp AI: Tự động điều chỉnh công suất làm lạnh dựa trên điều kiện phòng, tối ưu hóa hiệu quả năng lượng.'),
(11, 11, '2 năm', 'Panasonic', 'Malaysia', 8.00, 'Dài 76.5 cm - Cao 29 cm - Dày 21.4 cm', '• Công suất làm lạnh: 1.5 HP (11.900 BTU)\n Phạm vi làm lạnh hiệu quả: Từ 15 đến 20 m²\n\n• Loại điều hòa: 2 chiều (làm lạnh và sưởi ấm)\n\n• Công nghệ lọc khí:\n\n• nanoe-G: Loại bỏ hiệu quả các hạt bụi mịn như PM2.5, mang lại không gian trong lành.\n\n• Công nghệ Inverter:\n\n• Inverter: Tiết kiệm điện năng, vận hành êm ái và duy trì nhiệt độ ổn định.\n\n• Chế độ ECO tích hợp AI: Tự động điều chỉnh công suất làm lạnh dựa trên điều kiện phòng, tiết kiệm điện năng hiệu quả.\n\n• Công nghệ làm lạnh:\n\n• Chế độ Powerful: Làm mát căn phòng nhanh chóng, mang lại cảm giác mát lạnh tức thì.'),
(12, 12, '3 năm', 'Casper', 'Thái Lan', 14.00, 'Dài 109.1 cm - Cao 32.8 cm - Dày 23.7 cm', '• Công suất làm lạnh: 2.5 HP (21.500 BTU)\n\n• Phạm vi làm lạnh hiệu quả: Từ 30 m² đến 40 m²\n\n• Loại điều hòa: 1 chiều (chỉ làm lạnh)\n\n• Công nghệ lọc khí: Lưới lọc bụi tiêu chuẩn\n\n• Công nghệ Inverter: Có, với công nghệ i-Saving giúp tiết kiệm điện năng\n\n• Công nghệ làm lạnh: Chế độ Turbo làm lạnh nhanh trong 30 giây\n\n• Tiện ích khác:\n\n• Cảm biến nhiệt độ thông minh iFeel\n\n• Chức năng tự làm sạch iClean\n\n• Dàn tản nhiệt đồng mạ vàng tăng độ bền\n\n• Sử dụng môi chất lạnh R32 thân thiện với môi trường'),
(13, 13, '3 năm', 'Samsung', 'Thái Lan', 8.00, 'Dài 68.2 cm - Cao 29.9 cm - Dày 21.5 cm', '• Công suất làm lạnh: 1 HP (9.000 BTU)\n\n• Phạm vi làm lạnh hiệu quả: Dưới 15 m²\n\n• Loại điều hòa: 1 chiều (chỉ làm lạnh)\n\n• Công nghệ lọc khí: Bộ lọc Copper Anti-bacteria Filter giúp lọc sạch bụi bẩn và vi khuẩn trong không khí\n\n• Công nghệ Inverter: Digital Inverter Boost giúp tiết kiệm điện năng lên đến 73% so với máy lạnh thông thường\n\n• Công nghệ làm lạnh:\n\n• Wind-Free Cooling: Phân phối không khí mát lạnh qua 23.000 lỗ nhỏ, tạo cảm giác dễ chịu, không gây gió buốt\n\n• Fast Cooling: Làm lạnh nhanh chóng toàn bộ căn phòng'),
(14, 14, '3 năm', 'TCL', 'Việt Nam', 14.00, 'Ngang 122.4 cm - Cao 77 cm - Dày 30 cm', '• Kích thước màn hình: 55 inch\n\n• Độ phân giải: 4K UHD (Ultra HD)\n\n• Hệ điều hành: Google TV\n\n• Ứng dụng tích hợp sẵn: YouTube, Netflix, FPT Play, VieON, Clip TV, MyTV, nhac.vn, trình duyệt web\n\n• Công nghệ hình ảnh:\n\n• Quantum Dot\n\n• AiPQ Pro\n\n• HDR10+\n\n• Dolby Vision IQ\n\n• Full Array Local Dimming\n\n• VRR 144 Hz\n\n• Ai-Contrast, Ai-Color, Ai-MEMC, Ai-Clarity, Ai-HDR\n\n• Chống xé hình FreeSync Premium Pro\n\n• Tương thích chuẩn IMAX Enhanced'),
(15, 15, '2 năm', 'LG', 'Indonesia', 14.50, 'Ngang 122.8 cm - Cao 77.2 cm - Dày 23.5 cm', '• Kích thước màn hình: 55 inch\n\n• Độ phân giải: 4K Ultra HD (3840 x 2160 pixel)\n\n• Hệ điều hành: WebOS 24\n\n• Ứng dụng tích hợp sẵn: Netflix, YouTube, LG Content Store, Apple TV, Disney+, Amazon Prime Video, Trình duyệt web\n\n• Công nghệ hình ảnh:\n\n• Bộ xử lý α8 AI Processor 4K\n\n• Công nghệ Pixel Dimming\n\n• Hỗ trợ HDR10, HLG, Dolby Vision\n\n• Chế độ Filmmaker Mode\n\n• Tần số quét 120Hz\n\n• Công nghệ âm thanh:\n\n• AI Sound Pro\n\n• Âm thanh vòm ảo 9.1.2\n\n• Hỗ trợ Dolby Atmos\n\n• Công nghệ LG Sound Sync'),
(16, 16, '3 năm', 'LG', 'Indonesia', 14.20, 'Ngang: 123.5 cm - Cao: 77.6 cm - Dày: 23.1 cm', '• Kích thước màn hình: 55 inch.\n\n• Độ phân giải: Ultra HD 4K (3840 x 2160 pixel).\n\n• Hệ điều hành: webOS 24 (đời 2024).\n\n• Ứng dụng tích hợp sẵn: YouTube, Netflix, Amazon Prime Video, Disney+, FPT Play, Zing MP3, MyTV, Clip TV, LG Content Store và nhiều ứng dụng khác.\n\n• Công nghệ hình ảnh:\n\nBộ xử lý α5 AI Processor 4K Gen7 nâng cao chất lượng hình ảnh.\n\nCông nghệ HDR10 Pro giúp tối ưu độ tương phản và chi tiết hình ảnh.\n\nCông nghệ AI Picture Pro điều chỉnh hình ảnh thông minh theo nội dung và ánh sáng môi trường.\n\nChế độ Filmmaker Mode mang lại trải nghiệm hình ảnh chân thực theo ý đồ đạo diễn.\n\n• Công nghệ âm thanh:\n\nCông nghệ AI Sound Pro phân tích nội dung để tái tạo âm thanh sống động.\n\nHỗ trợ Dolby Audio mang lại âm thanh vòm sống động.\n\n• Công suất loa: 20W với hệ thống loa 2.0 kênh.'),
(17, 18, '3 năm', 'Toshiba', 'Trung Quốc', 101.00, 'Cao 177.5 cm - Ngang 91 cm - Sâu 69.5 cm', '• Kiểu tủ: Tủ lạnh Side by Side 2 cửa\n\n• Dung tích sử dụng: 596 lít\n\n• Dung tích ngăn đá: 209 lít\n\n• Dung tích ngăn lạnh: 387 lít\n\n• Chất liệu bề mặt tủ: Mặt kính cường lực cao cấp, chống bám vân tay\n\n• Chất liệu khay đựng bên trong: Kính chịu lực\n\n• Công nghệ làm lạnh của tủ:\n\n• Công nghệ làm lạnh tuần hoàn Airfall Cooling giúp luồng khí lạnh lan tỏa đều, giữ nhiệt độ ổn định\n\n• Công nghệ Inverter tiết kiệm điện năng và vận hành êm ái\n\n• Công nghệ bảo quản của tủ:\n\n• Công nghệ Pure Bio kháng khuẩn và khử mùi bằng tinh thể bạc Ag+\n\n• Ngăn điều chỉnh độ ẩm cho rau củ tươi lâu hơn\n\n• Chế độ làm lạnh nhanh và cấp đông nhanh giữ thực phẩm luôn tươi mới'),
(18, 17, '3 năm', 'LG', 'Indonesia', 77.00, 'Cao 184.5 cm - Ngang 70 cm - Sâu 72.5 cm', '• Tổng dung tích sử dụng: 461 lít\n\n• Dung tích ngăn lạnh: 361 lít\n\n• Dung tích ngăn đá: 100 lít\n\n• Kiểu tủ: Ngăn đá trên\n\n• Số cánh: 2 cánh\n\n• Chất liệu bên ngoài: Kính màu đen\n\n• Màu sắc: Đen\n\n• Chất liệu khay bên trong: Kính cường lực\n\n• Tủ lạnh trang bị Inverter: Có, sử dụng Máy nén biến tần thông minh (BLDC)\n\n• Mức tiêu thụ điện: 400 kWh/năm\n\n• Công nghệ làm lạnh của Tủ:\n\n• LinearCooling™: Giảm dao động nhiệt độ, giữ thực phẩm tươi ngon lên đến 7 ngày\n\n• DoorCooling+™: Hơi lạnh lan tỏa nhanh và đều hơn'),
(19, 20, '2 năm', 'Panasonic', 'Việt Nam', 97.00, 'Cao 173 cm - Ngang 75 cm - Sâu 75 cm', '• Kiểu tủ: Tủ lạnh ngăn đá dưới (Bottom Freezer)\n\n• Dung tích sử dụng: 500 lít\n\n• Dung tích ngăn đá: 150 lít\n\n• Dung tích ngăn lạnh: 350 lít\n\n• Chất liệu bề mặt tủ: Thép không gỉ sơn tĩnh điện, chống bám vân tay\n\n• Chất liệu khay đựng bên trong: Kính chịu lực\n\n• Công nghệ làm lạnh của tủ:\n\n• Công nghệ làm lạnh đa chiều Panorama, lan tỏa hơi lạnh đều khắp các ngăn\n\n• Cảm biến thông minh Econavi tự động điều chỉnh nhiệt độ dựa trên tần suất mở cửa và nhiệt độ môi trường\n\n• Công nghệ bảo quản của tủ:\n\n• Công nghệ cấp đông mềm Prime Fresh+ bảo quản thực phẩm tươi ngon ở -3°C mà không cần rã đông\n\n• Bộ lọc Ag Clean sử dụng tinh thể bạc Ag+ kháng khuẩn và khử mùi mạnh mẽ\n\n• Ngăn rau quả Fresh Safe duy trì độ ẩm lý tưởng để giữ rau củ tươi lâu hơn'),
(20, 22, '4 năm', 'Hafele', 'Trung Quốc', 25.00, 'Cao 59.5 cm - Ngang 55 cm - Sâu 49.5 cm', '• Loại máy: Máy rửa chén mini để bàn\n\n• Số bộ rửa: 8 bộ đồ ăn châu Âu\n\n• Tiêu thụ nước: Khoảng 8 lít mỗi lần rửa\n\n• Công suất: 1380 - 1620W\n\n• Chương trình rửa:\n\n• Rửa mạnh\n\n• Rửa thông thường\n\n• Rửa tiết kiệm (Eco)\n\n• Rửa ly\n\n• Rửa 90 phút\n\n• Rửa nhanh\n\n• Tự động làm sạch máy\n\n• Bảng điều khiển: Nút bấm với màn hình hiển thị'),
(21, 23, '2 năm', 'Bosch', 'Thổ Nhĩ Kỳ', 23.40, 'Cao 84.5 cm - Ngang 60 cm - Sâu 60 cm', '• Loại máy: Máy rửa bát độc lập\n\n• Số bộ rửa: 12 bộ đồ ăn Châu Âu\n\n• Tiêu thụ nước: Khoảng 9.5 lít mỗi lần rửa\n\n• Công suất: 2400W\n\n• Chương trình rửa:\n\n• Rửa tiết kiệm 50°C (Eco)\n\n• Rửa tự động 45-65°C (Auto)\n\n• Rửa chuyên sâu 70°C (Intensive)\n\n• Rửa nhanh 65°C (Express)\n\n• Rửa tráng (Pre Rinse)\n\n• Bảng điều khiển: Nút nhấn với màn hình hiển thị\n\n• Các tiện ích khác:\n\n• Kết nối và điều khiển từ xa qua ứng dụng Home Connect\n\n• Chức năng sấy khô tăng cường (ExtraDry)\n\n• Chức năng SpeedPerfect+ tăng tốc độ rửa\n\n• Hệ thống cảm biến AquaSensor phát hiện mức độ bẩn\n\n• Động cơ EcoSilence Drive vận hành êm ái\n\n• Hệ thống giỏ VarioFlex linh hoạt\n\n• Chức năng hẹn giờ hoạt động trong vòng 1-24 giờ\n\n• Chức năng khóa trẻ em\n\n• Hệ thống AquaStop ngăn ngừa rò rỉ nước'),
(22, 24, '2 năm', 'Bosch', 'Ba Lan', 45.10, 'Cao 84.5 cm - Ngang 60 cm - Sâu 60 cm ', '• Loại máy: Máy rửa bát độc lập\n\n• Số bộ rửa: 12 bộ đồ ăn Châu Âu\n\n• Tiêu thụ nước: Khoảng 10.5 lít mỗi chu trình rửa\n\n• Công suất: 2400W\n\n• Chương trình rửa:\n\n• Rửa tiết kiệm 50°C (Eco)\n\n• Rửa tự động 45-65°C (Auto)\n\n• Rửa chuyên sâu 70°C (Intensive)\n\n• Rửa nhanh 65°C (Express 1h)\n\n• Rửa tráng (Pre Rinse)\n\n• Bảng điều khiển: Nút nhấn với màn hình hiển thị\n\n• Các tiện ích khác:\n\n• Kết nối và điều khiển từ xa qua ứng dụng Home Connect\n\n• Chức năng sấy tăng cường (ExtraDry)\n\n• Chức năng SpeedPerfect+ tăng tốc độ rửa\n\n• Hệ thống giỏ VarioFlex linh hoạt\n\n• Động cơ EcoSilence Drive vận hành êm ái\n\n• Cảm biến AquaSensor điều chỉnh lượng nước dựa trên độ bẩn\n\n• Hẹn giờ hoạt động từ 1-24 giờ\n\n• Chức năng khóa trẻ em\n\n• Hệ thống AquaStop ngăn ngừa rò rỉ nước'),
(23, 25, '3 năm', 'Electrolux', 'Ba Lan/Thái Lan', 48.96, 'Cao 85 cm - Ngang 59.6 cm - Sâu 65 cm', '• Loại máy sấy: Máy sấy bơm nhiệt (Heat Pump)\n\n• Khối lượng sấy: 8 kg\n\n• Động cơ sấy: Động cơ truyền động dây curoa\n\n• Chất liệu lồng sấy: Thép không gỉ\n\n• Công suất tiêu thụ: Khoảng 650 W (tùy chương trình sấy)\n\n• Chương trình sấy: Nhiều chương trình sấy tự động như sấy đồ cotton, sấy đồ tổng hợp, sấy nhanh, sấy nhẹ cho đồ len, chống nhăn, làm mới quần áo,…\n\n• Bảng điều khiển: Nút xoay chọn chương trình kết hợp màn hình hiển thị LED\n\n• Các tiện ích khác:\n\n• Công nghệ cảm biến thông minh Smart Sensor điều chỉnh thời gian sấy tối ưu\n\n• Tính năng giảm nhăn quần áo\n\n• Đảo chiều lồng sấy giúp quần áo khô đều hơn\n\n• Tiết kiệm năng lượng với công nghệ bơm nhiệt Heat Pump\n\n• Chức năng hẹn giờ sấy\n\n• Khóa trẻ em an toàn'),
(24, 26, '3 năm', 'Samsung', 'Trung Quốc', 49.00, 'Cao 85 cm - Ngang 60 cm - Sâu 63.7 cm', '• Loại máy sấy: Bơm nhiệt (Heatpump)\n\n• Khối lượng sấy: 9 kg\n\n• Động cơ sấy: Digital Inverter, truyền động gián tiếp (dây curoa)\n\n• Chất liệu lồng sấy: Thép không gỉ Diamond Drum\n\n• Công suất tiêu thụ: 800W\n\n• Chương trình sấy: 14 chương trình sấy đa dạng (Cotton, Wool, Bedding, Quick Dry 35 phút, Delicates, Outdoor, v.v.)\n\n• Bảng điều khiển: Song ngữ Anh - Việt, nút nhấn, núm xoay, có màn hình hiển thị\n\n• Các tiện ích khác:\n\n• Công nghệ sấy thông minh Optimal Dry\n\n• Sấy nhanh Quick Dry 35 phút\n\n• Chức năng Smart Check chẩn đoán lỗi qua điện thoại\n\n• Bộ lọc xơ vải 2 lớp\n\n• Chế độ chống nhăn Wrinkle Prevent\n\n• Đèn chiếu sáng lồng sấy\n\n• Cửa đảo chiều Reversible Door'),
(25, 28, '4 năm', 'Hafele', 'Thổ Nhĩ Kỳ', 7.60, 'Ngang 69.8 cm - Cao 19.5 cm - Sâu 45.5 cm', '• Loại hút mùi: Máy hút mùi âm tủ\n\n• Công suất hút mùi: 440 m³/h\n\n• Số quạt hút mùi: 1 quạt tuabin đôi\n\n• Hệ thống lọc khử mùi:\n\n• Lưới lọc mỡ bằng hợp kim nhôm nhiều lớp, dễ dàng tháo lắp và vệ sinh\n\n• Chế độ hút và khử mùi tuần hoàn bằng than hoạt tính\n\n• Độ ồn hoạt động: 57 – 69 dB\n\n• Bảng điều khiển: Nút gạt cơ với 3 cấp độ hút\n\n• Các tiện ích khác:\n\n• Đèn LED chiếu sáng 2 x 4W\n\n• Chất liệu bề mặt inox, dễ dàng vệ sinh\n\n• Hệ thống hút xả: tuần hoàn hoặc thông gió\n\n• Phụ kiện đi kèm: than hoạt tính'),
(26, 29, '2 năm', 'LG', 'Indonesia', 12.00, 'Dài 85.7 cm - Cao 30.7 cm - Dày 19 cm', '• Loại hút bụi: Máy hút bụi dạng hộp, cắm dây\n\n• Công suất hút bụi:\n\n• Công suất hoạt động: 1700W\n\n• Công suất hút: 330W\n\n• Hộp chứa bụi:\n\n• Dung tích: 1,5 lít\n\n• Công nghệ nén bụi tự động Kompressor™, cho phép chứa nhiều hơn tới 4 lần trong hộp đựng rác\n\n• Các tiện ích khác:\n\n• Bộ lọc EPA 14 với 8 lớp lọc, giúp thu giữ tới 99,999% các hạt bụi nhỏ đến 0,42 micron\n\n• Điều khiển trên tay cầm, dễ dàng điều chỉnh các cài đặt\n\n• Ống kéo dài có thể điều chỉnh độ dài theo chiều cao ưa thích\n\n• Trang bị 3 đầu hút: đầu hút sàn, đầu hút khe và đầu hút thảm, hỗ trợ làm sạch nhiều khu vực khác nhau\n\n• Dây điện dài 6,13m với bán kính hoạt động 8m, cùng chức năng tự thu gọn dây điện\n\n• Độ ồn hoạt động khoảng 76 dB'),
(27, 30, '3 năm', 'Samsung', 'Hàn Quốc', 144.00, 'Cao 111 cm - Ngang 68.8 cm - Sâu 87.5 cm ', '• Khối lượng giặt: 25 kg\n\n• Khối lượng sấy: 15 kg\n\n• Kiểu máy giặt: Cửa trước (lồng ngang)\n\n• Kiểu động cơ: Truyền động trực tiếp (Direct Drive)\n\n• Tốc độ quay vắt: Tối đa 1.100 vòng/phút\n\n• Công suất tiêu thụ: Thông tin cụ thể chưa được cung cấp\n\n• Chất liệu lồng giặt: Thép không gỉ\n\n• Công nghệ giặt:\n\n• AI Wash & Dry: Sử dụng cảm biến thông minh để nhận diện độ bẩn và chất liệu vải, từ đó tối ưu hóa lượng nước giặt, nước xả và thời gian giặt.\n\n• Eco Bubble: Tạo bong bóng siêu mịn giúp thẩm thấu nhanh vào sợi vải, giặt sạch hiệu quả và bảo vệ chất liệu vải.\n\n• AI Dispenser: Tự động phân bổ lượng nước giặt và nước xả dựa trên độ bẩn và khối lượng quần áo, tiết kiệm chất giặt tẩy.\n\n• Hygiene Steam: Giặt hơi nước diệt khuẩn, loại bỏ 99,9% vi khuẩn và tác nhân gây dị ứng.\n\n• AI Heatpump: Công nghệ sấy bơm nhiệt thông minh, bảo vệ phom dáng quần áo và tiết kiệm năng lượng.\n\n• Các chế độ giặt: 13 chương trình giặt, bao gồm: Đồ cotton, Đồ hỗn hợp, Giặt nhanh 15 phút, Giặt nhẹ, Giặt đồ len, Vệ sinh lồng giặt, Giặt chăn mền, Ngừa dị ứng, Chỉ sấy, Giặt + sấy, và các chương trình khác.\n\n• Bảng điều khiển: Màn hình cảm ứng LCD 7 inch, hỗ trợ song ngữ Anh - Việt, dễ dàng sử dụng.\n\n• Các tiện ích khác:\n\n• Thêm đồ trong khi giặt: Cho phép bổ sung quần áo trong quá trình giặt.\n\n• Khóa trẻ em: Đảm bảo an toàn cho gia đình có trẻ nhỏ.\n\n• Hẹn giờ giặt: Linh hoạt trong việc sắp xếp thời gian giặt.\n\n• Chẩn đoán thông minh Smart Check: Giúp phát hiện và xử lý nhanh chóng các sự cố.'),
(28, 31, '2 năm', 'Electrolux', 'Thái Lan', 80.00, 'Cao 85 cm - Ngang 60 cm - Sâu 65.9 cm', '• Khối lượng giặt: 11 kg\n\n• Kiểu máy giặt: Cửa trước (lồng ngang)\n\n• Kiểu động cơ: Truyền động gián tiếp (dây Curoa) với công nghệ EcoInverter\n\n• Tốc độ quay vắt: 1.400 vòng/phút\n\n• Công suất tiêu thụ: 16,7 Wh/kg\n\n• Chất liệu lồng giặt: Thép không gỉ\n\n• Công nghệ giặt:\n\n• SensorWash với cảm biến AI: Phát hiện độ bẩn và cặn chất giặt trên quần áo, tự động điều chỉnh chu trình giặt để loại bỏ đến 49 loại vết bẩn cứng đầu như dầu ăn, rượu vang đỏ, bùn đất và sôcôla.\n\n• AutoDose: Tự động phân bổ lượng nước giặt và nước xả dựa trên khối lượng và độ bẩn của quần áo, giúp giặt sạch sâu và bảo vệ sợi vải.\n\n• UltraMix: Hòa tan hoàn toàn chất giặt và xả trước khi đưa vào lồng giặt, giúp giặt sạch sâu và không để lại cặn hóa chất trên quần áo.\n\n• HygienicCare: Sử dụng hơi nước ở nhiệt độ 40°C để loại bỏ đến 99,9% vi khuẩn và tác nhân gây dị ứng, bảo vệ sức khỏe gia đình.\n\n• Các chế độ giặt: 15 chương trình giặt, bao gồm: Đồ cotton, Đồ hỗn hợp, Đồ mỏng, Giặt tiết kiệm, Giặt nhanh 15 phút, Giặt nhanh 39 phút, Đồ em bé, Vắt, Vệ sinh lồng giặt, Xả + vắt, Chế độ yêu thích.\n\n• Bảng điều khiển: Song ngữ Anh – Việt, có núm xoay, cảm ứng và màn hình hiển thị\n\n• Các tiện ích khác:\n\n• Thêm quần áo khi đang giặt: Cho phép bổ sung quần áo bỏ sót trong quá trình giặt.\n\n• Vệ sinh lồng giặt: Tự động vệ sinh, loại bỏ vi khuẩn và cặn bẩn bám trên lồng giặt.\n\n• Khóa trẻ em: Đảm bảo an toàn cho gia đình có trẻ nhỏ.\n\n• Hẹn giờ kết thúc giặt: Giúp người dùng dễ dàng cài đặt thời gian giặt theo ý muốn.\n\n• Kết nối Wi-Fi với ứng dụng Electrolux Life: Điều khiển máy giặt từ xa, nhận tư vấn giặt tẩy và lên lịch giặt phù hợp dựa trên dự báo thời tiết.'),
(29, 32, '3 năm', 'Hafele', 'Trung Quốc', 49.50, 'Cao 84.5 cm - Ngang 59.8 cm - Sâu 61 cm ', '• Loại máy: Máy rửa bát độc lập\n\n• Số bộ rửa: 15 bộ đồ ăn Châu Âu\n\n• Tiêu thụ nước: Khoảng 9 lít mỗi lần rửa\n\n• Công suất: 1930W\n\n• Chương trình rửa:\n\n• Rửa tự động\n\n• Rửa mạnh\n\n• Rửa thường\n\n• Rửa tiết kiệm\n\n• Rửa ly tách dễ vỡ\n\n• Rửa 90 phút\n\n• Rửa nhanh\n\n• Rửa ngâm\n\n• Bảng điều khiển: Nút nhấn cơ với màn hình LED hiển thị\n\n• Các tiện ích khác:\n\n• Chức năng rửa nửa tải\n\n• Nút viên tẩy rửa 3 trong 1\n\n• Khay thứ 3 Easy Tray tối ưu không gian\n\n• Chức năng hẹn giờ trễ\n\n• Chức năng báo mức muối và chất tẩy rửa\n\n• Khóa trẻ em'),
(30, 33, '', 'Hitachi', 'Thái Lan', 70.00, 'Cao 176.2 cm - Ngang 68 cm - Sâu 70.8 cm', '• Tổng dung tích sử dụng: 406 lít\n\n• Dung tích ngăn lạnh: 305 lít\n\n• Dung tích ngăn đá: 109 lít\n\n• Kiểu tủ: Ngăn đá trên\n\n• Số cánh: 2 cánh\n\n• Chất liệu bên ngoài: Mặt kính\n\n• Màu sắc: Gương bạc\n\n• Chất liệu khay bên trong: Kính chịu lực\n\n• Tủ lạnh trang bị Inverter: Có\n\n• Mức tiêu thụ điện: 381 kWh/năm\n\n• Công nghệ làm lạnh của Tủ:\n\n• Hệ thống làm lạnh quạt kép\n\n• Công nghệ bảo quản của Tủ:\n\n• Ngăn chuyển đổi đa năng Selectable Zone (có Đông mềm -3°C)\n\n• Ngăn rau quả giữ ẩm\n\n• Bộ lọc khử mùi 3 lớp Triple Power\n\n• Các tiện ích khác:\n\n• Đệm cửa chống mốc\n\n• Hộp đá xoay di động'),
(31, 34, '1 năm', 'LG', 'Trung Quốc', 9.70, 'Rộng 45.4 cm - Cao 26.1 cm - Sâu 32.8 cm', '• Loại lò: Lò vi sóng không nướng\n\n• Công suất sử dụng: Công suất vi sóng 700W\n\n• Dung tích sử dụng: 20 lít\n\n• Chất liệu khoang lò: Thép tráng men chống dính EasyClean™, dễ dàng vệ sinh\n\n• Các chức năng chính:\n\n• Hâm nóng\n\n• Rã đông\n\n• Nấu\n\n• Màu sắc: Màu be\n\n• Tiện ích khác:\n\n• Đèn LED chiếu sáng bên trong khoang lò, sáng hơn gấp 3 lần so với đèn thông thường, giúp dễ dàng quan sát thực phẩm trong quá trình nấu\n\n• Bảng điều khiển cảm ứng với màn hình LED hiển thị rõ ràng\n\n• Chức năng khóa trẻ em, đảm bảo an toàn khi sử dụng\n\n• Công nghệ EasyClean™ giúp vệ sinh khoang lò dễ dàng, loại bỏ 99,99% vi khuẩn và vết bẩn'),
(32, 35, '2 năm', 'Funiki', 'Malaysia', 8.20, 'Dài 79.5 cm - Cao 28.5 cm - Dày 20 cm', '• Công suất làm lạnh: 1.5 HP (12.000 BTU)\n\n• Phạm vi làm lạnh hiệu quả: Từ 15 m² đến 20 m²\n\n• Loại điều hòa: 1 chiều (chỉ làm lạnh)\n\n• Công nghệ lọc khí: Lưới lọc Nano Ag giúp loại bỏ vi khuẩn và bụi bẩn hiệu quả\n\n• Công nghệ Inverter: Có, giúp tiết kiệm điện năng và vận hành êm ái\n\n• Công nghệ làm lạnh: Chế độ Turbo cho phép làm lạnh nhanh chóng\n\n• Tiện ích khác:\n\n• Chức năng tự chẩn đoán lỗi, giúp người dùng dễ dàng nhận biết và khắc phục sự cố\n\n• Chế độ Sleep Mode điều chỉnh nhiệt độ phù hợp vào ban đêm, mang lại giấc ngủ thoải mái\n\n• Tự khởi động lại khi có điện sau khi mất điện đột ngột\n\n• Màn hình hiển thị nhiệt độ trên dàn lạnh, tiện lợi cho việc quan sát\n\n• Chức năng tự làm sạch giúp ngăn ngừa vi khuẩn và nấm mốc phát triển bên trong dàn lạnh'),
(33, 36, '3 năm cho toàn bộ máy, 12 năm cho máy nén ', 'Casper', 'Thái Lan', 7.00, 'Dài 70.8 cm - Cao 28.2 cm - Dày 19.3 cm / Dài 70.3 cm - Cao 45.5 cm - Dày 23.3 cm', '• Công suất làm lạnh: 1 HP (9.000 BTU)\n\n• Phạm vi làm lạnh hiệu quả: Dưới 15 m²\n\n• Loại điều hòa: 1 chiều (chỉ làm lạnh)\n\n• Công nghệ lọc khí: Lưới lọc bụi tiêu chuẩn\n\n• Công nghệ Inverter: Có, với công nghệ i-Saving giúp tiết kiệm điện năng\n\n• Công nghệ làm lạnh: Chế độ Turbo làm lạnh nhanh trong 30 giây\n\n• Tiện ích khác:\n\n• Cảm biến nhiệt độ thông minh iFeel\n\n• Chức năng tự làm sạch iClean\n\n• Dàn tản nhiệt đồng mạ vàng tăng độ bền\n\n• Sử dụng môi chất lạnh R32 thân thiện với môi trường'),
(34, 37, '02 năm cho toàn bộ máy, 10 năm cho máy nén', 'LG', 'Thái Lan', 9.60, 'Dài 85.7 cm - Cao 30.7 cm - Dày 19 cm / Dài 81 cm - Cao 50 cm - Dày 24.5 cm ', '• Công suất làm lạnh: 1 HP (9.200 BTU)\n\n• Phạm vi làm lạnh hiệu quả: Dưới 15 m²\n\n• Loại điều hòa: 1 chiều (chỉ làm lạnh)\n\n• Công nghệ lọc khí:\n\n• Cảm biến bụi PM 1.0\n\n• Công nghệ UVnano diệt khuẩn\n\n• Màng lọc sơ cấp và màng lọc dị ứng\n\n• Tạo ion lọc không khí\n\n• Công nghệ Inverter: Dual Inverter giúp tiết kiệm điện năng và vận hành êm ái\n\n• Công nghệ làm lạnh: Chế độ Jet Cool làm lạnh nhanh\n\n• Tiện ích khác:\n\n• Điều khiển qua điện thoại với kết nối Wi-Fi\n\n• Đảo gió 4 chiều\n\n• Chức năng tự làm sạch\n\n• Chế độ ngủ đêm\n\n• Hẹn giờ bật/tắt\n\n• Tự khởi động lại khi có điện\n\n• Màn hình hiển thị nhiệt độ trên dàn lạnh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `description`, `uploaded_at`) VALUES
(1, 1, 'uploads/images/product_details/1741616334_d70203b4b31eab461f07.png', 'Nghiêng phải', '2025-03-10 14:18:54'),
(2, 1, 'uploads/images/product_details/1741616395_73b8be118ad8cbc4ec3b.png', 'Góc nghiêng trái', '2025-03-10 14:19:55'),
(3, 1, 'uploads/images/product_details/1741616454_0a06c499d590d0bd91f6.png', 'Mặt sau', '2025-03-10 14:20:54'),
(4, 2, 'uploads/images/product_details/1741616885_ecf835459926b920e4d4.png', 'Góc Nghiêng Trái', '2025-03-10 14:28:05'),
(5, 2, 'uploads/images/product_details/1741616909_36a4d82fccfc9cbf5ead.png', 'Góc Nghiêng Phải', '2025-03-10 14:28:29'),
(6, 2, 'uploads/images/product_details/1741616937_297bb3f0bd975c3b3534.png', 'Góc Ngang', '2025-03-10 14:28:57'),
(7, 3, 'uploads/images/product_details/1741617369_9183a898ad106082addf.png', 'Mở cách', '2025-03-10 14:36:09'),
(8, 3, 'uploads/images/product_details/1741617402_02aa0c6e1acb12cac477.png', 'Góc nghiêng', '2025-03-10 14:36:42'),
(9, 3, 'uploads/images/product_details/1741617440_a4b72b4cdc65a588242e.png', 'Mở cách', '2025-03-10 14:37:20'),
(10, 4, 'uploads/images/product_details/1741617645_e621740fc8c2b1e99047.png', 'Mở cách', '2025-03-10 14:40:45'),
(11, 4, 'uploads/images/product_details/1741617675_4ad022b998bd6b01eeea.png', 'Góc nghiêng', '2025-03-10 14:41:15'),
(12, 4, 'uploads/images/product_details/1741617695_3b5cd575e7ddc5a47a7e.png', 'Lồng', '2025-03-10 14:41:35'),
(13, 5, 'uploads/images/product_details/1741618147_bdb1bef9103b37c44868.png', 'Góc nghiêng', '2025-03-10 14:49:07'),
(14, 5, 'uploads/images/product_details/1741618168_338166217f9537e50fc9.png', 'Góc nghiêng', '2025-03-10 14:49:29'),
(15, 5, 'uploads/images/product_details/1741618176_ac91815802223c7139b5.png', 'Mở cách', '2025-03-10 14:49:36'),
(16, 6, 'uploads/images/product_details/1741618532_bdb690d9257dec3cf158.png', 'Mở cửa', '2025-03-10 14:55:32'),
(17, 6, 'uploads/images/product_details/1741618549_5639e4865974e7f1912f.png', 'Góc nghiêng', '2025-03-10 14:55:49'),
(18, 7, 'uploads/images/product_details/1741622330_295593ab4e2dd33f660f.png', 'Mặt trước', '2025-03-10 15:58:50'),
(19, 7, 'uploads/images/product_details/1741622342_6d8843612b38f3830d9f.png', 'Góc nghiêng', '2025-03-10 15:59:02'),
(20, 7, 'uploads/images/product_details/1741622359_2ffbbe740c934e60162c.png', 'Phụ kiện', '2025-03-10 15:59:19'),
(21, 8, 'uploads/images/product_details/1741622517_ab426900b299bda09785.png', 'Mặt trước', '2025-03-10 16:01:57'),
(22, 8, 'uploads/images/product_details/1741622527_4e132f1550866682b724.png', 'Góc nghiêng', '2025-03-10 16:02:08'),
(23, 8, 'uploads/images/product_details/1741622538_256032b5d6e7d7f8ec20.png', 'Góc nghiêng', '2025-03-10 16:02:18'),
(24, 9, 'uploads/images/product_details/1741704791_8f7ed53b91d97a040868.png', 'Góc ngang', '2025-03-11 14:53:11'),
(25, 9, 'uploads/images/product_details/1741704800_0ce0d1879f02a46c5ffc.png', 'Lõi lọc', '2025-03-11 14:53:20'),
(26, 9, 'uploads/images/product_details/1741704809_5e4a435b94ebbeedeaae.png', 'Mặt sau', '2025-03-11 14:53:29'),
(27, 10, 'uploads/images/product_details/1741704957_c4ed44ec12ac00dabbbc.png', 'Góc ngang', '2025-03-11 14:55:57'),
(28, 10, 'uploads/images/product_details/1741704968_744e9de62edb6c509398.png', 'Góc ngang', '2025-03-11 14:56:08'),
(29, 10, 'uploads/images/product_details/1741704978_3d7c9d38c4b265e4fa52.png', 'Cục nóng', '2025-03-11 14:56:18'),
(30, 11, 'uploads/images/product_details/1741717778_5a70cadd066b9c5595f7.png', 'Góc ngang', '2025-03-11 18:29:38'),
(31, 11, 'uploads/images/product_details/1741717787_a2824c5c9229312456da.png', 'Góc ngang', '2025-03-11 18:29:47'),
(32, 11, 'uploads/images/product_details/1741717800_d1ad45d5eeda4950e7db.png', 'Góc ngang', '2025-03-11 18:30:00'),
(33, 12, 'uploads/images/product_details/1741717929_09389f06c06beb20d894.png', 'Góc ngang', '2025-03-11 18:32:09'),
(34, 12, 'uploads/images/product_details/1741717947_83fb7bf2acce9da741e5.png', 'Góc ngang', '2025-03-11 18:32:27'),
(35, 12, 'uploads/images/product_details/1741717957_25ff63dcc609bc7d3b37.png', 'Full bộ', '2025-03-11 18:32:38'),
(36, 13, 'uploads/images/product_details/1741718056_e17bc71b87d8cbd92df7.png', 'Góc ngang', '2025-03-11 18:34:16'),
(37, 13, 'uploads/images/product_details/1741718068_89dea898842a02d8e82d.png', 'Góc ngang', '2025-03-11 18:34:28'),
(38, 13, 'uploads/images/product_details/1741718082_bb445ec87e1a281c4d12.png', 'Góc ngang', '2025-03-11 18:34:42'),
(39, 14, 'uploads/images/product_details/1741718175_8a8681c4ac115b668d21.png', 'Góc ngang', '2025-03-11 18:36:15'),
(40, 14, 'uploads/images/product_details/1741718186_4ad0c95dd03910459700.png', 'Góc ngang', '2025-03-11 18:36:26'),
(41, 14, 'uploads/images/product_details/1741718210_f080472e8920492c4ef3.png', 'Mặt sau', '2025-03-11 18:36:50'),
(42, 15, 'uploads/images/product_details/1741718362_17ec895ea8e4edd02c57.png', 'Góc ngang', '2025-03-11 18:39:22'),
(43, 15, 'uploads/images/product_details/1741718370_f05dcb7614bf65d45b91.png', 'Góc ngang', '2025-03-11 18:39:30'),
(44, 15, 'uploads/images/product_details/1741718378_bebee08c509cf8c3f134.png', 'Mặt sau', '2025-03-11 18:39:38'),
(45, 16, 'uploads/images/product_details/1741718487_4f582675b000e7e3bf1b.png', 'Góc ngang', '2025-03-11 18:41:27'),
(46, 16, 'uploads/images/product_details/1741718498_7dfae004ec2cebe4eb97.png', 'Góc ngang', '2025-03-11 18:41:38'),
(47, 16, 'uploads/images/product_details/1741718516_d360fddd492103b1155f.png', 'Màn hình', '2025-03-11 18:41:56'),
(48, 17, 'uploads/images/product_details/1741937507_9adb8cbfe724a25cafb8.png', 'Mặt trước', '2025-03-14 07:31:47'),
(49, 17, 'uploads/images/product_details/1741937525_b6c5b3c8794a764929f6.png', 'Góc nghiêng', '2025-03-14 07:32:05'),
(50, 17, 'uploads/images/product_details/1741937535_311ecf865438da8d1c5c.png', 'Bên trong', '2025-03-14 07:32:15'),
(51, 18, 'uploads/images/product_details/1741937625_18b13e400d83686d5531.png', 'Mặt trước', '2025-03-14 07:33:45'),
(52, 18, 'uploads/images/product_details/1741937637_6ce2c1338d69deaeeefe.png', 'Góc ngang', '2025-03-14 07:33:57'),
(53, 18, 'uploads/images/product_details/1741937646_7343914497e8d161b104.png', 'Bên trong', '2025-03-14 07:34:06'),
(54, 20, 'uploads/images/product_details/1741959496_f7da1855684575a7156d.png', 'Góc ngang', '2025-03-14 13:38:16'),
(55, 20, 'uploads/images/product_details/1741959504_ed53dce07d06540ef1a5.png', 'Bên trong', '2025-03-14 13:38:24'),
(56, 20, 'uploads/images/product_details/1741959515_a25d3ef80d9f17bc6017.png', 'Bên trong', '2025-03-14 13:38:35'),
(57, 22, 'uploads/images/product_details/1741959611_482c6c46e84f6a0688b0.png', 'Góc ngang', '2025-03-14 13:40:11'),
(58, 22, 'uploads/images/product_details/1741959620_2650b2ef2ffc6a8e09b7.png', 'Ngăn tủ', '2025-03-14 13:40:20'),
(59, 22, 'uploads/images/product_details/1741959629_f744b06e13f0a5000120.png', 'Bên trong', '2025-03-14 13:40:29'),
(60, 23, 'uploads/images/product_details/1741959777_35dd5078a013d7bcea5c.png', 'Góc ngang', '2025-03-14 13:42:57'),
(61, 23, 'uploads/images/product_details/1741959789_b3ddad2a2b2c29d3c1b1.png', 'Góc ngang', '2025-03-14 13:43:09'),
(62, 23, 'uploads/images/product_details/1741959798_ba729a1829afc75f3ccb.png', 'Bên sau', '2025-03-14 13:43:18'),
(63, 24, 'uploads/images/product_details/1741959882_b8025c3d5e17567c9592.png', 'Góc ngang', '2025-03-14 13:44:42'),
(64, 24, 'uploads/images/product_details/1741959898_944289ea12f114b253ad.png', 'Góc ngang', '2025-03-14 13:44:59'),
(65, 24, 'uploads/images/product_details/1741959914_68f49138da6ebd05a275.png', 'Bên trong', '2025-03-14 13:45:14'),
(66, 25, 'uploads/images/product_details/1741960028_2be9f7006e01f5df6c19.png', 'Góc ngang', '2025-03-14 13:47:08'),
(67, 25, 'uploads/images/product_details/1741960040_27c4343392fbbea20074.png', 'Góc ngang', '2025-03-14 13:47:20'),
(68, 25, 'uploads/images/product_details/1741960050_12b772e3c4a93920bf1d.png', 'Bảng điều khiển', '2025-03-14 13:47:30'),
(69, 26, 'uploads/images/product_details/1741960180_465894f0f644e0758ad7.png', 'Mặt trước', '2025-03-14 13:49:40'),
(70, 26, 'uploads/images/product_details/1741960188_f35ed46baf9722cf8940.png', 'Góc ngang', '2025-03-14 13:49:49'),
(71, 26, 'uploads/images/product_details/1741960200_09c7812b5851a789689f.png', 'Bình chứa nước', '2025-03-14 13:50:00'),
(72, 28, 'uploads/images/product_details/1741960376_44935eec2bc700340fb8.png', 'Góc ngang', '2025-03-14 13:52:56'),
(73, 28, 'uploads/images/product_details/1741960384_617f10e792d2efc85d5b.png', 'Góc ngang', '2025-03-14 13:53:04'),
(74, 28, 'uploads/images/product_details/1741960399_5ef59602c766d18669eb.png', 'Mặt trên', '2025-03-14 13:53:19'),
(75, 29, 'uploads/images/product_details/1741960521_ae98c977bf31b7d1be58.png', 'Mặt trước', '2025-03-14 13:55:21'),
(76, 29, 'uploads/images/product_details/1741960544_c3dafcc992163c033ccf.png', 'Máy', '2025-03-14 13:55:44'),
(77, 29, 'uploads/images/product_details/1741960557_ef979abec3914bbab9c9.png', 'Thùng chứa', '2025-03-14 13:55:57'),
(78, 30, 'uploads/images/product_details/1741960707_eb920bebd60259cdd537.png', 'Góc ngang', '2025-03-14 13:58:27'),
(79, 30, 'uploads/images/product_details/1741960713_1759857191ebb4622c90.png', 'Góc ngang', '2025-03-14 13:58:33'),
(80, 30, 'uploads/images/product_details/1741960721_656d4f2c319cb7c7acc1.png', 'Bảng điều khiển', '2025-03-14 13:58:41'),
(81, 31, 'uploads/images/product_details/1741960835_f1c5e4119f480d1f0bde.png', 'Góc ngang', '2025-03-14 14:00:35'),
(82, 31, 'uploads/images/product_details/1741960842_c1b874d27932f672c75c.png', 'Mặt trước', '2025-03-14 14:00:42'),
(83, 31, 'uploads/images/product_details/1741960849_3d3701865aeef43feca6.png', 'Bảng điều khiển', '2025-03-14 14:00:49'),
(84, 32, 'uploads/images/product_details/1741960979_d5f287c7f6647b536498.png', 'Góc ngang', '2025-03-14 14:02:59'),
(85, 32, 'uploads/images/product_details/1741960992_59304a6d34f6e279abe6.png', 'Ngăn tủ', '2025-03-14 14:03:12'),
(86, 32, 'uploads/images/product_details/1741961001_c0099f33a14233c8b9dc.png', 'Bảng điều khiển', '2025-03-14 14:03:21'),
(87, 33, 'uploads/images/product_details/1741961094_46ad14273941c79dd681.png', 'Ngăn tủ', '2025-03-14 14:04:54'),
(88, 33, 'uploads/images/product_details/1741961100_d1b130a4ec7d5a23aacb.png', 'Ngăn tủ', '2025-03-14 14:05:00'),
(89, 34, 'uploads/images/product_details/1741961747_90ef48db6b9078a5f57f.png', 'Bên trong', '2025-03-14 14:15:47'),
(90, 34, 'uploads/images/product_details/1741961760_6239e47ef7dd3ab33ebf.png', 'Góc ngang', '2025-03-14 14:16:00'),
(91, 34, 'uploads/images/product_details/1741961778_2e572ce87b1b0f2d97e7.png', 'Góc máy', '2025-03-14 14:16:18'),
(92, 35, 'uploads/images/product_details/1741961922_cc992518bc352bbfc763.png', 'Góc ngang', '2025-03-14 14:18:42'),
(93, 35, 'uploads/images/product_details/1741961932_0557dd5651388632caca.png', 'Góc ngang', '2025-03-14 14:18:52'),
(94, 35, 'uploads/images/product_details/1741961939_764a1ee721c1c6cac3a4.png', 'Màng lọc', '2025-03-14 14:18:59'),
(95, 36, 'uploads/images/product_details/1741962074_4407c957f69c552bcfe2.png', 'Góc ngang', '2025-03-14 14:21:14'),
(96, 36, 'uploads/images/product_details/1741962080_28f081e55d38418f4601.png', 'Màng lọc', '2025-03-14 14:21:20'),
(97, 36, 'uploads/images/product_details/1741962089_3d7769d277ece696649e.png', 'Cục nóng', '2025-03-14 14:21:30'),
(98, 37, 'uploads/images/product_details/1741962187_a5c08162aaab7f0e04e0.png', 'Góc ngang', '2025-03-14 14:23:07'),
(99, 37, 'uploads/images/product_details/1741962200_83692d8fa069c732edb1.png', 'Góc ngang', '2025-03-14 14:23:20'),
(100, 37, 'uploads/images/product_details/1741962212_db25780e959fb4b87305.png', 'Màng lọc', '2025-03-14 14:23:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `address`, `role`, `created_at`, `last_login`) VALUES
(8, 'Dương Bình', 'duonglybinh123@gmail.com', '$2y$10$SFKoXv3Y8MV4lpUyrdFMW.kacLlgxxnxvkrLZTwF3Dk8Mkzn8Ac2u', '0345591612', 'Thanh Hà, Thanh Chương, Nghê An', 'customer', '2025-03-02 09:44:43', '2025-03-15 20:22:53'),
(9, 'binh', 'duonglybinh0810@gmail.com', '$2y$10$o65ahE6nPNPsHhG7k1LxGORAJpNKrugJLFfhWUwE6GV4brgK9eXva', '0345591612', 'Thanh Hà, Thanh Chương, Nghê An', 'admin', '2025-03-02 09:44:54', '2025-03-15 19:22:47'),
(10, 'Tuan Anh', 'lybinh0810@gmail.com', '$2y$10$JDuAN22Ghs72Z9HUUichUeBqDJ1BUN1fqKL3PEFOY/MtdG71QMA4G', '0345591612', 'Thanh Hà, Thanh Chương, Nghê An', 'customer', '2025-03-14 15:26:53', '2025-03-15 20:18:12'),
(11, 'Dương Bình', 'lybinh081004@gmail.com', '$2y$10$iXA3kf5PiAQC8CpY8QXA/OYwvwhkFhYlZo30OUNSY29th1u50gYl.', '0345591612', 'Thanh Hà, Thanh Chương, Nghê An', 'customer', '2025-03-15 18:50:05', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `reply_to` (`reply_to`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`reply_to`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
