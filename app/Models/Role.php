<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Common\MasterModel;
use App\Models\User;

class Role extends MasterModel
{

    use HasFactory;

    protected $appends = ['actions'];

    public function users() {

    	return $this->hasMany(User::class, 'role_id', 'id');
    }

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
                ->orWhere('role_code', 'LIKE', '%'.$searchKey.'%')
                ->orWhere('type', 'LIKE', '%'.$searchKey.'%');
            });
        }

        return $records->get();
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
                ->orWhere('role_code', 'LIKE', '%'.$searchKey.'%')
                ->orWhere('type', 'LIKE', '%'.$searchKey.'%');
            });
        }

        return $records->count();
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

                <a href="'.route('admin.permission.edit', [$this->id]).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                   <i class="flaticon2-lock"></i>
                </a>
            </span>';
    }
}
