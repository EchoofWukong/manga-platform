<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // En çok okunan serileri, türleri ve bölümleriyle birlikte çekiyoruz
        $series = Series::with(['genres', 'chapters'])->orderBy('views', 'desc')->get();
        
        return view('home', compact('series'));
    }
    public function seriler()
    {
        // Tüm serileri en yeniye göre sırala
        $series = Series::with(['genres', 'chapters'])->orderBy('created_at', 'desc')->get();
        return view('seriler', compact('series'));
    }

    public function trendler()
    {
        // Trendler için en çok okunanları (views) baz alıyoruz
        $series = Series::with(['genres', 'chapters'])->orderBy('views', 'desc')->get();
        return view('trendler', compact('series'));
    }
}