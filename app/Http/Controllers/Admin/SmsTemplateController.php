<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsTemplate;
use App\Models\Role;
use Carbon\Carbon;
use App\Http\Requests\SmsTemplateRequest;
use Hash;
use Image;
use ImageUploadHelper;

class SmsTemplateController extends Controller
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
            "listRoute" => 'admin.sms_template.index',
            "fetchDataRoute" => 'admin.sms_template.fetch.data', 
            "createRoute" => 'admin.sms_template.create', 
            "storeRoute" => 'admin.sms_template.store', 
            "editRoute" => 'admin.sms_template.edit', 
            "updateRoute" => 'admin.sms_template.update', 
            "deleteRoute" => 'admin.sms_template.delete'
        ],
        "moduleTitle" => 'Sms Template',
        "moduleName" => 'sms_template',
        "viewFolder" => 'sms_template',
        "imageUploadFolder" => 'uploads/sms_templates/',
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

    public function fetchData(Request $request, SmsTemplate $SmsTemplate)
	{
		
		$data               =   $request->all();

        $db_data            =   $SmsTemplate->getList($data);

        $count 				=  	$SmsTemplate->getListCount($data);

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
    public function create(SmsTemplate $SmsTemplate){
    	
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.create')->with('moduleConfig', self::$moduleConfig)->with('row', null);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (SmsTemplateRequest $request){

    	$newRecord 						= new SmsTemplate();
    	$newRecord->name 				= $request->name;
    	$newRecord->content 				= $request->content;
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
    public function show($id, SmsTemplate $SmsTemplate){

    	$row = SmsTemplate::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.show')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

	/**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, SmsTemplate $SmsTemplate){

    	$row = SmsTemplate::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(SmsTemplateRequest $request, $id){

    	// dd($request->all());

    	$updateRecord = SmsTemplate::findOrFail($id);
    	$updateRecord->name 				= $request->name;
    	$updateRecord->content 				= $request->content;
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
    	
    	$row = SmsTemplate::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
