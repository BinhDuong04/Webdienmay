$(document).ready(function () {
    var baseUrl = $('script[src$="products.js"]').attr('src').replace('/assets/js/products.js', '');

    // 🔍 Tìm kiếm sản phẩm
    $("#searchProduct").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#productTable tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // 🛒 Hiển thị popup thêm sản phẩm
    $("#addProductBtn").on("click", function () {
        $("#addProductModal input, #addProductModal textarea, #addProductModal select").val('');
        $("#addProductImage").val(null);
        $("#addProductModal").modal("show");
    });

    // ➕ Thêm sản phẩm
    $("#saveProductBtn").on("click", function (e) {
    e.preventDefault();

    var formData = new FormData();
    formData.append("name", $("#newProductName").val());
    formData.append("category_id", $("#newProductCategory").val());
    formData.append("price", $("#newProductPrice").val().replace(/\./g, ''));
    formData.append("stock", $("#newProductStock").val());
    formData.append("description", $("#newProductDesc").val());

    var images = $("#newProductImage")[0].files;
    for (var i = 0; i < images.length; i++) {
        formData.append("images[]", images[i]);
    }

    $.ajax({
        url: base_url + "/admin/store",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // Đảm bảo nhận JSON từ server
        success: function (response) {
            if (response.status === "success") {
                showNotification(response.message, "success");
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(response.message, "danger");
            }
        },
        error: function (xhr, status, error) {
            console.error("Lỗi AJAX:", xhr.responseText);
            showNotification("Lỗi khi thêm sản phẩm! Vui lòng kiểm tra console.", "danger");
        }
    });
});


    // ✏️ Hiển thị popup sửa sản phẩm
    $(".edit-product-btn").on("click", function () {
        var id = $(this).data("id");
        var name = $(this).data("name");
        var category = $(this).data("category");
        var price = new Intl.NumberFormat('vi-VN').format($(this).data("price"));
        var stock = $(this).data("stock");
        var desc = $(this).data("desc");
        var images = JSON.parse($(this).closest('tr').find('td img').attr('data-images') || "[]");

        $("#editProductId").val(id);
        $("#editProductName").val(name);
        $("#editProductCategory").val(category);
        $("#editProductPrice").val(price);
        $("#editProductStock").val(stock);
        $("#editProductDesc").val(desc);

        // Hiển thị ảnh cũ
        $("#editProductImagesPreview").empty();
        if (images.length > 0) {
            images.forEach(function (img) {
                $("#editProductImagesPreview").append('<img src="' + baseUrl + '/' + img + '" width="50" height="50" class="rounded mx-1">');
            });
        }

        $("#editProductModal").modal("show");
    });

    // 🔄 Cập nhật sản phẩm
    $("#updateProductBtn").on("click", function (e) {
        e.preventDefault();

        var formData = new FormData();
        formData.append("id", $("#editProductId").val());
        formData.append("name", $("#editProductName").val());
        formData.append("category_id", $("#editProductCategory").val());
        formData.append("price", $("#editProductPrice").val().replace(/\./g, ''));
        formData.append("stock", $("#editProductStock").val());
        formData.append("description", $("#editProductDesc").val());

        var images = $("#editProductImage")[0].files;
        for (var i = 0; i < images.length; i++) {
            formData.append("images[]", images[i]);
        }

        $.ajax({
            url: baseUrl + "/admin/update",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    showNotification(response.message, "success");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification("Lỗi khi cập nhật sản phẩm!", "danger");
                }
            },
            error: function () {
                showNotification("Lỗi khi cập nhật sản phẩm!", "danger");
            }
        });
    });

    // ❌ Xóa sản phẩm
    $(".delete-product-btn").on("click", function () {
        var id = $(this).data("id");
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
            $.ajax({
                url: baseUrl + "/admin/delete/" + id,
                type: "POST",
                success: function (response) {
                    if (response.status === "success") {
                        showNotification(response.message, "success");
                        $("#product-" + id).remove();
                    } else {
                        showNotification("Lỗi khi xóa sản phẩm!", "danger");
                    }
                },
                error: function () {
                    showNotification("Lỗi khi xóa sản phẩm!", "danger");
                }
            });
        }
    });
});

