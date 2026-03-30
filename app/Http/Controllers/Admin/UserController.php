<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ExportUser;
use App\Traits\UserTrait;
use App\Models\Country;
use FileUploadHelper;
use ImageUploadHelper;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Image;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | {{moduleTitle}} Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles create, update, delete and show list of {{moduleTitle}}.
    |
    */
    use UserTrait;
    public static $moduleConfig = [
        "routes" => [
            "listRoute" => 'admin.user.index',
            "fetchDataRoute" => 'admin.user.fetch.data',
            "createRoute" => 'admin.user.create',
            "storeRoute" => 'admin.user.store',
            "editRoute" => 'admin.user.edit',
            "updateRoute" => 'admin.user.update',
            "deleteRoute" => 'admin.user.delete',
        ],
        "moduleTitle" => 'Customers',
        "moduleName" => 'user',
        "viewFolder" => 'user',
        "imageUploadFolder" => 'uploads/users/',
    ];

    /**
     * Constructor Method.
     *
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
     * @param  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        return view('admin.' . self::$moduleConfig['viewFolder'] . '.index')
            ->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Fetch data for datatable via ajax request for {{moduleTitle}}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $User
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function fetchData(Request $request, User $User)
    {
        $data = $request->all();
        $db_data = $User->getList($data,['country', 'state', 'city']);
        $count = $User->getListCount($data);
        $returnArray = array(
            'data' => $db_data,
            'meta' => array(
                'page' => $data['pagination']['page'] ?? 1,
                'pages' => $data['pagination']['pages'] ?? 1,
                'perpage' => $data['pagination']['perpage'] ?? 10,
                'total' => $count,
                'sort' => $data['sort']['sort'] ?? 'asc',
                'field' => $data['sort']['field'] ?? '_id',
            ),
        );
        return $returnArray;
    }

    /**
     * Show create form of {{moduleTitle}}.
     *
     * @return \Illuminate\Http\Response | \Illuminate\Contracts\View\View
     */
    public function create()
    {   
        $countries      = Country::where('status', 1)->orderBy('name', 'asc')->get();
        return view('admin.' . self::$moduleConfig['viewFolder'] . '.create')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', null)
            ->with('countries', $countries);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function store(UserRequest $request)
    {
        $res = $this->storeUpdate($request);
        \Flash::success(self::$moduleConfig['moduleTitle'] . ' created successfully.');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

    /**
     * Show show  form of {{moduleTitle}}.
     *
     * @param  int $id
     * @param  \App\Models\User $User
     * @return \Illuminate\Http\Response | \Illuminate\Contracts\View\View
     */
    public function show($id)
    {        
        $row = User::findOrFail($id);
        return view('admin.' . self::$moduleConfig['viewFolder'] . '.show ')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', $row);
    }

    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response | \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $row = User::findOrFail($id);
        $countries      = Country::where('status', 1)->orderBy('name', 'asc')->get();
        return view('admin.' . self::$moduleConfig['viewFolder'] . '.edit')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', $row)
            ->with('countries', $countries);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse 
     * @param  int $id
     */
    public function update(UserRequest $request, $id)
    {        
        $this->storeUpdate($request, $id);
        \Flash::success(self::$moduleConfig['moduleTitle'] . ' updated successfully.');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

    /**
     * Delete {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function delete($id)
    {        
        $row = User::findOrFail($id);
        $row->delete();
        \Flash::success(self::$moduleConfig['moduleTitle'].' deleted successfully.'); 
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

    public function export(Request $request)
    {
        return Excel::download(new ExportUser(), 'User-'.now()->setTimezone('Asia/Kolkata')->format('d-M-Y-H-i-s').'.xlsx');
    }
}
