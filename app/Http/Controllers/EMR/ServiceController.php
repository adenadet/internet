<?php

namespace App\Http\Controllers\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function administrator()
    {
        $params = [
            'page_title' => 'E-Services | Administrator',
        ];
        return view('eservices')->with($params);
    }

    public function front()
    {
        $params = [
            'page_title' => 'E-Services | Front Office',
        ];
        return view('eservices')->with($params);
    }

    public function medical()
    {
        $params = [
            'page_title' => 'E-Services | Medical Officer',
        ];
        return view('eservices')->with($params);
    }

    public function radiologist()
    {
        $params = [
            'page_title' => 'E-Services | Radiologist',
        ];
        return view('eservices')->with($params);
    }
}
