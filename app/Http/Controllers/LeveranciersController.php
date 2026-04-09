<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leverancier;

class LeveranciersController extends Controller
{
    public function index()
    {
        $leveranciers = Leverancier::paginate(10);

        return view('leveranciers.index', compact('leveranciers'));
    }
}
