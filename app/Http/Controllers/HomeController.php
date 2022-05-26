<?php

namespace App\Http\Controllers;

use App\Events\BroadcastEvent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Notifications\PostLikeNotification;
use Illuminate\Support\Facades\Session;

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
        $posts = Post::with('user')->get();

        return view('home', ['posts' => $posts]);
    }

    public function postLike(Request $request)
    {
        $user = auth()->user();

        $post = Post::whereId($request->post_id)->with('user')->first();
        // like code -----skip
        $author = $post->user;

//        event(new BroadcastEvent('Demo notifications'));

        $author->notify(new PostLikeNotification($user, $post));

        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        $SERVER_API_KEY = 'AAAAvmtdNQk:APA91bEFYJyFmqo7cZacGIVU6N0It12Gs3zp44sfhWexQJJoJsMEngXvQ6dwhh5K-TzV3yLuCE__r3z2pKDNznBwPiVKcDO6VXJSnXrGTwyy142G0pw76xBZGTU_ZJge7MHRXFlpqhsN';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $user->name .' like post '. $post->id,
                "body" => "Title Post: ". $post->title,
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

        curl_exec($ch);

        return response()->json(['Success']);
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token' => $request->token]);

        return response()->json(['token saved successfully.']);
    }
}
