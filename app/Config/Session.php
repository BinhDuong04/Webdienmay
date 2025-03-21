<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\FileHandler;

class Session extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Session Driver
     * --------------------------------------------------------------------------
     *
     * Chọn driver lưu trữ session: 
     * - `CodeIgniter\Session\Handlers\FileHandler` (Lưu vào file)
     * - `CodeIgniter\Session\Handlers\DatabaseHandler` (Lưu vào cơ sở dữ liệu)
     * - `CodeIgniter\Session\Handlers\MemcachedHandler`
     * - `CodeIgniter\Session\Handlers\RedisHandler`
     *
     * Chúng ta sẽ sử dụng FileHandler để lưu session vào file.
     *
     * @var class-string<BaseHandler>
     */
    public string $driver = FileHandler::class;

    /**
     * --------------------------------------------------------------------------
     * Session Cookie Name
     * --------------------------------------------------------------------------
     *
     * Tên cookie của session, chỉ có thể chứa các ký tự [0-9a-z_-].
     */
    public string $cookieName = 'ci_session';

    /**
     * --------------------------------------------------------------------------
     * Session Expiration
     * --------------------------------------------------------------------------
     *
     * Thời gian (tính bằng giây) mà session sẽ hết hạn.
     * Nếu đặt là 0, session sẽ hết hạn khi trình duyệt được đóng.
     */
    public int $expiration = 7200;  // Session hết hạn sau 2 giờ

    /**
     * --------------------------------------------------------------------------
     * Session Save Path
     * --------------------------------------------------------------------------
     *
     * Vị trí lưu trữ session, với driver 'files' sẽ là đường dẫn tới thư mục có thể ghi.
     * Cần phải sử dụng đường dẫn tuyệt đối.
     * Đảm bảo rằng thư mục này có quyền ghi.
     */
    public string $savePath = WRITEPATH . 'session';  // Đảm bảo lưu vào writable/session

    /**
     * --------------------------------------------------------------------------
     * Session Match IP
     * --------------------------------------------------------------------------
     *
     * Có nên so khớp IP của người dùng khi đọc dữ liệu session không?
     * Nếu sử dụng database driver, cần phải thay đổi khóa chính của bảng session.
     */
    public bool $matchIP = false;

    /**
     * --------------------------------------------------------------------------
     * Session Time to Update
     * --------------------------------------------------------------------------
     *
     * Số giây giữa các lần CI tái tạo lại session ID.
     */
    public int $timeToUpdate = 300;  // Tái tạo session ID mỗi 5 phút

    /**
     * --------------------------------------------------------------------------
     * Session Regenerate Destroy
     * --------------------------------------------------------------------------
     *
     * Có nên hủy dữ liệu session liên quan đến session ID cũ khi tái tạo session ID không?
     * Nếu đặt thành FALSE, dữ liệu sẽ bị xóa sau khi bộ thu gom rác hoạt động.
     */
    public bool $regenerateDestroy = false;

    /**
     * --------------------------------------------------------------------------
     * Session Database Group
     * --------------------------------------------------------------------------
     *
     * Nếu bạn sử dụng cơ sở dữ liệu cho session, bạn có thể chỉ định nhóm CSDL ở đây.
     * Với FileHandler, không cần cấu hình này.
     */
    public ?string $DBGroup = null;

    /**
     * --------------------------------------------------------------------------
     * Lock Retry Interval (microseconds)
     * --------------------------------------------------------------------------
     *
     * Thời gian (tính bằng micro giây) để đợi nếu không thể lấy khóa.
     * Tham số này chỉ áp dụng cho RedisHandler.
     */
    public int $lockRetryInterval = 100_000;

    /**
     * --------------------------------------------------------------------------
     * Lock Max Retries
     * --------------------------------------------------------------------------
     *
     * Số lần thử tối đa để lấy khóa (chỉ áp dụng cho RedisHandler).
     */
    public int $lockMaxRetries = 300;
}
