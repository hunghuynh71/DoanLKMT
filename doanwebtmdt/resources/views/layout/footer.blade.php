<div id="footer-wp">
    <div id="foot-body">
        <div class="wp-inner clearfix">
            <div class="block" id="info-company">
                <img id="logo-footer" src="{{asset('user/images/Logo.png')}}" alt="">
                <p class="desc">@lang('lang.hdcomputer')</p>
                <div id="payment">
                    <div class="thumb">
                        <img src="{{asset('images/img-foot.png')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="block menu-ft" id="info-shop">
                <h3 class="title">@lang('lang.thongtincuahang')</h3>
                <ul class="list-item">
                    <li>
                        <p>@lang('lang.diachi')</p>
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
                <h3 class="title">@lang('lang.thongtinchinhsach')</h3>
                <ul class="list-item">
                    <li>
                        <a href="#" title="">@lang('lang.quydinh_chinhsach')</a>
                    </li>
                    <li>
                        <a href="#" title="">@lang('lang.chinhsachdoitra')</a>
                    </li>
                    <li>
                        <a href="#" title="">@lang('lang.chinhsachthanhvien')</a>
                    </li>
                    <li>
                        <a href="#" title="">@lang('lang.chinhsachsuachua')</a>
                    </li>
                    <li>
                        <a href="#" title="">@lang('lang.giaohanglapdat')</a>
                    </li>
                    <li>
                        <a href="#" title="">@lang('lang.thanhtoan_tragop')</a>
                    </li>
                </ul>
            </div>
            <div class="block" id="newfeed">
                <h3 class="title">@lang('lang.chamsockhachhang')</h3>
                <p>@lang('lang.tongdai')</p>
                <h2 class="hotline">19001009</h2>
            </div>
        </div>
    </div>
    <div id="foot-bot">
        <div class="wp-inner">
            <p id="copyright">@lang('lang.banquyen')</p>
        </div>
    </div>
