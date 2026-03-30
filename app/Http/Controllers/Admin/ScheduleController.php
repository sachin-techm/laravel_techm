<?php
namespace App\Http\Controllers\Admin;
use App\Http\Requests\ScheduleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use ImageUploadHelper;
use Carbon\Carbon;
use Image;
use Hash;
use Auth;

class ScheduleController extends Controller
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
            "listRoute" => 'admin.schedule.index',
            "fetchDataRoute" => 'admin.schedule.fetch.data', 
            "createRoute" => 'admin.schedule.create', 
            "storeRoute" => 'admin.schedule.store', 
            "editRoute" => 'admin.schedule.edit', 
            "updateRoute" => 'admin.schedule.update', 
            "deleteRoute" => 'admin.schedule.delete'
        ],
        "moduleTitle" => 'Schedule',
        "moduleName" => 'schedule',
        "viewFolder" => 'schedule',
        //"imageUploadFolder" => 'uploads/schedules/',
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

    public function fetchData(Request $request, Schedule $schedule)
	{		
		$data               =   $request->all();
        $db_data            =   $schedule->getList($data);
        $count 				=  	$schedule->getListCount($data);

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
    public function create(Schedule $schedule)
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
    public function store (ScheduleRequest $request)
    {
    	$schedule                     = new Schedule();
    	$schedule->name 			  = $request->name;
    	$schedule->time 		      = $request->time;
    	$schedule->description	      = $request->description;
        $schedule->status             = $request->input('status', 0);
        $schedule->created_by         = Auth::user()->id;
    	$schedule->save();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

	/**
     * Show show  form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id, Schedule $schedule)
    {
    	$row = Schedule::findOrFail($id);
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
    public function edit($id, Schedule $schedule)
    {
    	$row = Schedule::findOrFail($id);
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
    public function update(ScheduleRequest $request, $id)
    {
    	$schedule 				     = Schedule::findOrFail($id);
    	$schedule->name              = $request->name;
        $schedule->time              = $request->time;
        $schedule->description       = $request->description;
        $schedule->status            = $request->input('status', 0);
        $schedule->updated_by        = Auth::user()->id;
    	$schedule->save();
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
    	$row = Schedule::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
