<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý tin tức</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .alert-fixed {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1050;
        }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>
    <div class="d-flex">
        <?php include 'includes/sidebar.php'; ?>

        <main class="content p-4">
            <h2>📰 Quản lý Tin Tức</h2>

            <div id="alertBox"></div> <!-- Thông báo động -->

            <input type="text" id="search" class="form-control mb-3" placeholder="🔍 Tìm kiếm tin tức...">

            <button id="addNewsBtn" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Thêm tin tức
            </button>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="newsTable">
                    <?php foreach ($news as $item) : ?>
                        <tr id="news-<?= $item['id']; ?>">
                            <td><?= $item['id']; ?></td>
                            <td>
                                <?php $imagePath = $item['image'] ? base_url($item['image']) : base_url('uploads/default.png'); ?>
                                <img src="<?= $imagePath; ?>" width="80">
                            </td>
                            <td><?= esc($item['title']); ?></td>
                            <td><?= esc($item['content']); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn"
                                        data-id="<?= $item['id']; ?>"
                                        data-title="<?= esc($item['title']); ?>"
                                        data-content="<?= esc($item['content']); ?>"
                                        data-image="<?= $imagePath; ?>">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $item['id']; ?>">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal Thêm Tin Tức -->
    <div class="modal fade" id="addNewsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm tin tức</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="newTitle" class="form-control mb-3" placeholder="Tiêu đề" required>
                    <textarea id="newContent" class="form-control mb-3" placeholder="Nội dung" required></textarea>
                    <input type="file" id="newImage" class="form-control mb-3">
                </div>
                <div class="modal-footer">
                    <button id="saveNewsBtn" class="btn btn-success">Lưu</button>
                </div>
            </div>
        </div>
    </div>

<script>
    var base_url = "<?= base_url(); ?>";

    function showAlert(message, type) {
        $("#alertBox").html(`
            <div class="alert alert-${type} alert-dismissible fade show alert-fixed" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        setTimeout(() => $(".alert").fadeOut(), 3000);
    }

    function reloadNewsTable() {
        $.ajax({
            url: base_url + "admin/news/list",
            type: "GET",
            success: function (data) {
                $("#newsTable").empty().html(data);
            }
        });
    }

    $(document).ready(function () {
        $("#addNewsBtn").click(function () {
            $("#addNewsModal").modal("show");
        });

        $("#saveNewsBtn").click(function () {
            let formData = new FormData();
            formData.append("title", $("#newTitle").val());
            formData.append("content", $("#newContent").val());
            if ($("#newImage")[0].files.length > 0) {
                formData.append("image", $("#newImage")[0].files[0]);
            }

            $.ajax({
                url: base_url + "admin/news/store",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function () {
                    $("#addNewsModal").modal("hide");
                    showAlert("Thêm tin tức thành công!", "success");
                    reloadNewsTable();
                },
                error: function () {
                    showAlert("Lỗi khi thêm tin tức!", "danger");
                }
            });
        });

        $(document).on("click", ".edit-btn", function () {
            let id = $(this).data("id");
            let title = $(this).data("title");
            let content = $(this).data("content");
            let image = $(this).data("image");

            $("#edit_id").val(id);
            $("#edit_title").val(title);
            $("#edit_content").val(content);
            $("#edit_image_preview").attr("src", image);

            $("#editNewsModal").modal("show");
        });

        $(document).on("click", ".delete-btn", function () {
            if (!confirm("Bạn có chắc chắn muốn xóa?")) return;
            let id = $(this).data("id");

            $.ajax({
                url: base_url + "admin/news/delete/" + id,
                type: "GET",
                success: function () {
                    showAlert("Xóa tin tức thành công!", "success");
                    $("#news-" + id).remove();
                },
                error: function () {
                    showAlert("Lỗi khi xóa tin tức!", "danger");
                }
            });
        });
    });
</script>

</body>
</html>
