<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guard = 'admin';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['*'];

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

    public function setCategoryIdAttribute($value){
    
        $this->attributes['category_id'] = json_encode($value);
    }

    public function getCategoryIdAttribute($value){
    	
    	$v = json_decode($value) ?? [];
    	return !is_array($v) ? [] : $v;
    }

    public function getUserDisciplines(){
    	
    	if(\Auth::user()->getUserRoleCode() == 'SUPER_ADMIN'){

    		return Category::where('status', 1)->get();
    	}

    	return Category::whereIn('id', $this->category_id)->where('status', 1)->get();
    }

    public function getUserDisciplineIds(){
    	
    	if(\Auth::user()->getUserRoleCode() == 'SUPER_ADMIN'){

    		return true;
    	}

    	return Category::whereIn('id', $this->category_id)->where('status', 1)->pluck('id');
    }

    public function getUserRoleName(){
    	
    	return Role::where('id', $this->role_id)->first()->name ?? '';
    }

    public function getUserRoleCode(){
    	
    	return Role::where('id', $this->role_id)->first()->role_code ?? '';
    }

    public function getList($data, $with = [], $where = []){  

        $records = $this->handleAjax($data);
        $records->with(['role']);
        if(isset($with) && !empty($with))
        {
           $records->with($with);        
        }
        
        if(isset($where) && !empty($where))
        {
           $records->where($where);     
        }
        
        if (!empty($data['query']['search'])) {
            $searchKey = $data['query']['search'];
            $records->where(function($query) use ($searchKey){
                $query->where('name', 'LIKE', '%'.$searchKey.'%')
                    ->orWhere('email', 'LIKE', '%'.$searchKey.'%')
                    ->orWhereHas('role', function ($query) use ($searchKey) {
                        $query->where('name', 'LIKE', '%'.$searchKey.'%');
                    });
            });
        }

        return $records->get();
    }

    public function getListCount($data, $with = [], $where = []){  

        $records = $this->query();
        $records->with(['role']);
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
                    ->orWhereHas('role', function ($query) use ($searchKey) {
                        $query->where('name', 'LIKE', '%'.$searchKey.'%');
                    });
            });
        }

        return $records->count();
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    /**
    *   Handle Ajax to set orderby and limit and offset
    *
    */
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
}
