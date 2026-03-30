<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PushNotification;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Requests\PushNotificationRequest;
use Hash;
use Image;
use Auth;
use ImageUploadHelper;

class PushNotificationController extends Controller
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
            "listRoute" => 'admin.push_notification.index',
            "fetchDataRoute" => 'admin.push_notification.fetch.data',
            "createRoute" => 'admin.push_notification.create',
            "storeRoute" => 'admin.push_notification.store',
            "editRoute" => 'admin.push_notification.edit',
            "updateRoute" => 'admin.push_notification.update',
            "deleteRoute" => 'admin.push_notification.delete'
        ],

        "moduleTitle" => 'Push Notification',
        "moduleName" => 'push_notification',
        "viewFolder" => 'push_notification',
        "imageUploadFolder" => 'uploads/push_notifications/',
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
     * @param  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // $pushNotification = PushNotification::find(4);
        // return $res = \App\Notifications\FCMPushNotification::sendNotification($pushNotification);

        return view('admin.' . self::$moduleConfig['viewFolder'] . '.index')->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Fetch data for datatable via ajax request for {{moduleTitle}}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PushNotification $push_notification
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function fetchData(Request $request, PushNotification $push_notification)
    {

        $data = $request->all();

        $db_data = $push_notification->getList($data);

        $count = $push_notification->getListCount($data);

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
    public function create(Request $request)
    {   

        $row = PushNotification::find($request->id);

        $users = User::where(['status' => 1,])->where('firebase_token', '<>', NULL)->get();
        return view('admin.' . self::$moduleConfig['viewFolder'] . '.create')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('users', $users)
            ->with('row', $row);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function store(PushNotificationRequest $request)
    {
        $push_notification  = new PushNotification();

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('title'), 900, 900, true);
            $push_notification->image  = $fileName;
        }

        $push_notification->title         = $request->title;
        $push_notification->body          = $request->body;
        $push_notification->topic         = $request->topic;

        if ($request->has('user_ids') && $request->filled('user_ids')) {
            $push_notification->user_ids      = json_encode($request->user_ids);
        }
        
        $push_notification->all_users     = $request->input('all_users', 0);
        $push_notification->status        = $request->input('status', 1);
        $push_notification->created_by    = Auth::user()->id;
        $push_notification->save();

        \App\Notifications\FCMPushNotification::sendNotification($push_notification);
        \Flash::success(self::$moduleConfig['moduleTitle'] . ' created successfully');
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

        $row = PushNotification::findOrFail($id);
        return view('admin.' . self::$moduleConfig['viewFolder'] . '.show ')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Delete {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse 
     */

    public function delete($id)
    {

        $row = PushNotification::findOrFail($id);
        $row->delete();
        \Flash::success(self::$moduleConfig['moduleTitle'] . ' deleted successfully.');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

}
