<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminSettings;
use App\Models\Role;
use Carbon\Carbon;
use App\Http\Requests\AdminSettingRequest;
use Hash;
use Image;
use ImageUploadHelper;

class AdminSettingsController extends Controller
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
            "listRoute" => 'admin.admin_settings.index',
            "fetchDataRoute" => 'admin.admin_settings.fetch.data', 
            "createRoute" => 'admin.admin_settings.create', 
            "storeRoute" => 'admin.admin_settings.store', 
            "editRoute" => 'admin.admin_settings.edit', 
            "updateRoute" => 'admin.admin_settings.update', 
            "deleteRoute" => 'admin.admin_settings.delete'
        ],
        "moduleTitle" => 'System Settings',
        "moduleName" => 'admin_settings',
        "viewFolder" => 'admin_settings',
        "imageUploadFolder" => 'uploads/admins/logos',
        "faviconUploadFolder" => 'uploads/admins/favicons',
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

    public function fetchData(Request $request, AdminSettings $AdminSettings)
	{
		
		$data               =   $request->all();

        $db_data            =   $AdminSettings->getList($data);

        $count 				=  	$AdminSettings->getListCount($data);

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
    public function create(AdminSettings $AdminSettings){
    	
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.create')->with('moduleConfig', self::$moduleConfig)->with('row', null);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (AdminSettingRequest $request){

    	$newRecord 						= new AdminSettings();
    	$newRecord->name 				= $request->name;
    	$newRecord->value 				= $request->value;
    	$newRecord->status 				= $request->input('status', 1);
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
    public function show($id, AdminSettings $AdminSettings){

    	$row = AdminSettings::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.show')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

	/**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, AdminSettings $AdminSettings){

    	$row = AdminSettings::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(AdminSettingRequest $request, $id){

    	// dd($request->all());

    	$row = AdminSettings::findOrFail($id);

        if ($request->hasFile('logo')) {
            $logo           = $request->file('logo');
            $fileName       = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $logo, $request->input('app_name'), 1200, 300, true);
            $row->logo  = $fileName;
        }

        if ($request->hasFile('favicon')) {
            $favicon  = $request->file('favicon');
            $fileName       = ImageUploadHelper::uploadImage(self::$moduleConfig['faviconUploadFolder'], $favicon, $request->input('app_name'), 1200, 700, true);
            $row->favicon  = $fileName;
        }

    	$row->app_name 				        = $request->app_name;
    	$row->status 				= $request->input('status', 1);
    	$row->save();

    	\Flash::success(self::$moduleConfig['moduleTitle'].' updated successfully.');
        return \Redirect::route(self::$moduleConfig['routes']['editRoute'], 1);
    }

    /**
     * Delete {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */

    public function delete($id)
    {
    	
    	$row = AdminSettings::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
