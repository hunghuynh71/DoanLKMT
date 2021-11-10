<div id="footer-wp">
    <div id="foot-body">
        <div class="wp-inner clearfix">
            <div class="block" id="info-company">
                <img id="logo-footer" src="{{asset('user/images/Logo.png')}}" alt="">
                <p class="desc">HD Computer là một đơn vị luôn cung cấp các sản phẩm bộ phận linh kiện máy tính chính hãng với giá cả hợp lý đến tận tay khách hàng. HD Computer là một đơn vị luôn cung cấp các sản phẩm bộ phận linh kiện máy tính chính hãng với giá cả hợp lý đến tận tay khách hàng.</p>
                <div id="payment">
                    <div class="thumb">
                        <img src="{{asset('images/img-foot.png')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="block menu-ft" id="info-shop">
                <h3 class="title">Thông tin cửa hàng</h3>
                <ul class="list-item">
                    <li>
                        <p>65 Huỳnh Thúc Kháng, phường Bến Nghé, quận 1, TP Hồ Chí Minh</p>
                    </li>
                    <li>
                        <p>0987.654.321 - 0989.989.989</p>
                    </li>
                    <li>
                        <p>hdcomputer@gmail.com</p>
                    </li>
                    <li>
                        <p>www.facebook.com/hdcomputer</p>
                    </li>
                    <li>
                        <p>www.zalo.com/hdcomputer</p>
                    </li>
                </ul>
            </div>
            <div class="block menu-ft policy" id="info-shop">
                <h3 class="title">Thông tin chính sách</h3>
                <ul class="list-item">
                    <li>
                        <a href="#" title="">Quy định - chính sách</a>
                    </li>
                    <li>
                        <a href="#" title="">Chính sách bảo hành - đổi trả</a>
                    </li>
                    <li>
                        <a href="#" title="">Chính sách thành viên</a>
                    </li>
                    <li>
                        <a href="#" title="">Chính sách sửa chữa</a>
                    </li>
                    <li>
                        <a href="#" title="">Giao hàng - lắp đặt</a>
                    </li>
                    <li>
                        <a href="#" title="">Thanh toán - Trả góp</a>
                    </li>
                </ul>
            </div>
            <div class="block" id="newfeed">
                <h3 class="title">Chăm sóc khách hàng</h3>
                <p>Tổng đài CSKH: </p>
                <h2 class="hotline">19001009</h2>
            </div>
        </div>
    </div>
    <div id="foot-bot">
        <div class="wp-inner">
            <p id="copyright">© Bản quyền thuộc Công ty TNHH HD Computer</p>
        </div>
    </div>
</div>
</div>
<div id="menu-respon">
    <a href="?page=home" title="" class="logo">VSHOP</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            <li>
                <a href="?page=home" title>Trang chủ</a>
            </li>
            <li>
                <a href="?page=category_product" title>Điện thoại</a>
                <ul class="sub-menu">
                    <li>
                        <a href="?page=category_product" title="">Iphone</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title="">Samsung</a>
                        <ul class="sub-menu">
                            <li>
                                <a href="?page=category_product" title="">Iphone X</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Iphone 8</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="?page=category_product" title="">Nokia</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="?page=category_product" title>Máy tính bảng</a>
            </li>
            <li>
                <a href="?page=category_product" title>Laptop</a>
            </li>
            <li>
                <a href="?page=category_product" title>Đồ dùng sinh hoạt</a>
            </li>
            <li>
                <a href="?page=blog" title>Blog</a>
            </li>
            <li>
                <a href="#" title>Liên hệ</a>
            </li>
        </ul>
    </div>
