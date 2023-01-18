<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Trip;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function getLogout(Request $request)
    {
			Auth::logout();
			return redirect('/login');
	}

	public function postSignin(Request $request)
	{

	/*	$request->validate([
        'email' => 'email|required',
		'password' => 'required|4',
    ]); */


		if(Auth::attempt([
			'email' => $request->input('email'),
			'password' => $request->input('password')
		]))
		{
			$user = User::find(Auth::id());

			switch($user->userType)
			{
				case 'admin':
				case 'superadmin':
				case 'fleet':
				return redirect()->route('dashboard.index');

				case 'business':
				return redirect()->route('business.index');

				case 'staff':
				return redirect()->route('business.staffrequests');

				case 'bm':
				return redirect()->route('bm.index');

				case 'branch':
				return redirect()->route('branch.dashboard');
			}
		}
		return redirect()->back()->with('message','invalid login details');
	}
	
	
	public function indexx()
    {
        if (!session()->exists('driver')) {
            return redirect('/uncaps/login');
        }else {
            $id=session()->get('driver');
            $driver=user::find($id);
            $bizcode=$driver->business_code;
            $staff = user::whereraw("business_code='$bizcode' and usertype='staff'")->get();
            return view('uncaps.uncap',compact('staff'));
        }
	}
	
	
	public function storee(Request $request)
    {   
        //checking that the user is logged in
        if (!session()->exists('driver')) {
            return redirect('/');
        }else {
            // insert
            $id=session()->get('driver');
            $driver=user::find($id);
            $bizcode=$driver->business_code;
            $staff = user::whereraw("business_code='$bizcode' and usertype='staff'")->first();
           
            //$twick = Config::where('unique_code',$request->business_code= $driver->business_code)->first();
            $this->validate($request,[
                'staff'=>'required',
                'origin'=>'required',
                'startTime'=>'required',
                'destination'=>'required',
                'duration'=>'required',
                'distance'=>'required',
                'endTime'=>'required',
             ]);
            $uncap = new trip();
            $uncap->driverId= $id;
            $uncap->staffName = $this->userIdToUserName($staff->id);
            $uncap->driverName = $this->userIdToUserName($driver->id);
            $uncap->srcLat= $request->input('srclat');
            $uncap->srcLong= $request->input('srclng');
            $uncap->destLat= $request->input('deslat');
            $uncap->destLong= $request->input('deslng');
            $uncap->staffId= $request->input('staff');
            $uncap->pickupAddress= $request->input('origin');
            $uncap->trip_start_time=date('D M j Y G:i:s',strtotime($request->input('startTime'))).' GMT+0100 (WAT)';
            $uncap->destAddress= $request->input('destination');
            $uncap->travelTime= $request->input('duration');
            $uncap->tripDist= $request->input('distance');
            $uncap->tripAmt= ($request->input('distance')/1000)*65+220;
            $uncap->tripEndTime= date('D M j Y G:i:s',strtotime($request->input('endTime'))).' GMT+0100 (WAT)';
            $uncap->business_code= $driver->business_code;
            $uncap->parent_code= $this->insertParentCode($driver->business_code);
            $uncap->tripRequest= 'approved';
            $uncap->save();
            return redirect('/uncaps/dashboard')->with('success','trip captured sucsessfully');
        }
        
    }

    function insertParentCode($busy_code){
        $driver = User::where(['unique_code' => $busy_code])->first();
        return $driver->business_code ? $driver->business_code : $busy_code ;
    }
	
	function userIdToUserName($id){
        $user = User::where('id',$id)->first();
         return $user->name;
    }

	
	
	public function staffTripRequest(Request $request)
	{ 
		 $formInput['business_code'] = Auth::user()->business_code; 
		 $formInput['company'] = Auth::user()->company; 
		 $formInput['tripRequest'] = 'pending'; 
		 $formInput['staffId'] = Auth::id(); 

		   $tripcheck = Trip::where(['staffId'=>Auth::id(),'tripRequest' => 'pending'])->orderBy('id', 'desc')->first();
      if(!is_null($tripcheck))
      {
        return redirect()->back()->with('message','You have a pending Trip request');
      }

		Trip::create($formInput);

		$user = User::where('unique_code',Auth::user()->business_code)->first();
		$email = $user->email;
		$name =   $user->name;

		if(Auth::user()->phone)
		{
			 $this->sendSmsMessage(Auth::user()->phone,'Trip Request was successful');
		}

		if($user->phone)
		{
			$this->sendSmsMessage($user->phone,'Kindly approve a staff trip request');
		}

		 Mail::send('emails.stafftriprequest',  [
            'email' => $email, 
            'name' => $name,
            ], function ($message) use ($email) {
                $message->to($email);
                $message->subject('SmoothRide: Trip Request');
            });


		return redirect()->back()->with('message','trip request made ');

	}

 	public function emailTest()
 	{
 			try{
		 		Mail::send('emails.test',[], function ($message) {
		                $message->to('francollimassociates@gmail.com');
		                $message->from('info@preventpro.ng','SmoothRide');
		                $message->subject('SmoothRide: TEST');
		            });

				return 1;
				}catch(\Exception $e){
					 return $e;
			}
 	}

     function sendSmsMessage($to,$message)
    {
       // $to = '08066289557';
      //  $message = 'You are doing good';

          $headers = [
            'Content-Type' => 'application/json',
            'apiKey' => '53f177068392eb223a0e480d44f86c78330a1bb5a611f64fd6a0cc625e950c98',
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
    $response = $client->request('POST', 'https://api.africastalking.com/version1/messaging', [
        'form_params' => [
             "username" => 'smoothride',
             "to" => $to,
             "message" => $message,
             "from" => 'SmoothRide',
        ]
    ]);

    $response = $response->getBody()->getContents();
    }



}
