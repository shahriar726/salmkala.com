<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Content\banner;
use App\Models\Content\Page;
use App\Models\Market\Brand;
use App\Models\Market\Product;
use App\Models\Market\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        //position banner
        $slideShowImages = Banner::where('position', 0)->where('status', 1)->get();
        $topBanners = Banner::where('position', 1)->where('status', 1)->take(2)->get();
        $middleBanners = Banner::where('position', 2)->where('status', 1)->take(2)->get();
        $bottomBanner = Banner::where('position', 3)->where('status', 1)->first();
        //brand
        $brands = Brand::all();
        //most views
        $mostVisitedProducts = Product::latest()->take(10)->get();
        $offerProducts = Product::latest()->take(10)->get();
        return view('customer.home', compact('slideShowImages', 'topBanners', 'middleBanners', 'bottomBanner', 'brands', 'mostVisitedProducts', 'offerProducts'));

    }
    //onaii ke shabieh hastan ra biar
    //aval akharesh mohem nist chi bashe  mohem oon kalameii ke search karde vojood dashte bahse
    //$product ro be $query tabdil kardam ke sort ra yebar anjam bedam
    public function products(Request $request, ProductCategory $category = null)
    {
        //get brands
        $brands = Brand::all();
        //category selection
        if ($category)
            //bro be model product
            $productModel = $category->products();
        else
            // hamesho show kon
            $productModel = new Product();
        //get categories
        $categories = ProductCategory::whereNull('parent_id')->get();
        //switch for set sort for filtering
        switch ($request->sort) {
            case "1":
                $column = "created_at";
                $direction = "DESC";
                break;
            case "2":
                $column = "price";
                $direction = "DESC";
                break;
            case "3":
                $column = "price";
                $direction = "ASC";
                break;
            case "4":
                $column = "view";
                $direction = "DESC";
                break;
            case "5":
                $column = "sold_number";
                $direction = "DESC";
                break;
            default:
                $column = "created_at";
                $direction = "ASC";
        }
        if ($request->search) {
            $query = $productModel->where('name', 'LIKE', "%" . $request->search . "%")->orderBy($column, $direction);
        } else {
            $query = $productModel->orderBy($column, $direction);
        }
        //ham zaman har dotasho check kone  edame $query ro benevis $query->whereBetween('price', [$request->min_price, $request->max_price])
        $products = $request->max_price && $request->min_price ? $query->whereBetween('price', [$request->min_price, $request->max_price]) :
            $query->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price)->get();
            })->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price)->get();
            })->when(!($request->min_price && $request->max_price), function ($query) {
                $query->get();
            });
        $products = $products->when($request->brands, function () use ($request, $products) {
            //hame product haii ro mide ke brand id ro $request->brands => id brande
            // va brand_id=> id product vase berande gerfti
            $products->whereIn('brand_id', $request->brands);
        });
        $products = $products->paginate(10);
        //bia to hame page ha behesh ezafe kon filter ro
        $products->appends($request->query());
        //get selected brands
        $selectedBrandsArray = [];
        if($request->brands)
        {
            $selectedBrands = Brand::find($request->brands);
            foreach($selectedBrands as $selectedBrand)
            {
                array_push($selectedBrandsArray, $selectedBrand->original_name);
            }
        }
        return view('customer.market.product.products', compact('products','brands','selectedBrandsArray','categories'));
    }


    //page
    public function page(Page $page)
    {
        $about_banners = Banner::where('position', 4)->where('status', 1)->take(2)->get();
        return view('customer.page', compact('page','about_banners'));
    }
    //header
//    public function Menu(ProductCategory $category = null){
//
//        //get categories
//        $categories = ProductCategory::whereNull('parent_id')->get();
//
//        return view('customer.layouts.header', compact('categories','category'));
//    }
    public function contactUs()
    {
        return view('customer.contact-us');
    }
}
