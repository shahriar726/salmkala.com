<?php

namespace App\Providers;

use App\Models\Content\Comment;
use App\Models\Content\Menu;
use App\Models\Content\Page;
use App\Models\Market\CartItem;
use App\Models\Market\ProductCategory;
use App\Models\Notification;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::loginUsingId(1);
        //with('unseenComments) => har nami ke khasti bbari ra benevis hamoon compact ast
        view()->composer('admin.layouts.header',function ($view){

            $view->with('unseenComments',Comment::where('seen',0)->get());
            $view->with('notifications',Notification::where('read_at',null)->get());
        });

            view()->composer('customer.layouts.header',function ($view){
                if(Auth::check()) {
                $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
                $view->with('cartItems',$cartItems);
                }
            });
        view()->composer('customer.layouts.header',function ($view){
                $Page = Page::where('status', 1)->first();
                $view->with('Page',$Page);
        });
        view()->composer('customer.layouts.header',function ($view){
            $categories = ProductCategory::whereNull('parent_id')->get();
            $view->with('categories',$categories);
        });
        view()->composer('customer.layouts.header',function ($view){
            $Menus = Menu::where('status',1)->get();
            $view->with('menus',$Menus);
        });
        view()->composer('customer.layouts.header',function ($view){
            $setting = Setting::whereId(1)->first();
            $view->with('setting',$setting);
        });
    }
}