// 📢 Hiển thị thông báo
function showNotification(message, type) {
    var alertBox = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`;
    $("#notification").html(alertBox);
}

// 💰 Định dạng giá tiền
function formatCurrency(input) {
    let value = input.value.replace(/\D/g, "");
    value = new Intl.NumberFormat('vi-VN').format(value);
    input.value = value;
}



$(document).ready(function() {
    $('.detail-product-btn').click(function() {
        let productId = $(this).data('id');

        $.ajax({
            url: base_url + "/admin/product_details/" + productId,
            type: "GET",
            success: function(response) {
                if (response.status === "success") {
                    let product = response.data.product;
                    let details = response.data.details;
                    let images = response.data.images;

                    $('#detailProductId').val(product.id);
                    $('#detailProductName').text(product.name);
                    $('#detailProductCategory').text(product.category_name);
                    $('#detailProductPrice').text(product.price.toLocaleString() + "₫");
                    $('#detailProductStock').text(product.stock);
                    $('#detailProductDesc').text(product.description);

                    $('#detailBrand').val(details?.brand || '');
                    $('#detailOrigin').val(details?.origin || '');
                    $('#detailWarranty').val(details?.warranty || '');
                    $('#detailWeight').val(details?.weight || '');
                    $('#detailDimensions').val(details?.dimensions || '');
                    $('#detailAdditionalInfo').val(details?.additional_info || '');

                    let imageHtml = "";
                    if (images.length > 0) {
                        images.forEach(img => {
                            imageHtml += `<img src="${base_url}/${img.image_url}" class="img-thumbnail m-1" width="100">`;
                        });
                    } else {
                        imageHtml = "<p>Không có hình ảnh.</p>";
                    }
                    $('#detailProductImages').html(imageHtml);

                    $('#productDetailModal').modal('show');
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $('#saveProductDetails').click(function() {
        let formData = {
            id: $('#detailProductId').val(),
            brand: $('#detailBrand').val(),
            origin: $('#detailOrigin').val(),
            warranty: $('#detailWarranty').val(),
            weight: $('#detailWeight').val(),
            dimensions: $('#detailDimensions').val(),
            additional_info: $('#detailAdditionalInfo').val(),
        };

        $.post(base_url + "/admin/update_product_details", formData, function(response) {
            alert(response.message);
            $('#productDetailModal').modal('hide');
        });
    });
});

$(document).ready(function() {
    $('.detail-product-btn').click(function() {
        let productId = $(this).data('id');

        $.ajax({
            url: base_url + "/admin/product_details/" + productId,
            type: "GET",
            success: function(response) {
                if (response.status === "success") {
                    let product = response.data.product;
                    let images = response.data.images;

                    $('#detailProductId').val(product.id);
                    $('#detailProductName').text(product.name);

                    let imageHtml = "";
                    if (images.length > 0) {
                        images.forEach(img => {
                            imageHtml += `<div class="m-1 text-center">
                                <img src="${base_url}/${img.image_url}" class="img-thumbnail" width="100">
                                <p>${img.description || ''}</p>
                            </div>`;
                        });
                    }
                    $('#detailProductImages').html(imageHtml);

                    $('#productDetailModal').modal('show');
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $('#uploadImagesBtn').click(function () {
        let productId = $('#detailProductId').val();
        let formData = new FormData();
        formData.append("product_id", productId);

        let images = $('#uploadProductImages')[0].files;
        let descriptions = $('#uploadImageDescriptions').val().split(',');

        for (let i = 0; i < images.length; i++) {
            formData.append("images[]", images[i]);
            formData.append("descriptions[]", descriptions[i] || '');
        }

        $.ajax({
            url: base_url + "/admin/upload_product_images",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    alert(response.message);

                    let imageHtml = "";
                    response.images.forEach(img => {
                        imageHtml += `<div class="m-1 text-center">
                            <img src="${img.image_url}" class="img-thumbnail" width="100">
                            <p>${img.description || ''}</p>
                        </div>`;
                    });

                    // Nếu chưa có ảnh trước đó, thay thế nội dung, nếu có rồi thì thêm vào
                    if ($('#detailProductImages').html().includes("<p>Không có hình ảnh.</p>")) {
                        $('#detailProductImages').html(imageHtml);
                    } else {
                        $('#detailProductImages').append(imageHtml);
                    }

                    $('#uploadProductImages').val(null);
                    $('#uploadImageDescriptions').val('');
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert("Lỗi khi tải ảnh!");
            }
        });
    });
});
