<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function updateToken(Request $request){
        auth()->user()->update(['fcm_token'=>$request->token]);
        return response()->json(['Token saved successfully.']);
    }

    public function notification(Request $request) {
        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = 'AAAAfgPs20o:APA91bELXSufOjjhS1uBsmnkXgPK2faEEXTk6e1r0Dn39Ei3P-IhTTR5et0Zqrr320lkh4rlFaIbRZ9TqzhklR5hFFVTgoKyREFGAamZAi2htqKp_IxO2_-ItHXsK9jnm1KuKrE-bxY1';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
    }
}