</div>
</div>
<div id="menu-respon">
    <a href="?page=home" title="" class="logo">VSHOP</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            <li>
                <a href="?page=home" title>Trang ch???</a>
            </li>
            <li>
                <a href="?page=category_product" title>??i???n tho???i</a>
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
                <a href="?page=category_product" title>M??y t??nh b???ng</a>
            </li>
            <li>
                <a href="?page=category_product" title>Laptop</a>
            </li>
            <li>
                <a href="?page=category_product" title>????? d??ng sinh ho???t</a>
            </li>
            <li>
                <a href="?page=blog" title>Blog</a>
            </li>
            <li>
                <a href="#" title>Li??n h???</a>
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

    //ht t???nh, huy???n, x??, th??ng tin giao h??ng(n???u c??)
    load_feeship_infoship();

    //load huy???n theo t???nh, x?? theo huy???n (t??nh ph?? vc)
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
            url: "{{route('cart.load_district_ward_user')}}",
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
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert('L???i: ' + xhr.status + ' - ' + thrownError)
            // }
        })
    })

    //t??nh ph?? v???n chuy???n
    $('#ward').on('change', function() {
        var _token = $('input[name="_token"]').val();
        var province_id = $('select#province').val();
        var district_id = $('select#district').val();
        var ward_id = $('select#ward').val();

        var html_province = $('select#province').html();
        var html_district = $('select#district').html();
        var html_ward = $('select#ward').html();
        var name = $('#name').val();
        var phone = $('#phone').val();
        var note = $('#note').val();
        var address = $('#address').val();
        var payment = $('#payment').val();
        
        if (province_id == '') {
            alert('T???nh/th??nh ph??? kh??ng ???????c ????? tr???ng!')
        } else if (district_id == '') {
            alert('Qu???n/huy???n kh??ng ???????c ????? tr???ng!')
        } else if (ward_id == '') {
            alert('X??/ph?????ng kh??ng ???????c ????? tr???ng!')
        } else {
            $.ajax({
                url: "{{route('cart.calculator_feeship')}}",
                method: "post",
                data: {
                    _token: _token,
                    province_id: province_id,
                    district_id: district_id,
                    ward_id: ward_id,
                    html_province: html_province,
                    html_district: html_district,
                    html_ward: html_ward,
                    name: name,
                    phone: phone,
                    note: note,
                    address: address,
                    payment: payment,
                },
                success: function() {
                    location.reload();
                },
                // error: function(xhr, ajaxOptions, thrownError) {
                //     alert('L???i: ' + xhr.status + ' - ' + thrownError)
                // }
            })
        }
    })

    function load_feeship_infoship() {
        $.ajax({
            url: "{{route('cart.check_feeship_infoship')}}",
            dataType: "json",
            method: "get",
            success: function(data) {
                if (data.infoship.status == 'exist') {
                    $('#name').val(data.infoship.name);
                    $('#phone').val(data.infoship.phone);
                    $('#address').val(data.infoship.address);
                    $('#note').val(data.infoship.note);
                    $('#payment').val(data.infoship.payment);
                }

                if (data.feeship.status == 'exist') {
                    $('select#province').html(data.feeship.html_province);
                    $('select#district').html(data.feeship.html_district);
                    $('select#ward').html(data.feeship.html_ward);

                    $('select#province').val(data.feeship.province_id);
                    $('select#district').val(data.feeship.district_id);
                    $('select#ward').val(data.feeship.ward_id);
                }

                //ht n??t thanh to??n paypal
                display_paypal_button(data);
            }
        })
    }

    //them gio hang
    $('.add-cart').on('click', function() {
        var id = $(this).attr('data-id');
        var url = "{{url('user/cart/add')}}/" + id;

        $.ajax({
            url: url,
            method: "get",
            dataType: "json",
            success: function(data) {
                if (data.status == 'success') {
                    //ht sweet alert
                    swal({
                            title: data.title,
                            text: data.message,
                            type: data.status,
                            showCancelButton: true,
                            cancelButtonText: "Mua ti???p",
                            confirmButtonColor: "green",
                            confirmButtonText: "??i ?????n gi??? h??ng",
                            closeOnConfirm: false
                        },
                        function() {
                            window.location.href = "{{route('cart.show')}}";
                        });

                    $('#cart-wp').empty();
                    $('#cart-wp').html(data.html_cart);
                    //console.log(data)
                } else {
                    //ht sweet alert
                    swal({
                            title: data.title,
                            text: data.message,
                            type: data.status,
                            showCancelButton: true,
                            cancelButtonText: "Tho??t",
                            confirmButtonColor: "red",
                            confirmButtonText: "????ng nh???p",
                            closeOnConfirm: false
                        },
                        function() {
                            window.location.href = "{{route('account.login')}}";
                        });
                }
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert('L???i: ' + xhr.status + ' - ' + thrownError);
            // }
        })
    });

    //c???p nh???t s??? l?????ng gi??? h??ng
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
                //c???p nh???t html thanh th??ng b??o gi??? h??ng
                $('#cart-wp').empty();
                $('#cart-wp').html(data.html_cart);
                $('#cart-qty').html(data.num_cart);

                //c???p nh???t th??nh ti???n
                $('td.subtotal-' + data.product_cart.rowId).html(number_format(data.product_cart.qty * data.product_cart.price, 0, ',', '.') + '??');

                //c???p nh???t t???ng ti???n      
                var total = 0;
                //t??nh t???ng h??a ????n
                $.each(data.cart, function(key, value) {
                    total += value.price * value.qty;
                });

                //g??n gt gi??? h??ng
                $('span#total').html(number_format(total, 0, ',', '.') + '??')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert("L???i: " + xhr + " - " + thrownError);
            }
        })
    });

    //x??a sp trong gi??? h??ng
    $('.del-product').on('click', function() {
        var id = $(this).attr('data-rowId');
        var url = "{{url('user/cart/remove')}}/" + id;

        $.ajax({
            url: url,
            dataType: "json",
            method: "get",
            success: function(data) {
                //c???p nh???t html thanh th??ng b??o gi??? h??ng
                $('#cart-wp').empty();
                $('#cart-wp').html(data.html_cart);
                //c???p nh???t html gi??? h??ng
                // $('#info-cart-wp').empty();
                // $('#info-cart-wp').html(data.cart);
                location.reload();
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert("L???i: " + xhr + " - " + thrownError);
            // }
        })
    });

    //x??a to??n b??? gi??? h??ng
    $('#destroy-cart').on('click', function() {
        $.ajax({
            url: "{{route('cart.destroy')}}",
            dataType: "json",
            method: "get",
            success: function(data) {
                //c???p nh???t html thanh th??ng b??o gi??? h??ng
                $('#cart-wp').empty();
                $('#cart-wp').html(data.html_cart);
                //c???p nh???t html gi??? h??ng
                $('#info-cart-wp').empty();
                $('#cart-qty').html("<p>C?? <strong>0</strong> s???n ph???m trong gi??? h??ng</p>");
                //location.reload();

                //ht sweet alert
                swal({
                        title: "X??a th??nh c??ng",
                        text: "T???t c??? s???n ph???m trong gi??? h??ng ???? ???????c x??a",
                        type: "success",
                        showCancelButton: true,
                        cancelButtonText: "Tho??t",
                        confirmButtonColor: "green",
                        confirmButtonText: "V??? trang ch???",
                        closeOnConfirm: false
                    },
                    function() {
                        window.location.href = "{{route('home')}}";
                    });
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert("L???i: " + xhr + " - " + thrownError);
            // }
        })
    })

    //???n hi???n n??t thanh to??n paypal
    //khi thay ?????i pt thanh to??n
    $('#payment').on('change', function() {
        var value = $(this).val();
        if (value == 'onl') {
            var name = $('#name').val();
            var phone = $('#phone').val();
            var address = $('#address').val();
            var province_id = $('#province').val();
            var district_id = $('#district').val();
            var ward_id = $('#ward').val();

            if (!name) {
                alert('B???n ch??a nh???p h??? t??n ng?????i nh???n h??ng');
                $(this).val('');
            } else if (!phone) {
                alert('B???n ch??a nh???p s??? ??i???n tho???i ng?????i nh???n h??ng');
                $(this).val('');
            } else if (!province_id) {
                alert('B???n ch??a ch???n t???nh/th??nh ph???');
                $(this).val('');
            } else if (!district_id) {
                alert('B???n ch??a ch???n qu???n/huy???n');
                $(this).val('');
            } else if (!ward_id) {
                alert('B???n ch??a ch???n x??/ph?????ng/th??? tr???n');
                $(this).val('');
            } else if (!address) {
                alert('B???n ch??a nh???p s??? nh?? t??n ???????ng ng?????i nh???n h??ng');
                $(this).val('');
            } else {
                // v?? hi???u h??a n??t ?????t h??ng
                $('#order-now').attr('disabled', 'disabled');
                // hi???n n??t paypal 
                paypal_payment();
            }
        } else {
            //v?? hi???u h??a n??t paypal
            $('#paypal-button').html('');
            //k??ch ho???t n??t ?????t h??ng
            $('#order-now').removeAttr('disabled');
        }
    })

    //khi load l???i trang
    function display_paypal_button(data) {
        if (data.infoship.payment == 'onl') {
            var name = data.infoship.name;
            var phone = data.infoship.phone;
            var address = data.infoship.address;
            var province_id = data.feeship.province_id;
            var district_id = data.feeship.district_id;
            var ward_id = data.feeship.ward_id;

            if (!name || !phone || !province_id || !district_id || !ward_id || !address) {
                $('#payment').val('');
            } else {
                // v?? hi???u h??a n??t ?????t h??ng
                $('#order-now').attr('disabled', 'disabled');
                // hi???n n??t paypal 
                paypal_payment();
            }
        } else {
            //v?? hi???u h??a n??t paypal
            $('#paypal-button').html('');
            //k??ch ho???t n??t ?????t h??ng
            $('#order-now').removeAttr('disabled');
        }
    }

    //??p d???ng m?? khuy???n m??i
    $('#btn-promotion-code').on('click', function() {
        var _token = $('input[name="_token"]').val();
        var promotion_code = $('#promotion_code').val();
        var name = $('#name').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var note = $('#note').val();
        var payment = $("select[name='payment']").val();
        var province_id = $('#province').val();
        var district_id = $('#district').val();
        var ward_id = $('#ward').val();

        if (!promotion_code) {
            alert('B???n ch??a nh???p m?? khuy???n m??i!');
        } else {
            $.ajax({
                url: "{{route('promotion.process')}}",
                method: "post",
                dataType: "json",
                data: {
                    _token: _token,
                    promotion_code: promotion_code,
                    name: name,
                    phone: phone,
                    province_id: province_id,
                    district_id: district_id,
                    ward_id: ward_id,
                    address: address,
                    note: note,
                    payment: payment
                },
                success: function(data) {
                    //ht sweet alert
                    swal({
                        title: data.title,
                        text: data.message,
                        type: data.status,
                    },function(){
                        location.reload();
                    });
                },
                // error: function(xhr, ajaxOptions, thrownError) {
                //     alert('L???i: ' + xhr.status + ' - ' + thrownError);
                // }
            })
        }
    })

    //?????t h??ng
    $('#order-now').on('click', function() {
        var name = $('#name').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var note = $('#note').val();
        var payment = $("select[name='payment']").val();
        var province_id = $('#province').val();
        var district_id = $('#district').val();
        var ward_id = $('#ward').val();

        if (!name) {
            alert('B???n ch??a nh???p h??? t??n ng?????i nh???n h??ng')
        } else if (!phone) {
            alert('B???n ch??a nh???p s??? ??i???n tho???i ng?????i nh???n h??ng')
        } else if (!province_id) {
            alert('B???n ch??a ch???n t???nh/th??nh ph???')
        } else if (!district_id) {
            alert('B???n ch??a ch???n qu???n/huy???n')
        } else if (!ward_id) {
            alert('B???n ch??a ch???n x??/ph?????ng/th??? tr???n')
        } else if (!address) {
            alert('B???n ch??a nh???p s??? nh?? t??n ???????ng ng?????i nh???n h??ng')
        } else if (!payment) {
            alert('B???n ch??a ch???n ph????ng th???c thanh to??n')
        } else {
            swal({
                    title: "B???n c?? th???c s??? mu???n ?????t h??ng?",
                    text: "????n h??ng s??? kh??ng ???????c ho??n tr??? l???i n???u nh?? b???n ?????t h??ng!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Tho??t",
                    confirmButtonColor: "#ff6c00",
                    confirmButtonText: "?????t h??ng",
                    closeOnConfirm: false
                },
                function() {
                    pay(name,phone,province_id,district_id,ward_id,address,note,payment);
                });
        }
    })

    function pay(name,phone,province_id,district_id,ward_id,address,note,payment) {
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{route('cart.pay')}}",
            method: "post",
            dataType: "json",
            data: {
                _token: _token,
                name: name,
                phone: phone,
                province_id: province_id,
                district_id: district_id,
                ward_id: ward_id,
                address: address,
                note: note,
                payment: payment
            },
            success: function(data) {
                //ht sweet alert
                swal({
                    title: data.title,
                    text: data.message,
                    type: data.status,
                    confirmButtonText: "V??? l???i trang ch???",
                    confirmButtonColor: "#7787b1",
                    closeOnConfirm: false
                }, function() {
                    window.location.href = "{{route('home')}}";
                });
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert('L???i: ' + xhr.status + ' - ' + thrownError);
            // }
        })
    }
