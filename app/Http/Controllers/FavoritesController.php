<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Micropost;   //追加

class FavoritesController extends Controller
{
    //ユーザをお気に入りに登録するアクション
    public function store($id){
        
        User::favorite()->favorites($id);
        //前のページへリダイレクトさせる
        return back();
    }
    
    public function destroy($id){
        
        User::unfavorite()->favorites($id);
        //前のページへリダイレクトさせる
        return back();
    }
}
