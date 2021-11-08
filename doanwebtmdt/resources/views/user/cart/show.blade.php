@extends('layout.home')

@section('content')
<div id="main-content-wp" class="cart-page">
    <!-- <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Sản phẩm làm đẹp da</a>
                    </li>
                </ul>
            </div>
        </div>
    </div> -->
    <div id="wrapper" class="wp-inner clearfix">
        <h1>Giỏ hàng</h1>
        <p id="cart-qty">Có <strong>{{Cart::count()}}</strong> sản phẩm trong giỏ hàng</p>
        @if(Cart::count()>0)
        @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
        @endif
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td scope="col">STT</td>
                            <td scope="col">Ảnh sản phẩm</td>
                            <td scope="col">Tên sản phẩm</td>
                            <td scope="col">Giá sản phẩm</td>
                            <td scope="col">Số lượng</td>
                            <td scope="col" colspan="2">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>

                        @php $t=0; @endphp
                        @foreach($list_pro as $product)
                        @php $t++; @endphp
                        <tr>
                            <td scope="row">{{$t}}</td>
                            <td scope="col">
                                <a href="" title="" class="thumb">
                                    <img src="{{$product->options->thumb}}" alt="">
                                </a>
                            </td>
                            <td scope="col">
                                <a href="{{$product->options->url_detail}}" title="" class="name-product">{{$product->name}}</a>
                            </td>
                            <td scope="col">{{number_format($product->price,0,',','.')}}đ</td>
                            <td scope="col">
                                <input type="number" name="qty[{{$product->rowId}}]" min='1' data-rowId="{{$product->rowId}}" value="{{$product->qty}}" class="num-order">
                            </td>
                            <td scope="col" class="subtotal-{{$product->rowId}}">{{number_format($product->subtotal,0,',','.')}}đ</td>
                            <td scope="col">
                                <a href="javacript:" title="" data-rowId="{{$product->rowId}}" class="del-product"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                <div class="fl-left">
                                        <form action="{{route('promotion.process')}}" method="post" class="form-promotion_code">
                                            @csrf 
                                            <label for="promotion_code">Nhập mã khuyến mãi:</label>
                                            <input type="text" name="promotion_code" id="promotion_code" class="">
                                            <input type="submit" name="btn-promotion-code" value="Sử dụng"  class="btn btn-warning">                                            
                                        </form>
                                    </div>
                                    <div class="fl-right">  
                                        @php 
                                        //Session::remove('promotion');
                                        $total = filter_var(Cart::total(),FILTER_SANITIZE_NUMBER_INT);
                                        $promotion = Session::get('promotion');
                                        //dd($promotion);
                                        
                                        @endphp  
                                        @if($promotion)   
                                        @foreach($promotion as $pro)
                                        @if($pro['condition']==1)
                                        <p id="total-price">Tổng sau khi giảm: <span id="total_after_promotion">{{number_format($total-($total*$pro['number']/100),0,',','.')}}đ</span></p>
                                        <p>Tổng hóa đơn: <span id="total"><?php echo Cart::total(); ?>đ</span></p>
                                        <p>Giảm giá: <span>{{$pro['number']}}%</span></p>
                                        <p>Số tiền giảm: <span id="money_promotion">{{number_format($total*$pro['number']/100,0,',','.')}}đ</span></p>                                        
                                        @elseif($pro['condition']==2)
                                        <p id="total-price">Tổng sau khi giảm: <span id="total_after_promotion">{{number_format($total-$pro['number'],0,',','.')}}đ</span></p>
                                        <p>Tổng hóa đơn: <span id="total"><?php echo Cart::total(); ?>đ</span></p>
                                        <p>Giảm giá: <span>{{number_format($pro['number'],0,',','.')}}đ</span></p>                                        
                                        @endif                                        
                                        @endforeach 
                                        @else
                                        <p id="total-price">Tổng hóa đơn: <span><?php echo Cart::total(); ?>đ</span></p>                                       
                                        @endif
                                    </div>                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <div class="fl-left">
                                        <a href="{{route('home')}}" title="" id="buy-more">Mua tiếp</a>
                                        <a href="javacript:" title="" id="destroy-cart">Xóa tất cả</a>
                                    </div>
                                    <div class="fl-right">
                                        <a href="{{route('cart.checkout')}}" title="" id="checkout-cart">Thanh toán</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <!-- <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.</p> -->
            </div>
        </div>
        @endif
    </div>
</div>
@endsection