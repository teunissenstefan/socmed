<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'github_username', 'birthdate', 'gender', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function statuses(){
        return $this->hasMany('App\Status','poster','id')->orderBy('created_at','desc');
    }

    public function sex(){
        return $this->hasOne('App\Gender','id','gender');
    }

    public static function age($birthDate){
        $birthDate = explode("-", $birthDate);
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[1]))) > date("md")
            ? ((date("Y") - $birthDate[0]) - 1)
            : (date("Y") - $birthDate[0]));
        return $age;
    }

    function pendingFriendRequests()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id')
            ->orderBy('friends.created_at', 'desc')
            ->wherePivot('accepted', '=', 0)
            ->withPivot('accepted');
    }

    function pendingFriendRequestsForMe()
    {
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id')
            ->orderBy('friends.created_at', 'desc')
            ->wherePivot('accepted', '=', 0)
            ->withPivot('accepted');
    }

    //hier alle echte vrienden laden
    function friendsOfMine()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id')
            ->wherePivot('accepted', '=', 1) // to filter only accepted
            ->withPivot('accepted'); // or to fetch accepted value
    }

    function friendOf()
    {
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id')
            ->wherePivot('accepted', '=', 1)
            ->withPivot('accepted');
    }

    public function getFriendsAttribute()
    {
        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();

        return $this->getRelation('friends');
    }

    protected function loadFriends()
    {
        if ( ! array_key_exists('friends', $this->relations))
        {
            $friends = $this->mergeFriends();

            $this->setRelation('friends', $friends);
        }
    }

    protected function mergeFriends()
    {
        return $this->friendsOfMine->merge($this->friendOf);
    }
}
