<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\Role;
use Carbon\Carbon;
use App\Http\Requests\EmailTemplateRequest;
use Hash;


class EmailTemplateController extends Controller
{   
    /*
    |--------------------------------------------------------------------------
    | {{moduleTitle}} Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles create, update, delete and show list of {{moduleTitle}}.
    |
    */

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

    public static $moduleConfig = [
        "routes" => [
            "listRoute" => 'admin.email_template.index',
            "fetchDataRoute" => 'admin.email_template.fetch.data', 
            "createRoute" => 'admin.email_template.create', 
            "storeRoute" => 'admin.email_template.store', 
            "editRoute" => 'admin.email_template.edit', 
            "updateRoute" => 'admin.email_template.update', 
            "deleteRoute" => 'admin.email_template.delete'
        ],
        "moduleTitle" => 'Email Template',
        "moduleName" => 'email_template',
        "viewFolder" => 'email_template',
        "imageUploadFolder" => 'uploads/email_templates/',
    ];


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

    public function fetchData(Request $request, EmailTemplate $EmailTemplate)
    {
        
        $data               =   $request->all();

        $db_data            =   $EmailTemplate->getList($data);

        $count 				=  	$EmailTemplate->getListCount($data);
        
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
    public function create(EmailTemplate $EmailTemplate){
        
        return view('admin.'.self::$moduleConfig['viewFolder'].'.create')->with('moduleConfig', self::$moduleConfig)->with('row', null);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (EmailTemplateRequest $request){

        $newRecord                      = new EmailTemplate();
        $newRecord->name                = $request->name;
        $newRecord->content                 = $request->content;
        $newRecord->subject                 = $request->subject;
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
    public function show($id, EmailTemplate $EmailTemplate){

        $row = EmailTemplate::findOrFail($id);
        return view('admin.'.self::$moduleConfig['viewFolder'].'.show')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, EmailTemplate $EmailTemplate){

        $row = EmailTemplate::findOrFail($id);
        return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(EmailTemplateRequest $request, $id){

        // dd($request->all());
        $updateRecord = EmailTemplate::findOrFail($id);
        $updateRecord->name                 = $request->name;
        $updateRecord->content              = $request->content;
        $updateRecord->subject              = $request->subject;
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
        
        $row = EmailTemplate::findOrFail($id);
        $row->delete();
        \Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
