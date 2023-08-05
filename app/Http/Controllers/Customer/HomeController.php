<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Content\Banner;
use App\Models\Content\Menu;
use App\Models\Market\Brand;
use App\Models\Market\Product;
use App\Models\Market\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        Auth::loginUsingId(7);
        $slideShowImages = Banner::where('position', 0)->where('status', 1)->get();
        $topBanners = Banner::where('position', 1)->where('status', 1)->take(2)->get();
        $middleBanners = Banner::where('position', 2)->where('status', 1)->take(2)->get();
        $bottomBanner = Banner::where('position', 3)->where('status', 1)->first();
        $brands = Brand::all();
        $mostVisitedProducts = Product::latest()->take(10)->get();
        $offerProducts = Product::latest()->take(10)->get();
        return view('customer.home', compact('slideShowImages', 'topBanners', 'middleBanners', 'bottomBanner', 'brands', 'mostVisitedProducts', 'offerProducts'));

    }

    public function products(Request $request, ProductCategory $category = null)
    {
        //get Brands
        $brands = Brand::all();

        //category Selection
        if ($category)
            $productModal = $category->products();
        else
            $productModal = new Product();

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
            $query =$productModal->where('name', "LIKE", "%" . $request->search . "%")->orderBy($column, $direction);
        } else {
            $query = $productModal->orderBy($column, $direction);
        }
        $products = $request->min_price && $request->max_price ? $query->whereBetween('price', [$request->min_price, $request->max_price]) :
            $query->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price)->get();
            })->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price)->get();
            })->when(!($request->min_price && $request->max_price), function ($query) {
                $query->get();
            });
        $products = $products->when($request->brands, function () use ($request, $products) {
            $products->whereIn('brand_id', $request->brands);
        });
        $products = $products->paginate(5);

        //get selected brands
        $selectedBrandsArray = [];
        if ($request->brands) {
            $selectedBrands = Brand::query()->find($request->brands);
            foreach ($selectedBrands as $selectedBrand) {
                array_push($selectedBrandsArray, $selectedBrand->original_name);
            }
        }
        return view('customer.market.product.products', compact('products', 'brands', 'selectedBrandsArray', 'categories'));
    }
}
