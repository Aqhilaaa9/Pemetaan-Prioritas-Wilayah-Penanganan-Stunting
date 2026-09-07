<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
{
    public function index()
    {
        $puskesmas = Puskesmas::with('kabupaten')->get();

        return view('puskesmas.index', compact('puskesmas'));
    }
}