<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Micropost;   //追加
use App\User;       //追加

class UsersController extends Controller
{
    //viewに共有するデータを取りまとめ
    public function initialization(){
        View::share('$microposts','$users');
    }
    
    
    public function index(){
        //ユーザー一覧を降順で取得
        $users = User::orderBy('id','desc')->paginate(10);
        //ユーザー一覧ビューでそれを表示
        return view('users.index',[
            'users' => $users,
            ]);
    }
    
    public function show($id){
        //idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザの投稿一覧を作成日時の降順で取得
        $microposts = $user->microposts()->orderBy('created_at','desc')->paginate(10);
        
        //ユーザ詳細ビューでそれを表示
        return view('users.show',[
            'user' => $user,
            'microposts' => $microposts,
            ]);
    }
    
    
    //ユーザのフォロー一覧ページを表示するアクション
    public function followings($id){
        //idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザのフォロー一覧を取得
        $followings = $user->followings()->paginate(10);
        
         
        //フォロー一覧ビューでそれらを表示
        return view('users.followings',
        ['user' => $user,
        'users' => $followings,
        ]);
    }
    
    //ユーザのフォロワー一覧ページを表示するアクション
    public function followers($id){
        //idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        
        
        //関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザのフォロー一覧を取得
        $followers = $user->followers()->paginate(10);
        
         
        //フォロー一覧ビューでそれらを表示
        return view('users.followers',
        ['user' => $user,
        'users' => $followers,
        ]);
    }
    
    //ユーザのお気に入り一覧を表示するアクション
    public function favorite_list($id){
        //idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザのお気に入り一覧を取得
        $favorite = $user->favorites()->paginate(10);
        
        //一覧をビューで表示する
        return view(
            'users.favorite',[
            'user' => $user,
            'favorite' => $favorite
        ]);
    }
}
