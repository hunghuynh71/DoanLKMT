<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Promotion;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\Double;

class CartController extends Controller
{
    function show()
    {
        $list_pro = Cart::content();
        foreach ($list_pro as &$item) {
            $item->options->url_detail = route('product.detail', $item->id);
        }
        return view('user.cart.show', compact('list_pro'));
    }

    function check_feeship_infoship(){
        $infoship=Session::get('infoship');
        if($infoship){
            $data['infoship']['status'] = 'exist';

            $data['infoship']['name']=$infoship['name'];            
            $data['infoship']['phone']=$infoship['phone'];
            $data['infoship']['address']=$infoship['address'];             
            $data['infoship']['note']=$infoship['note'];
            $data['infoship']['payment']=$infoship['payment'];
        }else{
            $data['infoship']['status'] = 'not_exist';
        }

        $feeship=Session::get('feeship');
        if($feeship){
            $data['feeship']['status'] = 'exist';

            $data['feeship']['html_province']=$feeship['html_province'];            
            $data['feeship']['html_district']=$feeship['html_district'];
            $data['feeship']['html_ward']=$feeship['html_ward']; 
            
            $data['feeship']['province_id']=$feeship['province_id'];
            $data['feeship']['district_id']=$feeship['district_id'];
            $data['feeship']['ward_id']=$feeship['ward_id'];
        }else{
            $data['feeship']['status'] = 'not_exist';
        }

        echo json_encode($data);
    }

    function load_district_ward_user(Request $request)
    {
        $data = $request->all();
        $select_val = $data['select_val'];
        $result = $data['result'];

        $text = $result=='district'?'qu???n/huy???n':'x??/ph?????ng/th??? tr???n';

        $html = '<option value="">-- Ch???n '.$text.' --</option>';
        if ($result == 'district') {
            $list_district = District::where('province_id', $select_val)->get();
            foreach ($list_district as $item) {
                $html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        } else if ($result == 'ward') {
            $list_ward = Ward::where('district_id', $select_val)->get();
            foreach ($list_ward as $item) {
                $html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        }

        echo $html;
    }

    function calculator_feeship(Request $request)
    {
        $data = $request->all();
        $province_id = $data['province_id'];
        $district_id = $data['district_id'];
        $ward_id = $data['ward_id'];

        $fee = 20000;
        $feeship = Feeship::where('province_id', $province_id)->where('district_id', $district_id)->where('ward_id', $ward_id)->first();
        if ($feeship)
            $fee = $feeship->fee;
        
        $result['province_id']=$province_id;
        $result['district_id']=$district_id;
        $result['ward_id']=$ward_id;
        $result['fee']=$fee;
        $result['html_province']=$data['html_province'];
        $result['html_district']=$data['html_district'];
        $result['html_ward']=$data['html_ward'];

        $result2['name']=$data['name'];
        $result2['phone']=$data['phone'];
        $result2['address']=$data['address'];
        $result2['note']=$data['note'];
        $result2['payment']=$data['payment'];

        Session::put('feeship', $result);
        Session::put('infoship', $result2);
        Session::save();
    }

    function del_promotion_code()
    {
        //tr??? l???i sl m?? khuy???n m??i
        $promotion_session = Session::get('promotion');
        if ($promotion_session) {
            $promotion = Promotion::where('code', $promotion_session[0]['code'])->first();
            $promotion->qty++;
            $promotion->save();
        }

        Session::forget('promotion');
        return redirect()->back()->with('success', 'H???y m?? gi???m gi?? th??nh c??ng');
    }

    function add($id)
    {
        $data = array();
        $product = Product::find($id);
        //Cart::destroy();
        if (Auth::check()) {
            Cart::add([
                'id' => $id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => [
                    'thumb' => $product->thumb
                ]
            ]);

            $data['html_cart'] = $this->update_html_cart();
            $data['title'] = "Th??m th??nh c??ng";
            $data['message'] = "S???n ph???m ???? ???????c th??m th??nh c??ng v??o gi??? h??ng";
            $data['status'] = 'success';
        } else {
            $data['title'] = "Th??m th???t b???i";
            $data['message'] = "Vui l??ng ????ng nh???p tr?????c khi th??m s???n ph???m v??o gi??? h??ng";
            $data['status'] = 'error';
        }


        echo json_encode($data);
    }

    function remove($rowId)
    {
        Cart::remove($rowId);

        $data['html_cart'] = $this->update_html_cart();
        $data['cart'] = $this->update_cart();

        echo json_encode($data);
    }

    function destroy()
    {
        Cart::destroy();

        //tr??? l???i sl m?? khuy???n m??i
        $promotion_session = Session::get('promotion');
        if ($promotion_session) {
            $promotion = Promotion::where('code', $promotion_session[0]['code'])->first();
            $promotion->qty++;
            $promotion->save();
        }

        Session::forget('promotion');
        Session::forget('feeship');

        $data['html_cart'] = $this->update_html_cart();

        echo json_encode($data);
    }

    function update(Request $request)
    {
        $qty = $_POST['qty'];
        $id = $_POST['id'];

        Cart::update($id, $qty);

        //l???y ?????i t?????ng trong gi??? h??ng
        $product_cart = Cart::get($id);


        $data['html_cart'] = $this->update_html_cart();
        $data['num_cart'] = "<p>C?? <strong>" . Cart::count() . "</strong> s???n ph???m trong gi??? h??ng</p>";
        $data['product_cart'] = $product_cart;
        $data['cart'] = Cart::content();
        $data['promotion'] = Session::get('promotion');

        echo json_encode($data);
    }

    function checkout()
    {
        $list_province = Province::all();
        return view('user.cart.checkout', compact('list_province'));
    }

    function pay(Request $request)
    {
        if (Cart::count() > 0) {
            $order = Order::create([
                'code' => 'DH-0' . Order::get()->max()->id + 1,
                'name' => $request->name,
                'phone' => $request->phone,
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
                'address' => $request->address,
                'note' => $request->note,
                'shipping_fee' => empty(Session::get('feeship')) ? 20000 : Session::get('feeship')['fee'],
                'payment' => $request->payment,
                'promotion_code' => !empty(Session::get('promotion')) ? Session::get('promotion')[0]['code'] : null,
                'user_id' => Auth::id()
            ]);
            // dd(Cart::content());
            foreach (Cart::content() as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'number' => $item->qty,
                    'price' => $item->price,
                    'price_cost' => Product::where('id', $item->id)->first()->price_cost
                ]);
            }

            //X??a gi??? h??ng sau khi ?????t h??ng
            Cart::destroy();

            $data['title'] = "?????t h??ng th??nh c??ng";
            $data['status'] = "success";
            $data['message'] = "????n h??ng ??ang ch??? ???????c x??? l?? v?? s??? ???????c giao ?????n b???n trong th???i gian s???m nh???t";

        } else {
            $data['title'] = "?????t h??ng th???t b???i";
            $data['status'] = "error";
            $data['message'] = "B???n ch??a ch???n mua s???n ph???m n??o. Vui l??ng ch???n s???n ph???m ????? thanh to??n!";            
        }

        //X??a m?? khuy???n m??i v?? ph?? ship
        Session::forget('promotion');
        Session::forget('feeship');
        Session::forget('infoship');

        echo json_encode($data);
    }

