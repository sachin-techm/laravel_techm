<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Common\MasterModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUsSetting extends MasterModel
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['actions'];

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
                $query->where('hero_title', 'LIKE', '%'.$searchKey.'%')
                ->orWhere('value', 'LIKE', '%'.$searchKey.'%');
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
                $query->where('hero_title', 'LIKE', '%'.$searchKey.'%')
                ->orWhere('value', 'LIKE', '%'.$searchKey.'%');
            });
        }

        return $records->count();
    }

    function getActionsAttribute(){
    
        return '<span class="overflow: visible; position: relative; width: 125px;" data-id="'.$this->id.'">
        
            <a href="edit/1" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
               <i class="flaticon2-pen"></i>
            </a>
            
        </span>';
    }
    
}