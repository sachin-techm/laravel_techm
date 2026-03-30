<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterModel extends Model
{
    public static $shouldAppends = true;

    /**
    *   Find function to point id function 
    *
    */

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

        	// $searchKey = $data['query']['search'];
         // 	$records->where(function($query) use ($searchKey){
         //        $query->where('name', 'LIKE', '%'.$searchKey.'%')
         //              ->orWhere('code', 'LIKE', '%'.$searchKey.'%')
         //              ->orWhere('slug', 'LIKE', '%'.$searchKey.'%');
         //    });
        }

        return $records->count();
    }

    function    getStatusCustomAttribute(){
        $class = $status = '';
        $value  =   $this->status;
        switch ($value) {
            case '0':
                $status     =    "Pending";
                $class      =   'label-light-primary';
                break;
            case '1':
                $status     =    "Processing";
                $class      =   'label-light-info';
                break;
            case '2':
                $status     =    "Completed";
                $class      =   'label-light-success';
                break;
            case '3':
                $status     =    "Canceled";
                $class      =   'label-light-danger';
                # code...
                break;
        }
        $tooltip = '';
        if(!empty($this->msg)){
            $tooltip = 'data-toggle="tooltip" title="'.$this->msg.'"';
        }

        return '<p '.$tooltip.' class="label font-weight-bold label-lg ' .$class . ' label-inline">' .$status. '</p>';
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

    /**
     * @inheritdoc
     */
    public function __call($method, $parameters)
    {
        // Unset method
        if (strpos($method, 'get_') !== false) {
            $method     =   str_replace('get_', '', $method);
            $method     =   strtolower($method);
            $return     =   $this->{$method};
            if(!empty($return)){
                return $return;
            }
        }
        if (strpos($method, 'get') !== false) {

            $check      =   explode('get', $method);

            if(!empty($check[1])){
                $method     =   str_replace('get', '', $method);
                $method     =   strtolower($method);
                $return     =   $this->{$method};
                if(!empty($return)){
                    return $return;
                }
            }

        }

        return parent::__call($method, $parameters);
    }  

    function    redirect($message){
        \Flash::error($message);
        return redirect()->back();
    }

    protected function getArrayableAppends()
    {
        if(self::$shouldAppends){
            return parent::getArrayableAppends();
        }

        return [];
        
    }
}