</script>
<!-- paypal -->
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    function paypal_payment() {
        var total_to_usd = document.getElementById('total_to_usd').value;
        paypal.Button.render({
            // Configure environment
            env: 'sandbox',
            client: {
                sandbox: 'AQyiIBuTldHXp8sxq2UShzq_qfmZbGRsAzSCYpLnLngbUZn1PaM2iWR5klIILOb0UAvgOomRapDtKjT8',
                production: 'demo_production_client_id'
            },
            // Customize button (optional)
            locale: 'en_US',
            style: {
                size: 'large',
                color: 'gold',
                shape: 'pill',
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,

            // Set up a payment
            payment: function(data, actions) {
                return actions.payment.create({
                    transactions: [{
                        amount: {
                            total: `${total_to_usd}`,
                            currency: 'USD'
                        }
                    }]
                });
            },

            // Execute the payment
            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function() {
                    // Show a confirmation message to the buyer
                    //window.alert('Thanh to??n th??nh c??ng. C???m ??n b???n ???? mua h??ng');

                    //th??m d??? li???u ?????t h??ng v??o db
                    var name = $('#name').val();
                    var phone = $('#phone').val();
                    var address = $('#address').val();
                    var note = $('#note').val();
                    var payment = $("select[name='payment']").val();
                    var province_id = $('#province').val();
                    var district_id = $('#district').val();
                    var ward_id = $('#ward').val();
                    
                    pay(name,phone,province_id,district_id,ward_id,address,note,payment);
                });
            }
        }, '#paypal-button');
    }
</script>
</body>

</html>