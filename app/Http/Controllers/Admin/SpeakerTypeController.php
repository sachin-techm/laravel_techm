<?php
namespace App\Http\Controllers\Admin;
use App\Http\Requests\SpeakerTypeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpeakerType;
use Auth;

class SpeakerTypeController extends Controller
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
            "listRoute" => 'admin.speaker_type.index',
            "fetchDataRoute" => 'admin.speaker_type.fetch.data', 
            "createRoute" => 'admin.speaker_type.create', 
            "storeRoute" => 'admin.speaker_type.store', 
            "editRoute" => 'admin.speaker_type.edit', 
            "updateRoute" => 'admin.speaker_type.update', 
            "deleteRoute" => 'admin.speaker_type.delete'
        ],
        "moduleTitle" => 'Speaker Type',
        "moduleName" => 'speaker_type',
        "viewFolder" => 'speaker_type',
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
    	return view('admin.'.self::$moduleConfig['viewFolder'].'.index')
            ->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Fetch data for datatable via ajax request for {{moduleTitle}}.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public function fetchData(Request $request, SpeakerType $speakerType)
	{		
		$data               =   $request->all();
        $db_data            =   $speakerType->getList($data);
        $count 				=  	$speakerType->getListCount($data);

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
    public function create(SpeakerType $speakerType)
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
    public function store (SpeakerTypeRequest $request)
    {
    	$speakerType                 = new SpeakerType();
    	$speakerType->name 	         = $request->name;
        $speakerType->status         = $request->input('status', 0);
        $speakerType->created_by     = Auth::user()->id;
    	$speakerType->save();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

	/**
     * Show show  form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id, SpeakerType $speakerType)
    {
    	$row = SpeakerType::findOrFail($id);
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
    public function edit($id, SpeakerType $speakerType)
    {
    	$row = SpeakerType::findOrFail($id);
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
    public function update(SpeakerTypeRequest $request, $id)
    {
    	$speakerType 				= SpeakerType::findOrFail($id);
    	$speakerType->name 			= $request->name;
        $speakerType->status        = $request->input('status', 0);
        $speakerType->updated_by    = Auth::user()->id;
    	$speakerType->save();
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
    	$row = SpeakerType::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
