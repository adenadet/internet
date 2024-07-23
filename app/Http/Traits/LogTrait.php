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
            case 'leave_request_reject':
                LogActivity::create([
                    'subject' => auth('api')->user()->first_name.' '.auth('api')->user()->last_name. ($status ? ' has successfully ' : 'unsuccessfully ').'rejected a leave request with ID: '.$item_id,
                    'url' => 'Reject Leave Request',
                    'method' => 'Leave', 
                    'ip' => \Illuminate\Support\Facades\Request::ip(), 
                    'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                    'user_id' => auth('api')->id(),
                ]);
                break;
            case 'leave_type_create':
                LogActivity::create([
                    'subject' => auth('api')->user()->first_name.' '.auth('api')->user()->last_name. ($status ? ' has successfully created a leave type with ID: '.$item_id : 'unsuccessfully tried to create a leave type'),
                    'url' => 'Create Leave Request',
                    'method' => 'Leave Type', 
                    'ip' => \Illuminate\Support\Facades\Request::ip(), 
                    'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                    'user_id' => auth('api')->id(),
                ]);
                break;
            case 'leave_type_delete':
                LogActivity::create([
                    'subject' => auth('api')->user()->first_name.' '.auth('api')->user()->last_name. ($status ? ' has successfully deleted' : 'unsuccessfully tried to delete').' a leave type with ID: '.$item_id,
                    'url' => 'Delete Leave Request',
                    'method' => 'Leave Type', 
                    'ip' => \Illuminate\Support\Facades\Request::ip(), 
                    'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                    'user_id' => auth('api')->id(),
                ]);
            break;
            case 'leave_type_update':
                LogActivity::create([
                    'subject' => auth('api')->user()->first_name.' '.auth('api')->user()->last_name. ($status ? ' has successfully ' : 'unsuccessfully ').'updated a leave type with ID: '.$item_id,
                    'url' => 'Update Leave Request',
                    'method' => 'Leave Type', 
                    'ip' => \Illuminate\Support\Facades\Request::ip(), 
                    'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                    'user_id' => auth('api')->id(),
                ]);
            break;
            default:
        }
    }
}