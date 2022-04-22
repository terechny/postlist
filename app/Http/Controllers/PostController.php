<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $perPage = 5;
    private $skip = 0;
    private $numPage = 0;
    private $pageName = 'home';

    public function index( Request $request )
    {

        $this->setPostParams($request);

        $data = [
            "status" => true,
            "data"  => $request->all()
        ]; 

        $data['posts'] = Post::select('posts.*', 'users.name', 'users.second_name' )
                            ->join('users', 'posts.user_id', '=', 'users.id')
                            ->when( $this->pageName == 'user' AND $request->query('user'), function ($query) use ($request) { 

                                return $query->where('posts.user_id', $request->query('user'));
                            })
                            ->when( $this->pageName == 'home' AND $request->user(), function($query) use ($request){

                                return $query->whereIn('posts.user_id', $this->getSubscription($request));
                            })                                               
                            ->orderBy('posts.id', 'desc')
                            ->skip($this->skip)
                            ->take($this->perPage)
                            ->get();
                
        return response()->json($data)->setStatusCode(200);
    }

    private function setPostParams($request){

        if( $request->has('per_page') AND  $request->query('per_page') > 0 ){

            $this->perPage = $request->query('per_page');
        }

        if( $request->has('num_page') AND $request->query('num_page') > 0 ){

            $this->numPage = $request->query('num_page');
        } 

        if( $request->has('page')){

            $this->pageName = $request->query('page');
        } 
      
        $this->skip = $this->perPage * $this->numPage;

    }

    private function getSubscription($request){

        $subscription = Subscription::select('subscription')->where('user_id', $request->user()->id)->get()->toArray();
        $subscription[] = ['subscription' => $request->user()->id];
        return $subscription;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [

            "status" => false,
            "post"   => [] 
        ];

        if( $request->user() ){

            $data['status'] = true;
            $data['post'] = Post::create([
                'text'    => $request->text,
                'user_id' => $request->user()->id
            ]);

        }

        return response()->json($data)->setStatusCode(200);        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
