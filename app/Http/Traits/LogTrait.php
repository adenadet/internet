<?php
namespace App\Http\Traits;

use App\Http\Traits\FileManagementTrait;
use App\Models\User\LogActivity;

trait LogTrait{
    public function log_user_activity($type, $item_id, $status){
        switch ($type){
            case 'leave_request_confirm':
                LogActivity::create([
                    'subject' => auth('api')->user()->first_name.' '.auth('api')->user()->last_name. ($status ? ' has successfully ' : 'unsuccessfully ').'confirmed a leave request with ID: '.$item_id,
                    'url' => 'Confirm Leave Request',
                    'method' => 'Leave', 
                    'ip' => \Illuminate\Support\Facades\Request::ip(), 
                    'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                    'user_id' => auth('api')->id(),
                ]);
                break;
            case 'leave_request_new':
                LogActivity::create([
                    'subject' => auth('api')->user()->first_name.' '.auth('api')->user()->last_name. ($status ? ' has successfully ' : 'unsuccessfully ').'applied for leave request'.($status ? 'with ID: '.$item_id : ''),
                    'url' => 'New Leave Request',
                    'method' => 'Leave', 
                    'ip' => \Illuminate\Support\Facades\Request::ip(), 
                    'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                    'user_id' => auth('api')->id(),
                ]);
                break;
            
        }
    }
}