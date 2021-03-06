<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Gloudemans\Shoppingcart\Facades\Cart;
use HasFactory;

class ProductCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['mod_active' => 'product_category']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $key = $request->input('key');

        $status = $request->input('status');

        $list_product_category = ProductCategory::where('name', 'like', "%{$key}%")->orderByDesc('id')->paginate(5);

        $list_action = array(
            'trash' => 'Xóa tạm thời'
        );

        if ($status == 'trash') {
            $list_action = array(
                'active' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            );
            $list_product_category = ProductCategory::onlyTrashed()->where('name', 'like', "%{$key}%")->orderByDesc('id')->paginate(5);
        }

        $count = array(

            'trash' => ProductCategory::onlyTrashed()->count(),
            'active' => ProductCategory::count()
        );

        return view('admin.product_category.index', compact('list_product_category', 'count', 'list_action'));
    }

    public function add()
    {
        return view('admin.product_category.add');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|min:5|max:50|regex:/^([A-Za-zÁÀẢÃẠÂẤẦẨẪẬĂẮẰẲẴẶĐÉÈẺẼẸÊẾỀỂỄỆÍÌỈĨỊÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÚÙỦŨỤƯỨỪỬỮỰYÝỲỶỸỴáàảãạâấầẩẫậăắằẳẵặđéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵ\s]+){1,3}$/',
            ],
            [
                'name.regex' => 'Họ tên phải có định dạng là chữ cái hoặc khoảng trắng',
                'code.regex' => 'code phải có định dạng là chữ cái hoặc khoảng trắng',
                'unique' => ' :attribute không được trùng',
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài tối thiểu là :min',
                'max' => ':attribute có độ dài tối đa là :max',
            ],
            [
                'name' => 'Tên loại sản phẩm',
                'code' => 'Mã loại sản phẩm',
            ]
        );

        $product_category = new ProductCategory;
        $product_category->name = $request->name;
        $product_category->code = Str::slug($request->name);
        $product_category->description = $request->description;
        $product_category->user_id = Auth::user()->id;
        $product_category->save();
        return redirect('admin/product_category/index')->with('success', 'Thêm loại sản phẩm thành công. Click <a class=\"text-primary\" href=\"{$route_detail}\">vào đây</a> để xem chi tiết!"');
    }

    public function postedit(Request $request, $id)
    {
        $product_category = ProductCategory::find($id);
        $this->validate(
            $request,
            [
                'name' => 'required|min:5|max:50|regex:/^([A-Za-zÁÀẢÃẠÂẤẦẨẪẬĂẮẰẲẴẶĐÉÈẺẼẸÊẾỀỂỄỆÍÌỈĨỊÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÚÙỦŨỤƯỨỪỬỮỰYÝỲỶỸỴáàảãạâấầẩẫậăắằẳẵặđéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵ\s]+){1,3}$/',
            ],
            [
                'name.regex' => 'Loại sản phẩm phải có định dạng là chữ cái hoặc khoảng trắng',
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài tối thiểu là :min',
                'max' => ':attribute có độ dài tối đa là :max',
            ]
        );

        ProductCategory::where('id', $id)->update([
            'name' => $request->input('name'),
            'code' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'user_id' => Auth::id()
        ]);

        $status = $request->input('status');

        if ($status == 'trash') {
            return redirect(route('admin.product_category.index', ['status' => 'trash']))->with('success', 'Cập nhật loại sản phẩm thành công');
        } else {
            return redirect(route('admin.product_category.index'))->with('success', 'Cập nhật loại sản phẩm thành công. Click <a class=\"text-primary\" href=\"{$route_detail}\">vào đây</a> để xem chi tiết!"');
        }
    }

    public function getedit($id)
    {
        $product_category = ProductCategory::withTrashed()->find($id);
        return view('admin.product_category.edit', ['product_category' => $product_category]);
    }

    function detail($id)
    {
        $product_category = ProductCategory::withTrashed()->find($id);
        return view('admin.product_category.detail', compact('product_category'));
    }

    public function deletecategory(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status == 'trash') {
            ProductCategory::onlyTrashed()->find($id)->forceDelete();
            return redirect(route('admin.product_category.index', ['status' => 'trash', 'page' => 1]))->with('success', 'Xóa vĩnh viễn sản phẩm thành công');
        } else {
            //xóa tất cả sp thuộc loại sp đã xóa (nếu có)
            $this->del_list_pro_in_cate($id);

            ProductCategory::destroy($id);            

            return redirect(route('admin.product_category.index', ['status' => 'trash', 'page' => 1]))->with('success', 'Xóa sản phẩmthành công');
        }
    }

    function del_list_pro_in_cate($id){
        $list_pro_in_cate = Product::where('product_category_id',$id)->get();

        foreach($list_pro_in_cate as $item){
            //xóa sản phẩm trong giỏ hàng (nếu có)
            $this->delete_product_in_cart($item->id);

            //xóa sp trong db
            Product::destroy($item->id);
        }
    }

    function delete_product_in_cart($id){
        foreach(Cart::content() as &$item){
            if($item->id==$id){
                Cart::remove($item->rowId);
            }
        }
    }

    public function action(Request $request)
    {
        $list_product_category_id = $request->input('list_product_category_id');
        
        if ($list_product_category_id) {

            $action = $request->input('action');
            if ($action == 'trash') {
                ProductCategory::destroy($list_product_category_id);

                return redirect(route('admin.product_category.index'))->with('success', 'Xóa thành công loại sản phẩm');
            }
            if ($action == 'active') {
                ProductCategory::onlyTrashed()->whereIn('id', $list_product_category_id)->restore();
                return redirect(route('admin.product_category.index', ['status' => 'trash']))->with('success', 'Khôi phục loại sản phẩm thành công');
            }
            if ($action == 'forceDelete') {
                ProductCategory::onlyTrashed()->whereIn('id', $list_product_category_id)->forceDelete();
                return redirect(route('admin.product_category.index'))->with('success', 'Xóa vĩnh viễn loại sản phẩm thành công');
            }
            return redirect(route('admin.product_category.index'))->with('error', 'Bạn chưa chọn hành động nào');
        } else {
            return redirect(route('admin.product_category.index'))->with('error', 'Bạn chưa chọn loại sản phẩm nào ');
        }
    }
}
