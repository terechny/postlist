<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userInfo(Request $request, $id){

        $res = User::select('id', 'name', 'second_name')->find($id);
        $user_id = $request->user()->id;;
        
        $subscribe = false;
        $subscribe = $this->checkUserSubscriptions($user_id, $res->id);

        $data = [

            'firstname'   => $res->name,
            'secondname'  => $res->second_name,
            'user_id'     => (int)$res->id,
            'posts_count' => Post::where('user_id', $res->id)->count(),
            'followers'   => Subscription::where('subscription', $res->id)->count(),
            'follows'     => Subscription::where('user_id', $res->id)->count(), 
            'subscribe'   => $subscribe           
        ];

        return response()->json($data)->setStatusCode(200);
    }

    public function subscribe(Request $request, $subscription){

        $user_id = $request->user()->id;
        $data = ['status' => false, 'result' => [] ];

        if( !$this->checkUserSubscriptions($user_id, $subscription) ){
           
            $data['result'] = Subscription::create([ 'user_id' => $user_id, 'subscription' => $subscription ]);
            $data['status'] = true;
        }
   
        return response()->json($data)->setStatusCode(200);
    }

    public function unsubscribe(Request $request, $subscription){

        $user_id = $request->user()->id;
        $data = ['status' => false, 'result' => [] ];

        if( $this->checkUserSubscriptions($user_id, $subscription) ){

            $data['status'] = true;
            $data['result'] = Subscription::where('user_id', $user_id)->where('subscription', $subscription)->delete();       
        }

        return response()->json($data)->setStatusCode(200);
    }

    public function checkUserSubscriptions($user, $subscription){

        return Subscription::where('user_id', $user)->where('subscription', $subscription)->exists();
    }

    public function checkLogin(Request $request){

        $data = [
            'status' => false,
            'user' => 0
        ];

        if( $request->user() ){
            $data['status'] = true;
            $data['user'] = $request->user()->id;
        }

        return response()->json($data)->setStatusCode(200);
    }

    public function getFollows(Request $request){

        $data = [
            'status' => true,
            'type' => '',
            'request' => $request->all()
        ];

        if($request->has('type') AND $request->has('user') ){

            if( $request->type == 'follows' ){

                $data['users'] = Subscription::select('users.id', 'users.name', 'users.second_name')
                                ->join('users', 'subscriptions.subscription', '=', 'users.id')
                                ->where('subscriptions.user_id', $request->user)
                                ->get();

            }

            if( $request->type == 'followers' ){

                $data['users'] = Subscription::select('users.id', 'users.name', 'users.second_name')
                                    ->join('users', 'subscriptions.user_id', '=', 'users.id')
                                    ->where('subscriptions.subscription', $request->user)
                                    ->get();  

            }
                    
        }

        return response()->json($data)->setStatusCode(200);

    }

}
