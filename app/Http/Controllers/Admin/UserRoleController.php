<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\AdminModule;
use App\Models\RolePermission;
use Carbon\Carbon;
use App\Http\Requests\UserRoleRequest;
use App\Http\Requests\PermissionRequest;
use Hash;


class UserRoleController extends Controller
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
            "fetchDataRoute" => 'admin.user_role.fetch.data', 
            "createRoute" => 'admin.user_role.create', 
            "storeRoute" => 'admin.user_role.store', 
            "editRoute" => 'admin.user_role.edit', 
            "updateRoute" => 'admin.user_role.update', 
            "deleteRoute" => 'admin.user_role.delete',
            "permissionRoute" => 'admin.user_role.save_permission',
        ],
        "moduleTitle" => 'User Roles',
        "moduleTitles" => 'Set Permission For Role',
        "moduleName" => 'user_role',
        "viewFolder" => 'role',
        "imageUploadFolder" => 'uploads/email_templates/',
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

    public function fetchData(Request $request, Role $Role)
    {
        
        $data               =   $request->all();
        $db_data            =   $Role->getList($data);

        $count            	=   $Role->getListCount($data);
        
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
    public function create(Role $Role){
        
        return view('admin.'.self::$moduleConfig['viewFolder'].'.create')->with('moduleConfig', self::$moduleConfig)->with('row', null);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (UserRoleRequest $request){

        $newRecord                      = new Role();
        $newRecord->name                = $request->name;
        $newRecord->role_code           = $request->role_code;
        $newRecord->type                = $request->type;
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
    public function show($id, Role $Role){

        $row = Role::findOrFail($id);
        return view('admin.'.self::$moduleConfig['viewFolder'].'.show')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Role $Role){

        $row = Role::findOrFail($id);
        return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(UserRoleRequest $request, $id){

        // dd($request->all());
        $updateRecord = Role::findOrFail($id);
        $updateRecord->name                 = $request->name;
        $updateRecord->role_code            = $request->role_code;
        $updateRecord->type              	= $request->type;
        $updateRecord->status               = $request->input('status', 0);
        $updateRecord->save();

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
        
        $row = Role::findOrFail($id);
        $row->delete();
        \Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function permission($id){
        $permission = AdminModule::where('status', 1)->get();
        $row = RolePermission::select("*")->where("role_id", $id)->get();     
        $role = Role::select("name")->where("id", $id)->get();     
        return view('admin.'.self::$moduleConfig['viewFolder'].'.permission')->with('moduleConfig', self::$moduleConfig)->with('modules', $permission)->with('role_id',$id)->with('row',$row)->with('role',$role);
    }

    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $null
     * @return \Illuminate\Http\Response
     */
    public function save_permission(PermissionRequest $request){
        $array = $request->all();
        unset($array['_token']);
        $id = $array['id'];
        if (!empty($id)) {
            $newRecord = RolePermission::findOrFail($id); 
        }else{

            $newRecord                      = new RolePermission();
        }
        unset($array['id']);
        $newRecord->role_id             = $request->role_id;
        $newRecord->permission_data     = json_encode($array,true);
        
        $newRecord->save();

        \Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);

       
    }

}
