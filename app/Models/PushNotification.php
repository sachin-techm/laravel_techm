<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Common\MasterModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PushNotification extends MasterModel
{
   use HasFactory;
   use SoftDeletes;

   protected $appends = ['actions'];

   public function getUserIdsAttribute($value)
   {
      if( empty($value)) {
         return [];
      }

      return json_decode($value, true) ?? [];
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
            $query->where('title', 'LIKE', '%'.$searchKey.'%')
               ->orWhere('body', 'LIKE', '%' . $searchKey . '%');
         });
      }

      return $records->get();
   }

   public function getUserName()
   {
      if (empty($this->user_ids) || $this->user_ids === null) {
         return [];
      }
      
      $records = User::whereIn('id', $this->user_ids)->get()->map(function ($user) {
         if (!empty($user->last_name)) {
            return $user->first_name . ' ' . $user->last_name;
         } else {
            return $user->first_name;
         }
      })->toArray();

      return $records;
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
            $query->where('title', 'LIKE', '%'.$searchKey.'%')
               ->orWhere('body', 'LIKE', '%' . $searchKey . '%');
         });
      }

      return $records->count();
   }

   function getActionsAttribute(){
   
      return '<span class="overflow: visible; position: relative; width: 125px;" data-id="'.$this->id.'">
         <a href="show/'.$this->id.'" class="btn btn-sm btn-clean btn-icon mr-2" title="Show details">
            <i class="flaticon-eye"></i>
         </a>
         <a href="create/?id='.$this->id.'" class="btn btn-sm btn-clean btn-icon mr-2" title="Show details">
            <i class="flaticon2-refresh-button"></i>
         </a>
         <a href="delete/'.$this->id.'" class="btn btn-sm btn-clean btn-icon delete_btn" title="Delete">
            <i class="flaticon2-trash"></i>
         </a>
      </span>';
   }
   
}
