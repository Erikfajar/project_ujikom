<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $dataHistory = History::with('user')->latest()->get();
        return view('history.index',compact('dataHistory'));
    }
}
