<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Common\MasterModel;

class Speaker extends MasterModel
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
            $query->where('name', 'LIKE', '%'.$searchKey.'%')
               ->orWhere('designation', 'LIKE', '%'.$searchKey.'%')
               ->orWhere('link', 'LIKE', '%'.$searchKey.'%')
               ->orWhereHas('speakerType', function ($query) use ($searchKey) {
                  $query->where('name', 'LIKE', '%'.$searchKey.'%');
               });
         });
      }
      return $records->get();
   }

   public function speakerType()
   {
      return $this->belongsTo('App\Models\SpeakerType', 'speaker_type_id', 'id');
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
               ->orWhere('designation', 'LIKE', '%'.$searchKey.'%')
               ->orWhere('link', 'LIKE', '%'.$searchKey.'%')
               ->orWhereHas('speakerType', function ($query) use ($searchKey) {
                  $query->where('name', 'LIKE', '%'.$searchKey.'%');
               });
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
      </span>';
   }
   
}
