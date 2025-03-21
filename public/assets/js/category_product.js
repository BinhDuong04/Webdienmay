$(document).ready(function() {
    const productsPerPage = 8; // Số sản phẩm trên mỗi trang
    let currentPage = parseInt($('#currentPage').val()); // Lấy trang hiện tại từ dữ liệu phía server
    let totalPages = parseInt($('#totalPages').val()); // Lấy tổng số trang từ dữ liệu phía server

    // Cập nhật mục "Sản phẩm khác"
    function updateOtherProducts() {
        let allOtherProducts = $('.other-products .product-card');
        allOtherProducts.hide(); // Ẩn tất cả sản phẩm

        let selectedProducts = allOtherProducts.slice(0, 5); // Chỉ lấy 5 sản phẩm đầu tiên
        selectedProducts.show();
    }

    // Lọc sản phẩm theo bộ lọc (hãng, mức giá)
    function filterProducts() {
        let selectedBrands = $('.filter-brand:checked').map(function() {
            return $(this).val();
        }).get();

        let selectedPrices = $('.filter-price:checked').map(function() {
            return $(this).val();
        }).get();

        let hasMatch = false;

        $('.filtered-grid .product-card').each(function() {
            let productBrand = $(this).data('brand');
            let productPrice = parseFloat($(this).data('price'));

            let brandMatch = selectedBrands.length === 0 || selectedBrands.includes(productBrand);
            let priceMatch = selectedPrices.length === 0 || selectedPrices.some(priceRange => {
                return (priceRange === 'under-5000000' && productPrice < 5000000) ||
                       (priceRange === '5000000-10000000' && productPrice >= 5000000 && productPrice <= 10000000) ||
                       (priceRange === 'over-10000000' && productPrice > 10000000);
            });

            if (brandMatch && priceMatch) {
                $(this).show();
                hasMatch = true;
            } else {
                $(this).hide();
            }
        });

        $('.no-product-message').toggle(!hasMatch);
        updatePagination();
    }

    // Cập nhật phân trang
    function updatePagination() {
        let products = $('.filtered-grid .product-card:visible'); // Chỉ lấy sản phẩm đang hiển thị
        let totalPages = Math.ceil(products.length / productsPerPage);

        $('.pagination').empty();
        for (let i = 1; i <= totalPages; i++) {
            let activeClass = i === currentPage ? 'active' : '';
            $('.pagination').append(`<li class="page-item ${activeClass}" data-page="${i}"><a href="#">${i}</a></li>`);
        }

        showPage(currentPage);
    }

    // Hiển thị sản phẩm theo trang
    function showPage(page) {
        currentPage = page;
        let products = $('.filtered-grid .product-card:visible');
        products.hide(); // Ẩn tất cả sản phẩm trước

        let start = (page - 1) * productsPerPage;
        let end = start + productsPerPage;
        products.slice(start, end).show(); // Chỉ hiển thị sản phẩm của trang này

        $('.page-item').removeClass('active');
        $(`.page-item[data-page="${page}"]`).addClass('active'); // Thêm class active cho trang hiện tại
    }

    // Sự kiện click phân trang
    $('.pagination').on('click', '.page-item', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        if (page !== currentPage) { // Chỉ chuyển trang nếu trang khác trang hiện tại
            showPage(page);
        }
    });

    // Chạy lại lọc sản phẩm khi thay đổi bộ lọc
    $('.filter-brand, .filter-price').change(filterProducts);

    // Sắp xếp sản phẩm
    $('.sort-btn').click(function() {
        let sortType = $(this).data('sort');
        let products = $('.filtered-grid .product-card:visible').get();

        // Thêm class active vào nút được chọn
        $('.sort-btn').removeClass('active');
        $(this).addClass('active');

        products.sort(function(a, b) {
            if (sortType.includes("name")) {
                let aValue = $(a).find("h3").text().toLowerCase();
                let bValue = $(b).find("h3").text().toLowerCase();
                return sortType === "name-asc" ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            } else if (sortType.includes("price")) {
                let aValue = parseFloat($(a).data("price"));
                let bValue = parseFloat($(b).data("price"));
                return sortType === "price-asc" ? aValue - bValue : bValue - aValue;
            }
        });

        $('.filtered-grid').append(products);
        updatePagination(); // Cập nhật phân trang sau khi sắp xếp
    });

    // Khởi chạy ban đầu cho các bộ lọc và phân trang
    updatePagination();
    updateOtherProducts();
});