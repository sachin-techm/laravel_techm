<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModule;
use Carbon\Carbon;
use App\Http\Requests\AdminModuleRequest;
use Hash;


class AdminModuleController extends Controller
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
            "listRoute" => 'admin.admin_module.index',
            "fetchDataRoute" => 'admin.admin_module.fetch.data', 
            "createRoute" => 'admin.admin_module.create', 
            "storeRoute" => 'admin.admin_module.store', 
            "editRoute" => 'admin.admin_module.edit', 
            "updateRoute" => 'admin.admin_module.update', 
            "deleteRoute" => 'admin.admin_module.delete'
        ],
        "moduleTitle" => 'Admin Module',
        "moduleName" => 'admin_module',
        "viewFolder" => 'admin_module',
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

    public function fetchData(Request $request, AdminModule $AdminModule)
    {
        
        $data               =   $request->all();
        $db_data            =   $AdminModule->getList($data);

        $count 				=  	$AdminModule->getListCount($data);
        
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
    public function create(AdminModule $AdminModule){
        
        return view('admin.'.self::$moduleConfig['viewFolder'].'.create')->with('moduleConfig', self::$moduleConfig)->with('row', null);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (AdminModuleRequest $request){

        $newRecord                      = new AdminModule();
        $newRecord->name                = $request->name;
        $newRecord->controller          = $request->controller;
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
    public function show($id, AdminModule $AdminModule){

        $row = AdminModule::findOrFail($id);
        return view('admin.'.self::$moduleConfig['viewFolder'].'.show')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, AdminModule $AdminModule){

        $row = AdminModule::findOrFail($id);
        return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(AdminModuleRequest $request, $id){

        // dd($request->all());
        $updateRecord = AdminModule::findOrFail($id);
        $updateRecord->name               = $request->name;
        $updateRecord->controller         = $request->controller;
        $updateRecord->status             = $request->input('status', 0);
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
        
        $row = AdminModule::findOrFail($id);
        $row->delete();
        \Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
