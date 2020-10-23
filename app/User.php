<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    //$userIdで指定されたユーザをフォローする
    public function follow($userId){
        
        //すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        
        //相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;
        
        if($exist || $its_me){
            //すでにフォローしていれば何もしない
            return false;
        }else{
            //未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    //$userIdで指定されたユーザをアンフォローする
    public function unfollow($userId){
        //すでにフォローしているかの確認
        
        $exist = $this->is_following($userId);
        
        //相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me){
           
            //すでにフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        }else{
            //未フォローであれば何もしない
            return false;
        }
    }
    
    //指定された$userIdのユーザをこのユーザがフォロー中であるか調べる。
    //フォロー中であればtrueを返す
    
    public function is_following($userId){
        
        //フォロー中ユーザの中に$userIdのものが存在するか
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    
    
    //このユーザとフォロー中ユーザの投稿に絞り込む
    public function feed_microposts(){
        
        //このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        
        //このユーザのidもその配列に追加
        $userIds[] = $this->id;
        
        //それらのユーザが所有する投稿に絞り込む
        return Micropost::whereIn('user_id',$userIds);
    }
    
    
    //ユーザが所有する投稿（Micropostモデルとの関係を定義）
    public function microposts(){
        return $this->hasMany(Micropost::class);
    }
    
    //ユーザがフォロー中のユーザ。( Userモデルとの関係を定義)
    
    public function followings(){
           
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
        
    }
    
    
    //ユーザがフォロー中のユーザ。( Userモデルとの関係を定義)
    
    public function followers(){
        
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }
    
    
    //このユーザに関係するモデルの件数をロードする
    public function loadRelationshipCounts(){
        $this->loadCount(['microposts','followings','followers','favorites']);
        
        
    }
    
    
    
    
   //この投稿が所有するお気に入り (micropostsモデルとの関係を定義)
    public function favorites(){
        return $this->belongsToMany(Micropost::class,'favorites','user_id','microposts_id')->withTimestamps();
       // logger($this);
    }
    
    //お気に入りに入れる動作
    public  function favorite($micropostId){
        
        //既にお気に入り登録しているか確認
        $exist = $this->is_favorite($micropostId);
        
        if($exist){
            
            //既に登録されていたら何もしない
            return false;
        }else{
            
            //未登録ならば登録する
            $this->favorites()->attach($micropostId);
            return true;
        }
    }
    
    //お気に入りから外す動作
     public function unfavorite($micropostId){
         
        //既にお気に入り登録しているか確認
        $exist = $this->is_favorite($micropostId);
        
        if($exist){
            
            //既に登録されていたらお気に入りを解除する
            $this->favorites()->detach($micropostId);
            
            
            return true;
            
        }else{
            //未登録ならばなにもしない;
            return false;
        }
    }
    
    public function is_favorite($micropostId){
        
        //お気に入り登録してあるものの中に$favoritesIdの物が存在するか
        return $this->favorites()->where('microposts_id',$micropostId)->exists();
    }
   
}
