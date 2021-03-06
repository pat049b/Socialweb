<?php
namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;
use App\Category;


class PostController extends Controller
{
    public function getDashboard()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $categories=Category::all();
        return view('dashboard', ['posts' =>$posts, 'categories'=>$categories]);

    }
    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
            'body'=>'required|max:1000',
            'category_id'=>'required|integer'
        ]);
        $post= new Post();

        $post-> body= $request['body'];
        $post->category_id = $request['category_id'];
        $post->likes=0;
        $post->dislikes=0;
        $message='There was an error';
        if($request->user()->posts()->save($post)){
            $message = 'Post successfully created!';
        }
        return redirect()->route('dashboard')->with(['message'=>$message]);
    }


    public function getDeletePost($post_id)
    {
        $post= Post::where('id', $post_id)->first();
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message'=>'Successfully deleted post.']);
    }

    public function adminDeletePost($post_id)
    {
        $post= Post::where('id', $post_id)->first();
        if(Auth::user()->email != "admin@admin.com"){
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message'=>'Successfully deleted post.']);
    }

    public function postEditPost(Request $request)
    {

        $this->validate($request, [
           'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body'=> $post->body], 200);
    }
    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] == 'true' ? true : false;
        $update = false;
        $post= Post::find($post_id);
        if(!$post){
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like){
            $already_like = $like->like;
            $update = true;

            if($already_like==$is_like){
                $like->delete();
                //
                if($already_like==0)
                    $post->dislikes=$post->dislikes-1;
                if($already_like==1)
                    $post->likes=$post->likes-1;
                $post->save();
                //
                return null;
            }
        } else{
            $like = new Like();
        }
        $like->like=$is_like;
        $like->user_id = $user->id;
        $like->post_id=$post->id;
        $post->save();

        if($update){
            $like->update();
            if($is_like==0){
                $post->likes=$post->likes-1;
                $post->dislikes=$post->dislikes+1;
            }

            if($is_like==1){
                $post->dislikes=$post->dislikes-1;
                $post->likes=$post->likes+1;
            }
            $post->save();
        }
        else{

            $like->save();

            //
            if($is_like==0)
                $post->dislikes=$post->dislikes+1;
            if($is_like==1)
                $post->likes=$post->likes+1;
            //
            $post->save();

        }


        return null;
    }
}