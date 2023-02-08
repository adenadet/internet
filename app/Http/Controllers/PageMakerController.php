<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

use App\Models\State;
use App\Models\User;
use App\Models\Branch;
use App\Models\Saving;
use App\Models\SavingsAccount;
use App\Exports\UsersExport;
use App\Imports\UsersImport;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

use App\Mail\TestMail;

class PageMakerController extends Controller
{
    public function index()
    {
        //
        $branches = Branch::all();
        $states = State::select('name', 'id')->get();
        $users = User::all();
        $params = [
        'title' => 'Welcome Page',
        'page_header' => 'Welcome',
        'main' => 'Payment',
        'states' => $states,
        'control' => 'screen',
        'branches' => $branches,
        'users' => $users,
        ];
        
        return view('screen')->with($params);
    }

    public function youth()
    {
        //
        $branches = Branch::all();
        $states = State::all();
        $params = [
        'title' => 'Youth Page',
        'page_header' => 'Welcome',
        'main' => 'Payment',
        'states' => $states,
        'control' => 'screen',
        'branches' => $branches
        ];
    return view('screen')->with($params);
    }

    public function create()
    {
        //
    }

    public function ship(Request $request)
    {
        $valueArray = [
        	'name' => 'John',
        ];
        
        try {
            \Mail::to('example@gmail.com')->send(new TestMail($valueArray));
            echo 'Mail send successfully';
        } catch (\Exception $e) {
            echo 'Error - '.$e;
        }
    }

    public function store(Request $request)
    {
        //
        if ($request->input('image')=== null){
            if ($request->input('sex') == "Male"){$image = "/assets/images/xs/avatar1.jpg"; }
            else {$image = "/assets/images/xs/avatar2.jpg";}
            }
        else{
            $image = $request->input('image');
            }
        if ($request->input('unique_id') === null){
            $branch = Branch::findorfail($request->input('branch_id'));
            $code = $branch->unique_id; 
            $current = sprintf('%04d',$branch->current);
            $unique_id = $code.$current;
            $branch->current += 1;
            $branch->save();
        }
        else{
            $unique_id = $request->input('unique_id');
        }
        if ($request->input('branch_id') === null){
            if ($request->input('sex') == "Male"){$image = "/assets/images/xs/avatar1.jpg"; }
            else {$image = "/assets/images/xs/avatar2.jpg";}
            }
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $password = substr(str_shuffle($permitted_chars), 0, 10);
        
        $validatedData = $request->validate([
            'email' => 'unique:users',
            'unique_id' => 'unique:users',
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
        ]);

        $user->savings_account_id = $saving->id;
        $user->save();
        
        //Send email to the new user
        $email_sender = '';
        
        //Send SMS to the new user
        $message = 'Good Job %20User:%20'.$user->unique_id.'%20P/word:'.$password.'%0amaking%20your%20contribution%20into%20our%20First%20Bank%20Acct%203044959253%20DLC%20IKEJA%20COOPERATIVE%0aFrom:';
        $sms_sender = $this->sendSMS('234'.substr($user->phone, -10), $message);
        
        return redirect()->route('welcome')->with('success', "The New User <strong>$user->first_name $user->last_name</strong> has successfully been created.");
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

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
