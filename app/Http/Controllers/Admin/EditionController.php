<?php
namespace App\Http\Controllers\Admin;
use App\Http\Requests\EditionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Edition;
use ImageUploadHelper;
use Carbon\Carbon;
use Image;
use Hash;
use Auth;

class EditionController extends Controller
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
            "listRoute" => 'admin.edition.index',
            "fetchDataRoute" => 'admin.edition.fetch.data', 
            "createRoute" => 'admin.edition.create', 
            "storeRoute" => 'admin.edition.store', 
            "editRoute" => 'admin.edition.edit', 
            "updateRoute" => 'admin.edition.update', 
            "deleteRoute" => 'admin.edition.delete'
        ],
        "moduleTitle" => 'Edition',
        "moduleName" => 'edition',
        "viewFolder" => 'edition',
        "imageUploadFolder" => 'uploads/editions/',
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

    public function index(Request $request)
    {
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.index')->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Fetch data for datatable via ajax request for {{moduleTitle}}.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */

    public function fetchData(Request $request, Edition $edition)
	{		
		$data               =   $request->all();
        $db_data            =   $edition->getList($data);
        $count 				=  	$edition->getListCount($data);

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
    public function create(Edition $edition)
    {
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.create')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', null);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (EditionRequest $request)
    {
    	$edition                     = new Edition();
    	$edition->title 			 = $request->title;
    	$edition->location 		     = $request->location;
    	$edition->description	     = $request->description;
        $edition->status             = $request->input('status', 0);
        $edition->created_by         = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('name'), 1000, 600, true);
            $edition->image  = $fileName;
        }

    	$edition->save();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

	/**
     * Show show  form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id, Edition $edition)
    {
    	$row = Edition::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.show ')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', $row);
    }

	/**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Edition $edition)
    {
    	$row = Edition::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', $row);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(EditionRequest $request, $id)
    {
    	$edition 				     = Edition::findOrFail($id);
    	$edition->title              = $request->title;
        $edition->location           = $request->location;
        $edition->description        = $request->description;
        $edition->status             = $request->input('status', 0);
        $edition->updated_by         = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('name'), 1000, 600, true);
            $edition->image  = $fileName;
        }

    	$edition->save();
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
    	$row = Edition::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
