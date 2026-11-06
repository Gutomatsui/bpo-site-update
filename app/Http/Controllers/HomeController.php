<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'site' => config('site'),
            'meta' => Seo::page(path: '/'),
            'structuredData' => Seo::graph(Seo::organization(), Seo::website()),
        ]);
    }
}
