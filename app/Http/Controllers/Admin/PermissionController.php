<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\AdminModule;
use App\Models\RolePermission;
use Carbon\Carbon;
use App\Http\Requests\PermissionRequest;
use Hash;


class PermissionController extends Controller
{   
    /*
    |--------------------------------------------------------------------------
    | {{moduleTitle}} Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles create, update, delete and show list of {{moduleTitle}}.
    |
    */

    public static $moduleConfig = [
        "routes" => [
            "listRoute" => 'admin.user_role.index',
            "fetchDataRoute" => 'admin.permission.fetch.data', 
            "createRoute" => 'admin.permission.create', 
            "storeRoute" => 'admin.permission.store', 
            "editRoute" => 'admin.permission.edit', 
            "updateRoute" => 'admin.permission.update', 
            "deleteRoute" => 'admin.permission.delete',
        ],
        "moduleTitle" => 'Permission',
        "moduleName" => 'permission',
        "viewFolder" => 'permission',
        "imageUploadFolder" => 'uploads/permissions/',
    ];

	/**
     * Constructor Method.
     *
     * Setting Authentication
     *
     */

    public function __construct()
    {
    	parent::__construct();
        $this->middleware('auth:admin');

    }


    /**
     * Show list of {{moduleTitle}}.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request){

        return view('admin.'.self::$moduleConfig['viewFolder'].'.index')->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Fetch data for datatable via ajax request for {{moduleTitle}}.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */

    public function fetchData(Request $request, RolePermission $RolePermission)
    {
        
        $data               =   $request->all();
        $db_data            =   $RolePermission->getList($data);

        $count 				=  	$RolePermission->getListCount($data);
        
        $returnArray = array(
            'data' => $db_data,
            'meta' => array(
                'page'          =>      $data['pagination']['page'] ?? 1, 
                'pages'         =>      $data['pagination']['pages'] ?? 1, 
                'perpage'       =>      $data['pagination']['perpage'] ?? 10, 
                'total'         =>      $count, 
                'sort'          =>      $data['sort']['sort'] ?? 'asc', 
                'field'         =>      $data['sort']['field'] ?? '_id', 
            ),
        );

        return $returnArray;
    }

    /**
     * Show create form of {{moduleTitle}}.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public function create(RolePermission $RolePermission){
        
        return view('admin.'.self::$moduleConfig['viewFolder'].'.create')->with('moduleConfig', self::$moduleConfig)->with('row', null);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (UserRoleRequest $request){

        $newRecord                      = new RolePermission();
        $newRecord->name                = $request->name;
        $newRecord->type                 = $request->type;
        $newRecord->status              = $request->input('status', 0);
        $newRecord->save();

        \Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

    /**
     * Show show form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, RolePermission $RolePermission){

        $row = RolePermission::findOrFail($id);
        return view('admin.'.self::$moduleConfig['viewFolder'].'.show')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, RolePermission $RolePermission){

        $role 			= Role::findOrFail($id);
        $adminModules 	= AdminModule::get();
        $row 			= RolePermission::where("role_id", $id)->first();

        if(!$row){

        	$row = new \stdClass();
        	$row->permission_data = [];
        }
        
        return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')
	        ->with('moduleConfig', self::$moduleConfig)
	        ->with('adminModules', $adminModules)
	        ->with('row', $row)
	        ->with('role', $role);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(PermissionRequest $request, $id){

        $newRecord = RolePermission::where('role_id', $request->role_id)->first(); 

        if(!$newRecord){

            $newRecord                 	= new RolePermission();
        }

        $newRecord->role_id             = $request->role_id;
        $newRecord->permission_data     = $request->permission_data;
        $newRecord->save();

        \Flash::success(self::$moduleConfig['moduleTitle'].' updated successfully.');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

    /**
     * Delete {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */

    public function delete($id)
    {
        
        $row = Permission::findOrFail($id);
        $row->delete();
        \Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