    function update_html_cart()
    {
        $data = "
        <div id='btn-cart'>
        <a class='text-white' href='http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/show'><i class='fa fa-shopping-cart' aria-hidden='true'></i></a>
                                    <span id='num'>" . Cart::count() . "</span>
                                </div>
                                <div id='dropdown'>
                                    <p class='desc'>C?? <span>" . Cart::count() . " s???n ph???m</span> trong gi??? h??ng</p>";
        if (Cart::count() > 0) {
            $data .= "
                                        <ul class='list-cart'>";
            foreach (Cart::content() as $product) {
                $data .= "
                                            <li class='clearfix'>
                                            <a href='' title='' class='thumb fl-left'>
                                                <img src='" . $product->options->thumb . "' alt=''>
                                            </a>
                                            <div class='info fl-right'>
                                                <a href='' title='' class='product-name'>" . $product->name . "</a>
                                                <p class='price'>" . number_format($product->price, 0, ',', '.') . "??</p>
                                                <p class='qty'>S??? l?????ng: <span>" . $product->qty . "</span></p>
                                            </div>
                                        </li>
                                            ";
            }

            $data .= "</ul>";
        }

        $data .= "<div class='total-price clearfix'>
                                    <p class='title fl-left'>T???ng:</p>
                                    <p class='price fl-right'>" . Cart::total() . "??</p>
                                </div>
                                <div class='action-cart clearfix'>
                                    <a href='http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/show' title='Gi??? h??ng' class='view-cart fl-left'>Gi??? h??ng</a>
                                    ";
        if (Cart::count() > 0) {
            $data .= "<a href='http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/checkout' title='Thanh to??n' class='checkout fl-right'>Thanh to??n</a>";
        }
        $data .= "</div>
                            </div>";

        return $data;
    }

    function update_cart()
    {
        $t = 0;
        $data = "
            <div class='section-detail table-responsive'>
                <table class='table'>
        <thead>
                        <tr>
                            <td scope='col'>STT</td>
                            <td scope='col'>???nh s???n ph???m</td>
                            <td scope='col'>T??n s???n ph???m</td>
                            <td scope='col'>Gi?? s???n ph???m</td>
                            <td scope='col'>S??? l?????ng</td>
                            <td scope='col' colspan='2'>Th??nh ti???n</td>
                        </tr>
                    </thead>
                    <tbody>";
        foreach (Cart::content() as $product) {
            $t++;
            $data .= "
                            <tr>
                            <td scope='row'>" . $t . "</td>
                            <td scope='col'>
                                <a href='' title='' class='thumb'>
                                    <img src='" . $product->options->thumb . "' alt=''>
                                </a>
                            </td>
                            <td scope='col'>
                                <a href='' title='' class='name-product'>" . $product->name . "</a>
                            </td>
                            <td scope='col'>" . number_format($product->price, 0, ',', '.') . "??</td>
                            <td scope='col'>
                                <input type='number' name='qty[" . $product->rowId . "]' min='1' data-rowId='" . $product->rowId . "' value='" . $product->qty . "' class='num-order'>
                            </td>
                            <td scope='col'>" . number_format($product->subtotal, 0, ',', '.') . "??</td>
                            <td scope='col'>
                                <a href='javacript:' title='' data-rowId='" . $product->rowId . "' class='del-product'><i class='fa fa-trash-o'></i></a>
                            </td>
                        </tr>
                            ";
        }
        $data .= "
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan='7'>
                                <div class='clearfix'>
                                    <p id='total-price' class='fl-right'>T???ng gi??: <span>" . Cart::total() . "??</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='7'>
                                <div class='clearfix'>
                                    <div class='fl-left'>
                                        <a href='http://localhost:8080/DoanLKMT/doanwebtmdt/' title='' id='buy-more'>Mua ti???p</a>
                                        <a href='javacript:' id='destroy-cart' title=''>X??a t???t c??? gi??? h??ng</a>
                                    </div>
                                    <div class='fl-right'>
                                        <a href='http://localhost:8080/DoanLKMT/doanwebtmdt/user/cart/checkout' title='' id='checkout-cart'>Thanh to??n</a>                                        
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                    </table>
            </div>
                    ";
        return $data;
    }
}
