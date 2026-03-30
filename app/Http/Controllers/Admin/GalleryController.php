<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\GalleryDetail;
use App\Http\Requests\GalleryRequest;
use Illuminate\Http\Request;
use ImageUploadHelper;
use App\Models\Gallery;
use Carbon\Carbon;
use Image;
use Hash;
use Auth;

class GalleryController extends Controller
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
            "listRoute" => 'admin.gallery.index',
            "fetchDataRoute" => 'admin.gallery.fetch.data',
            "createRoute" => 'admin.gallery.create',
            "storeRoute" => 'admin.gallery.store',
            "editRoute" => 'admin.gallery.edit',
            "updateRoute" => 'admin.gallery.update',
            "deleteRoute" => 'admin.gallery.delete'
        ],

        "moduleTitle" => 'Galleries',
        "moduleName" => 'gallery',
        "viewFolder" => 'gallery',        
        "imageUploadFolder" => 'uploads/galleries/',
        "galleryImageUploadFolder" => 'uploads/galleries/galleries/',
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
        return view('admin.' . self::$moduleConfig['viewFolder'] . '.index')
            ->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Fetch data for datatable via ajax request for {{moduleTitle}}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery $gallery
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function fetchData(Request $request, Gallery $gallery)
    {
        $data        = $request->all();
        $db_data     = $gallery->getList($data);
        $count       = $gallery->getListCount($data);

        $returnArray = array(
            'data'          => $db_data,
            'meta'          => array(
                'page'      => $data['pagination']['page'] ?? 1,
                'pages'     => $data['pagination']['pages'] ?? 1,
                'perpage'   => $data['pagination']['perpage'] ?? 10,
                'total'     => $count,
                'sort'      => $data['sort']['sort'] ?? 'asc',
                'field'     => $data['sort']['field'] ?? '_id',
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
        return view('admin.' . self::$moduleConfig['viewFolder'] . '.create')
            ->with('row', null)
            ->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Create a new {{moduleTitle}}.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function store(GalleryRequest $request)
    {
        $gallery                          = new Gallery();
        $gallery->title                   = $request->title;
        $gallery->short_description       = $request->short_description;
        $gallery->status                  = $request->input('status', 0);
        $gallery->created_by              = Auth::user()->id;
        $gallery->save();

        if ($request->has('image_alt')) {

            $gallery_images_arr         = $request->file('gallery_images');
            $image_alt_Arr              = $request->image_alt;
            $gallery_image_ids_arr      = $request->gallery_image_ids;

            foreach ($request->image_alt as $key => $value) {
                if(
                    ( isset($gallery_images_arr[$key]) && !empty($gallery_images_arr[$key]) ) || 
                    ( isset($image_alt_Arr[$key]) && !empty($image_alt_Arr[$key]) )
                ){
                    $row  = GalleryDetail::find($gallery_image_ids_arr[$key]);
                    if(empty($row)){
                        $row  = new GalleryDetail();
                    }

                    if(isset($gallery_images_arr[$key]) && !empty($gallery_images_arr[$key])){
                        $imageFile = $gallery_images_arr[$key];
                        $fileName   = ImageUploadHelper::uploadImage(self::$moduleConfig['galleryImageUploadFolder'], $imageFile, $image_alt_Arr[$key], 1000, 400, true);
                        $row->gallery_image = $fileName;
                    }

                    $row->gallery_id            = $gallery->id;
                    $row->image_alt             = $image_alt_Arr[$key];
                    $row->created_by            = Auth::user()->id;
                    $row->status                = 1;
                    $row->save();
                }
            }
        }

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
        $row = Gallery::findOrFail($id);
        $galleryDetails = GalleryDetail::where(['status' => 1, 'gallery_id' => $row->id])->get();

        return view('admin.' . self::$moduleConfig['viewFolder'] . '.show ')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('galleryDetails', $galleryDetails)
            ->with('row', $row);
    }

    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Gallery $gallery)
    {
        $row             = Gallery::findOrFail($id);
        $galleryImages   = GalleryDetail::where(['status' => 1, 'gallery_id' => $row->id])->get();

        return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')
            ->with('row', $row)
            ->with('galleryImages', $galleryImages)
            ->with('moduleConfig', self::$moduleConfig);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(GalleryRequest $request, $id)
    {
        $gallery                          = Gallery::findOrFail($id);
        $gallery->title                   = $request->title;
        $gallery->short_description       = $request->short_description;
        $gallery->status                  = $request->input('status', 0);
        $gallery->created_by              = Auth::user()->id;
        $gallery->save();

        if ($request->has('image_alt')) {

            $gallery_images_arr         = $request->file('gallery_images');
            $image_alt_Arr      = $request->image_alt;
            $gallery_image_ids_arr      = $request->gallery_image_ids;

            foreach ($request->image_alt as $key => $value) {
                if(
                    ( isset($gallery_images_arr[$key]) && !empty($gallery_images_arr[$key]) ) || 
                    ( isset($image_alt_Arr[$key]) && !empty($image_alt_Arr[$key]) )
                ){
                    $row  = GalleryDetail::find($gallery_image_ids_arr[$key]);
                    if(empty($row)){
                        $row  = new GalleryDetail();
                    }

                    if(isset($gallery_images_arr[$key]) && !empty($gallery_images_arr[$key])){
                        $imageFile = $gallery_images_arr[$key];
                        $fileName   = ImageUploadHelper::uploadImage(self::$moduleConfig['galleryImageUploadFolder'], $imageFile, $image_alt_Arr[$key], 1000, 400, true);
                        $row->gallery_image = $fileName;
                    }

                    $row->gallery_id            = $request->id;
                    $row->image_alt             = $image_alt_Arr[$key];
                    $row->updated_by            = Auth::user()->id;
                    $row->status                = 1;
                    $row->save();
                }
            }
        }

        \Flash::success(self::$moduleConfig['moduleTitle'].' updated successfully.');
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
        $row = Gallery::findOrFail($id);
        $row->delete();
        \Flash::success(self::$moduleConfig['moduleTitle'] . ' deleted successfully.');
        return \Redirect::route(self::$moduleConfig['routes']['listRoute']);
    }

    public function deleteGalleryImage(Request $request, $id = null)
    {
        $row = GalleryDetail::find($id);
        if ($row) {
            ImageUploadHelper::deleteImage($row->gallery_image, self::$moduleConfig['galleryImageUploadFolder']);
            $row->gallery_image = null;
            $row->save();

            return response()->json(['status' => true, 'message' => 'Record deleted successfully.', 'data' => null]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record could not be deleted.',
            'data' => new \stdClass()
        ]);
    }

}