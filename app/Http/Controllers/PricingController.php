<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('max_jobs')->get();

        return view('pricing', compact('plans'));
    }
}
