<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(){
        $params = [
            'page_title' => 'Tickets',
        ];
        return view('tickets')->with($params);
    }
}