<?php
namespace App\Http\Controllers\Admin;
use App\Http\Requests\TestimonialRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use ImageUploadHelper;
use Carbon\Carbon;
use Image;
use Hash;
use Auth;

class TestimonialController extends Controller
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
            "listRoute" => 'admin.testimonial.index',
            "fetchDataRoute" => 'admin.testimonial.fetch.data', 
            "createRoute" => 'admin.testimonial.create', 
            "storeRoute" => 'admin.testimonial.store', 
            "editRoute" => 'admin.testimonial.edit', 
            "updateRoute" => 'admin.testimonial.update', 
            "deleteRoute" => 'admin.testimonial.delete'
        ],
        "moduleTitle" => 'Testimonial',
        "moduleName" => 'testimonial',
        "viewFolder" => 'testimonial',
        "imageUploadFolder" => 'uploads/testimonials/',
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

    public function fetchData(Request $request, Testimonial $testimonial)
	{		
		$data               =   $request->all();
        $db_data            =   $testimonial->getList($data);
        $count 				=  	$testimonial->getListCount($data);

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
    public function create(Testimonial $testimonial)
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
    public function store (TestimonialRequest $request)
    {
    	$testimonial                     = new Testimonial();
    	$testimonial->name 				 = $request->name;
    	$testimonial->organization 		 = $request->organization;
    	$testimonial->description	     = $request->description;
        $testimonial->status             = $request->input('status', 0);
        $testimonial->created_by         = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('name'), 1000, 600, true);
            $testimonial->image  = $fileName;
        }

    	$testimonial->save();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' created successfully');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

	/**
     * Show show  form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id, Testimonial $testimonial)
    {
    	$row = Testimonial::findOrFail($id);
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
    public function edit($id, Testimonial $testimonial)
    {
    	$row = Testimonial::findOrFail($id);
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
    public function update(TestimonialRequest $request, $id)
    {
    	$testimonial 				     = Testimonial::findOrFail($id);
    	$testimonial->name               = $request->name;
        $testimonial->organization       = $request->organization;
        $testimonial->description        = $request->description;
        $testimonial->status             = $request->input('status', 0);
        $testimonial->updated_by         = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('name'), 1000, 600, true);
            $testimonial->image  = $fileName;
        }

    	$testimonial->save();
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
    	$row = Testimonial::findOrFail($id);
    	$row->delete();
    	\Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
