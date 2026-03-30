<?php
namespace App\Http\Controllers\Admin;
use App\Http\Requests\SponsorRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsor;
use ImageUploadHelper;
use Carbon\Carbon;
use Image;
use Hash;
use Auth;

class SponsorController extends Controller
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
            "listRoute" => 'admin.sponsor.index',
            "fetchDataRoute" => 'admin.sponsor.fetch.data', 
            "createRoute" => 'admin.sponsor.create', 
            "storeRoute" => 'admin.sponsor.store', 
            "editRoute" => 'admin.sponsor.edit', 
            "updateRoute" => 'admin.sponsor.update', 
            "deleteRoute" => 'admin.sponsor.delete'
        ],
        "moduleTitle" => 'Sponsor',
        "moduleName" => 'sponsor',
        "viewFolder" => 'sponsor',
        "imageUploadFolder" => 'uploads/sponsors/',
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

    public function fetchData(Request $request, Sponsor $sponsor)
	{		
		$data               =   $request->all();
        $db_data            =   $sponsor->getList($data);
        $count 				=  	$sponsor->getListCount($data);

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
    public function create(Sponsor $sponsor)
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
    public function store (SponsorRequest $request)
    {
    	$sponsor                        = new Sponsor();
    	$sponsor->title 				= $request->title;
    	$sponsor->link	                = $request->link;
        $sponsor->status                = $request->input('status', 0);
        $sponsor->created_by            = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('image'), 1000, 600, true);
            $sponsor->image  = $fileName;
        }

    	$sponsor->save();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

	/**
     * Show show  form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id, Sponsor $sponsor)
    {
    	$row = Sponsor::findOrFail($id);
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
    public function edit($id, Sponsor $sponsor)
    {
    	$row = Sponsor::findOrFail($id);
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
    public function update(SponsorRequest $request, $id)
    {
    	$sponsor 				     = Sponsor::findOrFail($id);
    	$sponsor->title 			 = $request->title;
    	$sponsor->link	             = $request->link;
        $sponsor->status             = $request->input('status', 0);
        $sponsor->updated_by         = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('image'), 1000, 600, true);
            $sponsor->image  = $fileName;
        }

    	$sponsor->save();
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
    	$row = Sponsor::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
