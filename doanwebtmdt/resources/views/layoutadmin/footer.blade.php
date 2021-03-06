</div>
</div>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{asset('admin/js/app.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{url('/public/admin/js/simple.money.format.js')}}"></script>
<script src="{{url('/public/admin/js/jquery.validate.js')}}"></script>

<!-- validate -->
<script>
    $(function(){
        // form add product 
        $('#add-product').validate({
            rules: {
                inventory_num: "required",
                warranty: "required",
                detail_desc: "required",
                brand_id: "required",
                product_category_id: "required",
                old_price: "required",
                name: {
                    required: true,
                    minlength: 5,
                    maxlength: 200
                },                
                short_desc: {
                    required: true,
                    minlength: 5,
                    maxlength: 300
                },
                thumb: {
                    required: true,
                    image: true,
                    maxlength: 20480
                },
                price: {
                    required: true,
                },                
                price_cost: {
                    required: true,
                },                
            },
            messages: {
                brand_id: "B???n ch??a ch???n th????ng hi???u",
                product_category_id: "B???n ch??a ch???n lo???i s???n ph???m",
                warranty: "B???n ch??a nh???p th???i gian b???o h??nh s???n ph???m",
                detail_desc: "B???n ch??a nh???p m?? t??? chi ti???t s???n ph???m",
                name: {
                    required: "B???n ch??a nh???p t??n s???n ph???m",
                    minlength: jQuery.validator.format("T??n s???n ph???m ph???i t???i ti???u t??? {0} k?? t???!"),
                    maxlength: jQuery.validator.format("T??n s???n ph???m ch??? t???i ??a l?? {0} k?? t???!")
                },                
                short_desc: {
                    required: "B???n ch??a nh???p m?? t??? ng???n s???n ph???m",
                    minlength: jQuery.validator.format("M?? t??? ng???n s???n ph???m ph???i t???i ti???u t??? {0} k?? t???!"),
                    maxlength: jQuery.validator.format("M?? t??? ng???n s???n ph???m ch??? t???i ??a l?? {0} k?? t???!")
                },
                thumb: {
                    required: "B???n ch??a ch???n h??nh ???nh s???n ph???m",
                    image: "H??nh ???nh ch??a ????ng ?????nh d???ng",
                    maxlength: jQuery.validator.format("H??nh ???nh c?? dung l?????ng t???i ??a l?? {0}kb!")
                },
                price: {
                    required: "B???n ch??a nh???p gi?? b??n s???n ph???m",
                },
                old_price: {
                    required: "B???n ch??a nh???p gi?? c?? s???n ph???m",
                },
                price_cost: {
                    required: "B???n ch??a nh???p gi?? g???c s???n ph???m",
                },
                inventory_num: {
                    required: "B???n ch??a nh???p s??? l?????ng t???n s???n ph???m",
                },                
            }
        });
    })
</script>

<script>
    $(function() {
        load_feeship();

        function load_feeship() {
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{route('admin.delivery.load_feeship')}}",
                method: "post",
                dataType: "html",
                data: {
                    _token: _token,
                },
                success: function(data) {
                    $('#list_feeship').html(data);
                },
                // error: function(xhr, ajaxOptions, thrownError) {
                //     alert('L???i: ' + xhr.status + ' - ' + thrownError)
                // }
            })
        }

        //load huy???n theo t???nh, x?? theo huy???n (v???n chuy???n)
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
                url: "{{route('admin.delivery.load_district_ward')}}",
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

        //k??ch ho???t ph???n nh???p gi?? tr??? h??a ????n t???i thi???u
        load_min_total_order();

        function load_min_total_order() {
            var condition = $('#condition').val();
            if (condition == 1) {
                $('#min_total_order').val('');
                $('#min_total_order').attr('disabled', 'disabled');
            } else if (condition == 2) {
                $('#min_total_order').removeAttr('disabled');
                //$('#number').addClass('money');
                //$('#min_total_order').addClass('money');
            }
        }

        //r??ng bu???c gi?? tr??? khuy???n m??i promotion/edit 
        $('#condition').on('change', function() {
            var condition = $(this).val()
            var value = $('#number').val()
            var min_total_order = $('#min_total_order').val();

            if (condition == 2) {
                $('#min_total_order').removeAttr('disabled');
                //$('#number').addClass('money');
            } else if (condition == 1) {
                $('#min_total_order').val('');
                $('#min_total_order').attr('disabled', 'disabled');

                if (value > 100) {
                    //tr??? l???i gi???m theo ti???n
                    alert('Gi?? tr??? gi???m kh??ng ???????c l???n h??n 100%');
                    $(this).val(2);
                    $('#min_total_order').removeAttr('disabled');
                    $('#min_total_order').val(min_total_order);
                }
            }
        })

        $('#number').on('change', function() {
            var condition = $('#condition').val();
            var value = $(this).val();
            if (condition == 1 && value > 100) {
                alert('Gi?? tr??? gi???m kh??ng ???????c l???n h??n 100%');
                $(this).val('');
            }
        })

        //c???p nh???t ph?? v???n chuy???n
        $(document).on('blur', 'td.edit_feeship', function() {
            var _token = $('input[name="_token"]').val();
            var id = $(this).data('id');
            var fee = $(this).text();

            $.ajax({
                url: "{{route('admin.delivery.edit_feeship')}}",
                method: "post",
                dataType: "html",
                data: {
                    _token: _token,
                    id: id,
                    fee: fee
                },
                success: function(data) {
                    alert('C???p nh???t ph?? v???n chuy???n th??nh c??ng');
                },
                // error: function(xhr, ajaxOptions,thrownError){
                //     alert('L???i: '+xhr.status+' - '+thrownError)
                // }
            })
        })

        //th??m ph?? v???n chuy???n
        $('#add-feeship').on('click', function() {
            var _token = $('input[name="_token"]').val();
            var province_id = $('select#province').val();
            var district_id = $('select#district').val();
            var ward_id = $('select#ward').val();
            var fee = $('input#fee').val();

            if (province_id == '') {
                alert('T???nh/th??nh ph??? kh??ng ???????c ????? tr???ng!')
            } else if (district_id == '') {
                alert('Qu???n/huy???n kh??ng ???????c ????? tr???ng!')
            } else if (ward_id == '') {
                alert('X??/ph?????ng kh??ng ???????c ????? tr???ng!')
            } else if (fee == '') {
                alert('Ph?? v???n chuy???n kh??ng ???????c ????? tr???ng!')
            } else if (check_number(fee)==false) {
                alert('Ph?? v???n chuy???n ph???i ch???a s???!')
            } else {
                $.ajax({
                    url: "{{route('admin.delivery.add_feeship')}}",
                    method: "post",
                    dataType: "json",
                    data: {
                        _token: _token,
                        province_id: province_id,
                        district_id: district_id,
                        ward_id: ward_id,
                        fee: fee,
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            alert(data.message);
                            load_feeship();
                        } else {
                            alert(data.message);
                        }
                        //console.log(data)
                    },
                    // error: function(xhr, ajaxOptions,thrownError){
                    //     alert('L???i: '+xhr.status+' - '+thrownError)
                    // }
                })
            }
        })

        function check_number(item){
            //l???c k?? t??? ch??? c??i
            var strInput = item.replace(/\D/g, ''); 
            //kt xem c?? ph???i l?? s???
            var result = $.isNumeric(strInput);
            return result;
        }

        $('.money').simpleMoneyFormat();

        chart30day();

        $("#datepicker").datepicker({
            prevText: "Th??ng tr?????c",
            nextText: "Th??ng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: ["Th??? 2", "Th??? 3", "Th??? 4", "Th??? 5", "Th??? 6", "Th??? 7", "Ch??? nh???t"],
            duration: "slow"
        });

        $("#datepicker2").datepicker({
            prevText: "Th??ng tr?????c",
            nextText: "Th??ng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: ["Th??? 2", "Th??? 3", "Th??? 4", "Th??? 5", "Th??? 6", "Th??? 7", "Ch??? nh???t"],
            duration: "slow"
        });

        //Hi???n th??? bi???u ????? doanh thu
        var chart = new Morris.Area({
            // ID of the element in which to draw the chart.
            element: 'chart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.

            //Options
            parseTime: false,
            lineColors: ['#fa41a4', '#419efa', '#e09916', '#16c423'],
            pointFillColors: ['#c60404'],
            pointStrokeColors: ['#88836E'],
            fillOpacity: 0.2,
            hideHover: 'auto',

            // The name of the data record attribute that contains x-values.
            xkey: 'period',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['sales', 'profit', 'quantity', 'order'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Doanh thu', 'L???i nhu???n', 'T???ng s???n ph???m', 'T???ng ????n h??ng']
        });

        //Th???ng k?? t??? ?????ng 30 ng??y 
        function chart30day() {
            var _token = $("input[name='_token']").val()
            $.ajax({
                url: "{{url('/admin/statistical_30day')}}",
                method: "post",
                dataType: "json",
                data: {
                    _token: _token
                },
                success: function(data) {
                    chart.setData(data);
                    console.log(data)
                },
                // error: function(xhr, ajaxOptions, thrownError) {
                //     alert('L???i: '+xhr.status+' - '+thrownError);
                // }
            })
        }


        //L???c th???ng k?? theo l???a ch???n
        $("#statistical_fillter").change(function() {
            $('#datepicker').val('');
            $('#datepicker2').val('');

            var _token = $("input[name='_token']").val()
            var select = $(this).val();

            $.ajax({
                url: "{{url('/admin/fillter_by_select')}}",
                method: "post",
                dataType: "json",
                data: {
                    select: select,
                    _token: _token
                },
                success: function(data) {
                    chart.setData(data);
                    //console.log(data)
                },
                // error: function(xhr, ajaxOptions, thrownError) {
                //     alert('L???i: '+xhr.status+' - '+thrownError);
                // }
            })
        })

        //L???c th???ng k?? theo ng??y
        $("#btn-dashboard-fillter").click(function() {
            var _token = $("input[name='_token']").val()
            var from_date = $("#datepicker").val();
            var to_date = $("#datepicker2").val();

            if (!from_date) {
                alert('B???n ch??a ch???n ng??y b???t ?????u')
            } else if (!to_date) {
                alert('B???n ch??a ch???n ng??y k???t th??c')
            } else if (from_date > to_date) {
                alert('Ng??y k???t th??c ph???i sau ng??y b???t ?????u')
            } else {
                $.ajax({
                    url: "{{url('/admin/fillter_by_date')}}",
                    method: "post",
                    dataType: "json",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        _token: _token
                    },
                    success: function(data) {
                        chart.setData(data);
                        //console.log(data)
                    },
                    // error: function(xhr, ajaxOptions, thrownError) {
                    //     alert('L???i: '+xhr.status+' - '+thrownError);
                    // }
                })
            }
        })
    });
</script>
<!-- Khai b??o tr??nh so???n th???o b??i vi???t  -->
<script>
    var editor_config = {
        //???????ng d???n ?????n file x??? l??
        path_absolute: "{{url('')}}",
        selector: 'textarea.form-editor',
        relative_urls: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback: function(callback, value, meta) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    };

    tinymce.init(editor_config);
</script>
</body>

</html>