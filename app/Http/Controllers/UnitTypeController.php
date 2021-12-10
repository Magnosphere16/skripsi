<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitType;
use DB;

class UnitTypeController extends Controller
{
    public function index(Request $request){
        return UnitType::all();
    }
}
