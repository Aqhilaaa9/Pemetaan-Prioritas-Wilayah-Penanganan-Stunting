<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use Illuminate\Http\Request;

class KabupatenController extends Controller
{
    public function index()
    {
        $kabupaten = Kabupaten::all();

        return view('kabupaten.index', compact('kabupaten'));
    }
}