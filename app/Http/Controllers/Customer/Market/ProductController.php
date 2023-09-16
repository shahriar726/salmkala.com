<?php

namespace App\Http\Controllers\Customer\Market;

use App\Http\Controllers\Controller;
use App\Models\Content\Comment;
use App\Models\Market\Compare;
use App\Models\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function product(Product $product)
    {
        //use ($product) chon dakhle function neveshti bayad use koni
        // hamsho get() kon be joz khodesh
        $relatedProducts = Product::with('category')->whereHas('category',function ($q) use ($product){
            $q->where('id',$product->category->id);
        })->get()->except($product->id);
        return view('customer.market.product.product', compact('product', 'relatedProducts'));
    }

    public function addComment(Product $product, Request $request)
    {
        $request->validate([
            'body' => 'required|max:2000'
        ]);
                //betonam enter ha ro dashte basham
        $inputs['body'] = str_replace(PHP_EOL, '<br/>', $request->body);
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $product->id;
        $inputs['commentable_type'] = Product::class;
        Comment::create($inputs);
        return back();
    }

    public function addToFavorite(Product $product)
    {
        if(Auth::check())
        {
            //toggle => age dashte bashe azash migire nadasht besh mide
            $product->user()->toggle([Auth::user()->id]);
            //age az qhabl boode bokon 1 agaram nadashete bokon 2
            if($product->user->contains(Auth::user()->id)){
                return response()->json(['status' => 1]);
            }
            else{
                return response()->json(['status' => 2]);
            }
        }
        else{
            return response()->json(['status' => 3]);
        }
    }
//    public function addCart(Product $product)
//    {
//        if(Auth::check())
//        {
//            //toggle => age dashte bashe azash migire nadasht besh mide
//            $product->user()->toggle([Auth::user()->id]);
//            //age az qhabl boode bokon 1 agaram nadashete bokon 2
//            if($product->user->contains(Auth::user()->id)){
//                return response()->json(['cart_status' => 1]);
//            }
//            else{
//                return response()->json(['cart_status' => 2]);
//            }
//        }
//        else{
//            return response()->json(['cart_status' => 3]);
//        }
//    }
    public function addToCompare(Product $product)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // aya list compare dare?
            if ($user->compare()->count() > 0) {
                $userCompareList = $user->compare;
            } else {
                //va in 'user_id' => $user->id barash create mikonam
                $userCompareList = Compare::create(['user_id' => $user->id]);
            }
            $product->compares()->toggle([$userCompareList->id]);
            //aya  $product ba compares qablan to list boode ya na
            if ($product->compares->contains($userCompareList->id)) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }
    }

    public function addRate(Product $product, Request $request)
    {
        $productIds = auth()->user()->isUserPurchedProduct($product->id);

        if (Auth::check() && $productIds->count() > 0) {
            $user = Auth::user();
            $user->rate($product, $request->rating);
            return back()->with('alert-section-success', 'امتیاز شما با موفقیت ثبت گردید');
        } else {
            return back()->with('alert-section-error', 'شما اجازه ثبت امتیاز ندارید - ابتدا باید محصول را خریداری نمایید');
        }
    }

    //just for api show products
    public function viewApi(){

        return view('api.products');
    }



}
