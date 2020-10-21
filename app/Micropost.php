<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable=['content'];
    
    //この投稿を所有するユーザ（Userモデルとの関係を定義）
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    
    
    //お気に入りを所有するユーザ（Userモデルとの関係を定義）
    public function favorite_users(){
        return $this->belongsToMany(Uesr::class,'favorites','microposts_id','user_id')->withTimestamps();
    }
    
    
    
     

    
     
}

