<?php
namespace App\Http\Controllers\Admin;
use App\Http\Requests\SpeakerRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpeakerType;
use App\Models\Speaker;
use ImageUploadHelper;
use Carbon\Carbon;
use Image;
use Hash;
use Auth;

class SpeakerController extends Controller
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
            "listRoute" => 'admin.speaker.index',
            "fetchDataRoute" => 'admin.speaker.fetch.data', 
            "createRoute" => 'admin.speaker.create', 
            "storeRoute" => 'admin.speaker.store', 
            "editRoute" => 'admin.speaker.edit', 
            "updateRoute" => 'admin.speaker.update', 
            "deleteRoute" => 'admin.speaker.delete'
        ],
        "moduleTitle" => 'Speaker',
        "moduleName" => 'speaker',
        "viewFolder" => 'speaker',
        "imageUploadFolder" => 'uploads/speakers/',
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

    public function fetchData(Request $request, Speaker $speaker)
	{		
		$data               =   $request->all();
        $db_data            =   $speaker->getList($data,['speakerType']);
        $count 				=  	$speaker->getListCount($data);

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
    public function create(Speaker $speaker)
    {
    	$speakerTypes = SpeakerType::where('status', 1)->get();
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.create')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', null)
            ->with('speakerTypes', $speakerTypes);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  null
     * @return Redirect
     */
    public function store (SpeakerRequest $request)
    {
    	$speaker                     = new Speaker();
    	$speaker->name 				 = $request->name;
    	$speaker->designation 		 = $request->designation;
    	$speaker->speaker_type_id	 = $request->speaker_type_id;
    	$speaker->link			     = $request->link;
        $speaker->status             = $request->input('status', 0);
        $speaker->created_by         = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('name'), 1000, 600, true);
            $speaker->image  = $fileName;
        }

    	$speaker->save();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

	/**
     * Show show  form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id, Speaker $speaker)
    {
    	$row = Speaker::with('speakerType')->findOrFail($id);
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
    public function edit($id, Speaker $speaker)
    {
    	$speakerTypes = SpeakerType::where('status', 1)->get();
    	$row = Speaker::findOrFail($id);
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', $row)
            ->with('speakerTypes', $speakerTypes);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(SpeakerRequest $request, $id)
    {
    	$speaker 				     = Speaker::findOrFail($id);
    	$speaker->name               = $request->name;
        $speaker->designation        = $request->designation;
        $speaker->speaker_type_id    = $request->speaker_type_id;
        $speaker->link               = $request->link;
        $speaker->status             = $request->input('status', 0);
        $speaker->updated_by         = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('name'), 1000, 600, true);
            $speaker->image  = $fileName;
        }

    	$speaker->save();
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
    	$row = Speaker::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
