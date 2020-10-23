<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Micropost;   //追加
use App\User;       //追加


class FavoritesController extends Controller
{
    //
    public function store($id){
        
        
        //お気に入り登録をする
        \Auth::user()->favorite($id);
        
        //前のページへリダイレクトさせる
        return back();
    }
    
    public function destroy($id){
        
        //お気に入り解除
        \Auth::user()->unfavorite($id);
        //前のページへリダイレクトさせる
        return back();
    }
}
