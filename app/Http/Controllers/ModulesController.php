<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModulesController extends Controller
{
    public function chats()
    {
        $params = [
            'page_title' => 'Chats',
        ];
        return view('chats')->with($params);
    }

    public function contacts()
    {
        $params = [
            'page_title' => 'Contacts',
        ];
        return view('internet')->with($params);
    }

    public function dashboard()
    {
        $params = [
            'page_title' => 'Dashboard',
        ];
        return view('internet')->with($params);
    }

    public function departments()
    {
        $params = [
            'page_title' => 'Departments',
        ];
        return view('internet')->with($params);
    }

    public function internet()
    {
        $params = [
            'page_title' => 'Internet',
        ];
        return view('internet')->with($params);
    }

    public function notices()
    {
        $params = ['page_title' => 'Notice Board',];
        return view('notices')->with($params);
    }

    public function policies()
    {
        $params = [
            'page_title' => 'Policies',
        ];
        return view('policies')->with($params);
    }

    public function profile()
    {
        $params = [
            'page_title' => 'Profile',
        ];
        return view('profile')->with($params);
    }

    public function settings()
    {
        $params = [
            'page_title' => 'Settings',
        ];
        return view('settings')->with($params);
    }

    public function staff_month()
    {
        $params = [
            'page_title' => 'Staff of the Month',
        ];
        return view('som')->with($params);
    }

    public function ticketing()
    {
        $params = [
            'page_title' => 'Tickets',
        ];
        return view('tickets')->with($params);
    }

    public function users()
    {
        $params = [
            'page_title' => 'Users',
        ];
        return view('users')->with($params);
    }
}
