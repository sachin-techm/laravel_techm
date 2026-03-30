<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Category;
use App\Models\SiteType;
use Carbon\Carbon;
use App\Http\Requests\AdminRequest;
use Hash;
use Image;
use ImageUploadHelper;

class AdminUserController extends Controller
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
            "listRoute" => 'admin.admin_user.index',
            "fetchDataRoute" => 'admin.admin_user.fetch.data', 
            "createRoute" => 'admin.admin_user.create', 
            "storeRoute" => 'admin.admin_user.store', 
            "editRoute" => 'admin.admin_user.edit', 
            "updateRoute" => 'admin.admin_user.update', 
            "deleteRoute" => 'admin.admin_user.delete'
        ],
        "moduleTitle" => 'Admin User',
        "moduleName" => 'admin_user',
        "viewFolder" => 'admin_user',
        "imageUploadFolder" => 'uploads/admin_users/',
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

    	// dd(\Auth::user()->getUserDisciplines());

    	return view('admin.'.self::$moduleConfig['viewFolder'].'.index')->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Fetch data for datatable via ajax request for {{moduleTitle}}.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */

    public function fetchData(Request $request, Admin $Admin)
	{
		
		$data               =   $request->all();
        $db_data            =   $Admin->getList($data,['role']);

        $count 				=  	$Admin->getListCount($data);

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
    public function create(Admin $Admin){
    	
    	$roles = Role::where('status', 1)->where('type', 1)->get();
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.create')->with('moduleConfig', self::$moduleConfig)->with('row', null)->with('roles', $roles);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (AdminRequest $request){

    	$admin = new Admin();
    	$admin->name 				= $request->name;
    	$admin->email 				= $request->email;
    	$admin->role_id				= $request->role_id;
    	$admin->password			= Hash::make($request->password);
    	$admin->save();

    	\Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

	/**
     * Show show  form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id, Admin $Admin){

    	$row = Admin::with('role')->findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.show ')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

	/**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Admin $Admin){

    	$roles = Role::where('status', 1)->where('type', 1)->get();
    	$row = Admin::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')->with('moduleConfig', self::$moduleConfig)->with('row', $row)->with('roles', $roles);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(AdminRequest $request, $id){

    	$user 						= Admin::findOrFail($id);
    	$user->name 				= $request->name;
    	$user->email 				= $request->email;
    	$user->role_id				= $request->role_id;
    	if($request->has('password') && $request->filled('password')) {
	    	$user->password = Hash::make($request->password);
	    }

    	$user->save();

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
    	
    	$row = Admin::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
