<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\SendVerifyOTP;
use App\Notifications\SendOrder;
use App\Notifications\SendResult;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    protected $appends = ['actions'];

    public static $shouldAppends = true;

    public function sendEmailVerificationNotification(): Otp
    {
        return $this->sendOTP();
    }

    /**
     * Send otp
     * @param  $via
     * @return \App\Models\Otp
     */
    public function sendOTP($via = "mail")
    {
        $otp = Otp::updateOrCreate(
            ['type' => 'login', 'user_id' => $this->id],
            [
                'code' => \App\Helpers\Helper::generateOtp(),
                'expired_at' => now()->addMinutes(30)
            ]
        );

        if (config('app.env') !== "local" && env('MAIL_ENABLED', false) ) {
            $this->notify(new SendVerifyOTP($otp, $via));
        }

        return $otp;
    }
    

    /**
     * Send a password reset notification to the user. 
     * This is url based, best for web app
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $baseURL = config('app.frontend_url');

        $url = "{$baseURL}/auth/reset-password?token={$token}&email={$this->email}";

        $this->notify(new ResetPasswordNotification($url));
    }

    
    /**
     * get result for data table
     * @param  $data array<int, string>
     * @param  $with array<int, string>
     * @param  $where array<int, string>
     * @return \App\Models\User $user[]
    */
    public function getList($data, $with = [], $where = []){  

        $records = $this->handleAjax($data);
        if(isset($with) && !empty($with))
        {
           $records->with($with);        
        }
        
        if(isset($where) && !empty($where))
        {
           $records->where($where);     
        }
        
        if(!empty($data['query']['search'])){

        	$searchKey = $data['query']['search'];
         	$records->where(function($query) use ($searchKey){
                $query->where('name', 'LIKE', '%'.$searchKey.'%')
                    ->orWhere('email', 'LIKE', '%'.$searchKey.'%')
                    ->orWhere('gender', 'LIKE', '%'.$searchKey.'%')
                    ->orWhere('contact', 'LIKE', '%'.$searchKey.'%');
            });
        }

        return $records->get();
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id', 'id');
    }
    
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function getListCount($data, $with = [], $where = []){  

        $records = $this->query();
        if(isset($with) && !empty($with))
        {
           $records->with($with);        
        }
        
        if(isset($where) && !empty($where))
        {
           $records->where($where);     
        }

        if(!empty($data['query']['search'])){

        	$searchKey = $data['query']['search'];
         	$records->where(function($query) use ($searchKey){
                $query->where('name', 'LIKE', '%'.$searchKey.'%')
                    ->orWhere('email', 'LIKE', '%'.$searchKey.'%')
                    ->orWhere('gender', 'LIKE', '%'.$searchKey.'%')
                    ->orWhere('contact', 'LIKE', '%'.$searchKey.'%');
            });
        }

        return $records->count();
    }
   
    function    handleAjax($data){

        $page               =   $data['pagination']['page'] ?? 0 ;
        $page               =   $page - 1;
        $perPage            =   $data['pagination']['perpage'] ?? 10;
        $page               =   $page * $perPage;

        $sort               =   $data['sort']['sort'] ?? 'desc';
        $field              =   $data['sort']['field'] ?? 'created_at';  


        return $this
                    ->orderby($field, $sort)
                    ->skip($page)
                    ->take($perPage);

    }

    function getActionsAttribute(){
   
      return '<span class="overflow: visible; position: relative; width: 125px;" data-id="'.$this->id.'">
        <a href="show/'.$this->id.'" class="btn btn-sm btn-clean btn-icon mr-2" title="Show details">
            <i class="flaticon-eye"></i>
        </a>
         <a href="edit/'.$this->id.'" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
            <i class="flaticon2-pen"></i>
        </a>
        <a href="delete/'.$this->id.'" class="btn btn-sm btn-clean btn-icon delete_btn" title="Delete">
            <i class="flaticon2-trash"></i>
        </a>
      </span>';
    }
    
    protected function getArrayableAppends()
    {
        if(self::$shouldAppends){
            return parent::getArrayableAppends();
        }

        return [];
    }
	    
}
