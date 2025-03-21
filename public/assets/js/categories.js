$(document).ready(function () {
    // 🟢 Khi bấm "Thêm danh mục", mở popup
    $("#addCategoryBtn").on("click", function () {
        $("#newCategoryName").val(""); // Xóa input trước khi mở
        $("#newCategoryDesc").val("");
        $("#addCategoryModal").modal("show");
    });

    // 🟡 Khi bấm "Sửa", mở popup với dữ liệu tương ứng
    $(document).on("click", ".edit-btn", function () {
        $("#edit_id").val($(this).data("id"));
        $("#edit_name").val($(this).data("name"));
        $("#edit_desc").val($(this).data("desc"));
        $("#editCategoryModal").modal("show");
    });

    // 🔴 Khi bấm "Đóng" trong popup, ẩn modal
    $(".btn-close").on("click", function () {
        $(".modal").modal("hide");
    });

    // 🟢 Thêm danh mục bằng Ajax (Không tải lại trang)
    $("#saveCategoryBtn").on("click", function () {
        let name = $("#newCategoryName").val().trim();
        let desc = $("#newCategoryDesc").val().trim();

        if (name === "") {
            alert("⚠️ Tên danh mục không được để trống!");
            return;
        }

        $.ajax({
            url: base_url + "/admin/add_category",
            type: "POST",
            data: { category_name: name, description: desc },
            dataType: "json",
            success: function (response) {
                alert("✅ Danh mục đã được thêm!");

                // Đóng modal
                $("#addCategoryModal").modal("hide");

                // Thêm danh mục mới vào bảng mà không tải lại trang
                let newRow = `<tr id="category-${response.id}">
                    <td>${response.id}</td>
                    <td>${name}</td>
                    <td>${desc}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn"
                                data-id="${response.id}"
                                data-name="${name}"
                                data-desc="${desc}">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn"
                                data-id="${response.id}">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                </tr>`;

                $("#categoryTable").append(newRow);
                $("#newCategoryName, #newCategoryDesc").val("");
            },
            error: function () {
                alert("❌ Có lỗi xảy ra, vui lòng thử lại!");
            }
        });
    });

    $(document).ready(function () {
        // 🟡 Khi bấm "Sửa", mở popup với dữ liệu tương ứng
        $(document).on("click", ".edit-btn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let desc = $(this).data("desc");
    
            $("#edit_id").val(id);
            $("#edit_name").val(name);
            $("#edit_desc").val(desc);
    
            $("#editCategoryModal").modal("show"); // Hiển thị modal sửa
        });
    
        // 🟡 Cập nhật danh mục bằng Ajax (Không tải lại trang)
        $("#updateCategoryBtn").on("click", function () {
            let id = $("#edit_id").val();
            let name = $("#edit_name").val().trim();
            let desc = $("#edit_desc").val().trim();
    
            if (name === "") {
                alert("⚠️ Tên danh mục không được để trống!");
                return;
            }
    
            $.ajax({
                url: base_url + "/admin/edit_category",
                type: "POST",
                data: { id: id, category_name: name, description: desc },
                success: function () {
                    alert("✅ Danh mục đã được cập nhật!");
    
                    // Đóng modal
                    $("#editCategoryModal").modal("hide");
    
                    // Cập nhật dữ liệu trong bảng
                    $(`#category-${id} td:nth-child(2)`).text(name);
                    $(`#category-${id} td:nth-child(3)`).text(desc);
    
                    // Cập nhật lại nút sửa với dữ liệu mới
                    $(`#category-${id} .edit-btn`).data("name", name);
                    $(`#category-${id} .edit-btn`).data("desc", desc);
                },
                error: function () {
                    alert("❌ Có lỗi xảy ra, vui lòng thử lại!");
                }
            });
        });
    });
    

    // 🔴 Xóa danh mục bằng Ajax (Không tải lại trang)
    $(document).on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        if (confirm("⚠️ Bạn có chắc chắn muốn xóa danh mục này?")) {
            $.ajax({
                url: base_url + "/admin/delete_category/" + id,
                type: "GET",
                success: function () {
                    alert("✅ Danh mục đã bị xóa!");
                    $(`#category-${id}`).remove(); // Xóa danh mục khỏi bảng
                },
                error: function () {
                    alert("❌ Có lỗi xảy ra, vui lòng thử lại!");
                }
            });
        }
    });

    // 🔍 Tìm kiếm danh mục
    $("#search").on("keyup", function () {
        let value = $(this).val().toLowerCase();
        $("#categoryTable tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
