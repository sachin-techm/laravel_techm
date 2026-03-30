<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemSettings;
use App\Models\Role;
use Carbon\Carbon;
use App\Http\Requests\SystemSettingsRequest;
use Hash;
use Image;
use ImageUploadHelper;

class SystemSettingsController extends Controller
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
            "listRoute" => 'admin.system_settings.index',
            "fetchDataRoute" => 'admin.system_settings.fetch.data', 
            "createRoute" => 'admin.system_settings.create', 
            "storeRoute" => 'admin.system_settings.store', 
            "editRoute" => 'admin.system_settings.edit', 
            "updateRoute" => 'admin.system_settings.update', 
            "deleteRoute" => 'admin.system_settings.delete'
        ],
        "moduleTitle" => 'System Settings',
        "moduleName" => 'system_settings',
        "viewFolder" => 'system_settings',
        "imageUploadFolder" => 'uploads/system_settings/',
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

    public function fetchData(Request $request, SystemSettings $SystemSettings)
	{
		
		$data               =   $request->all();

        $db_data            =   $SystemSettings->getList($data);

        $count 				=  	$SystemSettings->getListCount($data);

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
    public function create(SystemSettings $SystemSettings){
    	
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.create')->with('moduleConfig', self::$moduleConfig)->with('row', null);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (SystemSettingsRequest $request){

    	$newRecord 						= new SystemSettings();
    	$newRecord->name 				= $request->name;
    	$newRecord->value 				= $request->value;
    	$newRecord->status 				= $request->input('status', 0);
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
    public function show($id, SystemSettings $SystemSettings){

    	$row = SystemSettings::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.show')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

	/**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, SystemSettings $SystemSettings){

    	$row = SystemSettings::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(SystemSettingsRequest $request, $id){

    	// dd($request->all());

    	$updateRecord = SystemSettings::findOrFail($id);
    	$updateRecord->name 				= $request->name;
    	$updateRecord->value 				= $request->value;
    	$updateRecord->status 				= $request->input('status', 0);
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
    	
    	$row = SystemSettings::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
