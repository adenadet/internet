<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notice;
use App\Models\NoticePicture;

class NoticeController extends Controller
{
    public function index()
    {
        return response()->json(['notices' => Notice::with('creator')->orderBy('created_at', 'DESC')->paginate(10),]);
    }

    public function modify(Request $request)
    {
        $data = json_decode($request->data);

        $upload_path = "upload/notices";
        if((is_null($request->file)) || ($request->file == "")){$file_type = null; $fileName = null;}
        
        else{$fileName = time().'.'.$request->file->getClientOriginalExtension(); $request->file->move(public_path($upload_path), $fileName);}

        $notice = Notice::find($data->id);
        $notice->user_id = auth('api')->id();
        $notice->content =  $data->content;
        $notice->topic =  $data->topic;
        $notice->start_date = $data->start_date;
        $notice->end_date = $data->end_date;
        $notice->image = $fileName;

        $notice->save();
        

        return response()->json([
            'notices' => Notice::where('department_id', '=', 0)->orWhere('department_id', '=', auth('api')->user()->department_id)->andWhere('start_date', '>=', date('Y-m-d'))->orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->data);

        $upload_path = "upload/notices";
        if((is_null($request->file)) || ($request->file == "")){$file_type = null; $fileName = null;}
        
        else{$fileName = time().'.'.$request->file->getClientOriginalExtension(); $request->file->move(public_path($upload_path), $fileName);}

        $notice = Notice::create([
            'user_id' => auth('api')->id(),
            'content' =>  $data->content,
            'topic' =>  $data->topic,
            'start_date' => $data->start_date,
            'end_date' => $data->end_date,
        ]);

        return response()->json([
            'notices' => Notice::where('department_id', '=', 0)->orWhere('department_id', '=', auth('api')->user()->department_id)->where('start_date', '>=', date('Y-m-d'))->get(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'notice' => Notice::where('id', '=', $id)->with('creator')->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = json_decode($request->data);

        $notice = Notice::find($id);
        $upload_path = "upload/notices";
        if((is_null($request->file)) || ($request->file == "")){$file_type = null; $fileName = null;}
        else{$fileName = time().'.'.$request->file->getClientOriginalExtension(); $request->file->move(public_path($upload_path), $fileName);}
        
        print_r($data);
        echo($request->content);
        echo auth('api')->id().'- ID is not here';
        $notice->image = $fileName;
        $notice->content =  $data->content;
        $notice->topic =  $data->topic;
        $notice->start_date = $data->start_date;
        $notice->end_date = $data->end_date;
        
        $notice->save();

        /*foreach ($request->input('pictures') as $picture){
            NoticePicture::create(['notice_id' => $notice->id, 'picture'   => $picture,]);
        }*/

        return response()->json([
            'notices'       => Notice::where('department_id', '=', 0)->orWhere('department_id', '=', auth('api')->user()->department_id)->andWhere('start_date', '>=', date('Y-m-d'))->get(),
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
