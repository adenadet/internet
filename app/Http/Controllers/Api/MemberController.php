<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Saving;
use App\Models\User;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class MemberController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            'branch_id' => 'required|numeric',
            'sex' => 'required|string',
            'email' => 'required|unique:users',
            'dob' => 'required|date',
        ]);
         
        if ($request['image']){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];

            \Image::make($request['image'])->save(public_path('img/profile/').$image);

            $image_url = $image;
        }

        else{$image_url = "avatar1.jpg";}

        if (($request->input('unique_id') === null) || ($request->input('unique_id') === '')){
            $branch = Branch::findorfail($request->input('branch_id'));
            $code = $branch->unique_id; 
            $current = sprintf('%04d',$branch->current);
            $unique_id = $code.$current;
            $branch->current += 1;
            $branch->save();
        }
        
        else{$unique_id = $request->input('unique_id');}
        
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $password = substr(str_shuffle($permitted_chars), 0, 10);
        
        $validatedData = $request->validate([
            'email' => 'unique:users',
            //'unique_id' => 'unique:users',
            'branch_id' => 'required',
            'first_name'=> 'required',
            'last_name'=> 'required',
            ]);
            
        $user = User::create([
            'first_name' => $request->input('first_name'), 
            'middle_name' => $request->input('other_name'), 
            'last_name' => $request->input('last_name'), 
            'bvn' => $request->input('bvn'), 
            'email' => $request->input('email'), 
            'password' => bcrypt($password), 
            'pin' => bcrypt('000000'), 
            'unique_id' => $unique_id, 
            'street' => $request->input('street'), 
            'street2' => $request->input('street2'), 
            'city' => $request->input('city'),
            'state_id' => $request->input('state_id'), 
            'phone' => $request->input('phone'), 
            'branch_id' => $request->input('branch_id'),
            ]);

        $saving = Saving::create([
        'name' => "Contributions",
        'type_id' => 1,
        'user_id' => $user->id,
        'status' => 1,
        'requested_date' => date('Y-m-d H:i:s'), 
        'requested_by' => $user->id,
        'status_date' => date('Y-m-d H:i:s'),
        'target' => 0,
        'unconfirmed' => 0,
        ]);

        $user->savings_account_id = $saving->id;
        $user->save();
        
        //Send email to the new user
        $email_sender = '';
        
        //Send SMS to the new user
        $message = 'Good Job %20User:%20'.$user->unique_id.'%20P/word:'.$password.'%0amaking%20your%20contribution%20into%20our%20First%20Bank%20Acct%203044959253%20DLC%20IKEJA%20COOPERATIVE%0aFrom:';
        $sms_sender = $this->sendSMS('234'.substr($user->phone, -10), $message);
        
        return response()->json([
            'user' => $user,
            'password' => $password,
            ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function sendSMS($number, $message = "Thanks for registering"){
        // Create a new Guzzle Plain Client
        $client = new Client();
        $url = 'http://customer.smsprovider.com.ng/api/?username=adenadet01@gmail.com&password=yetunde01&message='.$message.'&sender=DLCIK&mobiles='.$number;
        //dump($url);
        $response = $client->request('GET', $url);
        //dump($response);
        // Obtain the body into an array format.
        $body = json_decode($response->getBody() , true);
        
        // If there were some error on the request, throw the exception
        

        // Returns the array with information about the desired currency
        return $body['status'];
    }
}
