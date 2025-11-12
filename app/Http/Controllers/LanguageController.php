<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        if (in_array($lang, ['en', 'ar'])) {
            if (Auth::check()) {
                $user = Auth::user();
                $user->preferred_language = $lang;
                $user->save();
            }

            session()->put('locale', $lang);
        }

        return redirect()->back();
    }
}
