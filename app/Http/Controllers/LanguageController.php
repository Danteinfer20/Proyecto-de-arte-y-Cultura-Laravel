<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        if (in_array($lang, ['en', 'es'])) {
            session()->put('locale', $lang);
            app()->setLocale($lang);
        }
        
        return redirect()->back();
    }
}