</div>
<div id="btn-top"><img src="{{asset('frontend/images/icon-to-top.png')}}" alt="" /></div>
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }

    //load huyện theo tỉnh, xã theo huyện (tính phí vc)
    $('.choose').on('change', function() {
        var _token = $('input[name="_token"]').val()
        var select_id = $(this).attr('id');
        var select_val = $(this).val();
        var result;

        if (select_id == 'province') {
            result = 'district'
        } else {
            result = 'ward'
        }

        $.ajax({
            url: "http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/load_district_ward_user",
            method: "post",
            dataType: "html",
            data: {
                _token: _token,
                select_val: select_val,
                result: result
            },
            success: function(data) {
                $('#' + result).html(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('Lỗi: ' + xhr.status + ' - ' + thrownError)
            }
        })
    })

    //tính phí vận chuyển
    $('#calculator-feeship').on('click', function() {
        var _token = $('input[name="_token"]').val();
        var province_id = $('select#province').val();
        var district_id = $('select#district').val();
        var ward_id = $('select#ward').val();

        if (province_id == '') {
            alert('Tỉnh/thành phố không được để trống!')
        } else if (district_id == '') {
            alert('Quận/huyện không được để trống!')
        } else if (ward_id == '') {
            alert('Xã/phường không được để trống!')
        } else {
            $.ajax({
                url: "http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/calculator_feeship",
                method: "post",
                data: {
                    _token: _token,
                    province_id: province_id,
                    district_id: district_id,
                    ward_id: ward_id
                },
                success: function() {     
                    location.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('Lỗi: ' + xhr.status + ' - ' + thrownError)
                }
            })
        }
    })

    //them gio hang
    $('.add-cart').on('click', function() {
        var id = $(this).attr('data-id');
        var url = "http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/add/" + id;

        $.ajax({
            url: url,
            method: "get",
            dataType: "json",
            success: function(data) {
                alert(data.success);
                //location.reload();
                $('#cart-wp').empty();
                $('#cart-wp').html(data.html_cart);
                //console.log(data)
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('Lỗi: ' + xhr.status + ' - ' + thrownError);
                //console.log(data)
            }
        })
    });

    //cập nhật số lượng giỏ hàng
    $('.num-order').change(function() {
        var _token = $("input[name='_token']").val();
        let qty = $(this).val();
        var id = $(this).attr('data-rowId');

        $.ajax({
            url: "{{route('cart.update')}}",
            dataType: "json",
            method: "post",
            data: {
                _token: _token,
                id: id,
                qty: qty
            },
            success: function(data) {
                //cập nhật html thanh thông báo giỏ hàng
                $('#cart-wp').empty();
                $('#cart-wp').html(data.html_cart);
                $('#cart-qty').html(data.num_cart);

                //cập nhật thành tiền
                $('td.subtotal-' + data.product_cart.rowId).html(number_format(data.product_cart.qty * data.product_cart.price, 0, ',', '.') + 'đ');

                //cập nhật tổng tiền      
                var total = 0;
                //tính tổng hóa đơn
                $.each(data.cart, function(key, value) {
                    total += value.price * value.qty;
                });

                //gám gt giỏ hàng
                $('span#total').html(number_format(total, 0, ',', '.') + 'đ')
                $.each(data.promotion, function(key, value) {
                    if (value.condition == 1) {
                        $('span#total_after_promotion').html(number_format(total - (total * value.number / 100), 0, ',', '.') + 'đ')
                        $('span#money_promotion').html(number_format(total * value.number / 100, 0, ',', '.') + 'đ')
                    } else if (value.condition == 2) {
                        $('span#total_after_promotion').html(number_format(total - value.number, 0, ',', '.') + 'đ')
                    }
                })

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert("Lỗi: " + xhr + " - " + thrownError);
            }
        })
    });

    //xóa sp trong giỏ hàng
    $('.del-product').on('click', function() {
        var id = $(this).attr('data-rowId');

        $.ajax({
            url: "http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/remove/" + id,
            dataType: "json",
            method: "get",
            success: function(data) {
                //cập nhật html thanh thông báo giỏ hàng
                $('#cart-wp').empty();
                $('#cart-wp').html(data.html_cart);
                //cập nhật html giỏ hàng
                // $('#info-cart-wp').empty();
                // $('#info-cart-wp').html(data.cart);
                location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert("Lỗi: " + xhr + " - " + thrownError);
            }
        })
    });

    //xóa toàn bộ giỏ hàng
    $('#destroy-cart').on('click', function() {
        $.ajax({
            url: "http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/destroy",
            dataType: "json",
            method: "get",
            success: function(data) {
                //cập nhật html thanh thông báo giỏ hàng
                $('#cart-wp').empty();
                $('#cart-wp').html(data.html_cart);
                //cập nhật html giỏ hàng
                $('#info-cart-wp').empty();
                $('#cart-qty').html("<p>Có <strong>0</strong> sản phẩm trong giỏ hàng</p>");
                //location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert("Lỗi: " + xhr + " - " + thrownError);
            }
        })
    })
</script>
</body>

</html>