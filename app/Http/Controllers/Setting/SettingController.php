<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    /**
     * 设置主题
     * @param Request $request
     */
    public function setTheme(Request $request)
    {
        $this->validate($request, [
            'theme' => 'required'
        ]);

        $cookie = Cookie::make('theme', $request->theme, 10 * 12 * 30 * 24 * 60);//10年
        return Redirect::back()->withCookie($cookie);
    }
}