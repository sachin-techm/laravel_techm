<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Form;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\GalleryDetail;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;

class AjaxController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get countries api
     *
     * @param  \Illuminate\Http\Request $request
     * @param string|int $id_or_slug | null
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function getCountry(Request $request)
    {

        $queryModel = State::query();
        $queryModel->where('status', 1);

        $results = $queryModel->orderBy('name', 'asc')->get();

        if($results->count()) {
            return ['status' => true, 'message' => 'Record found.', 'data' => $results];
        }

        return response()->json([
            'status' => false,
            'message' => 'No data found.',
            'data' => new \stdClass()
        ]);
    }
    
    public function getStates(Request $request, $id_or_slug = NULL)
    {

        $queryModel = \App\Models\State::query();
        $queryModel->where('status', 1);

        if (!empty($id_or_slug)) {

            if (is_numeric($id_or_slug)) {

                $queryModel->where('id', $id_or_slug);
            } else if (is_string($id_or_slug)) {

                $queryModel->where('name', $id_or_slug);
            }
        }

        if ($request->has('country_id') && $request->filled('country_id')) {
            $queryModel->whereIn('country_id', [$request->country_id]);
        }

        $results = $queryModel->orderBy('name', 'asc')->get();

        if($results->count()) {
            return ['status' => true, 'message' => 'Record found.', 'data' => $results];
        }

        return response()->json([
            'status' => false,
            'message' => 'No data found.',
            'data' => new \stdClass()
        ]);
    }
    
    public function getCity(Request $request, $id_or_slug = NULL)
    {

        $queryModel = City::query();
        $queryModel->where('status', 1);

        if (!empty($id_or_slug)) {

            if (is_numeric($id_or_slug)) {
                
                $queryModel->where('id', $id_or_slug);
            } else if (is_string($id_or_slug)) {

                $queryModel->where('name', $id_or_slug);
            }
        }

        if ($request->has('state_id') && $request->filled('state_id')) {
            $queryModel->whereIn('state_id', [$request->state_id]);
        }

        $results = $queryModel->orderBy('name', 'asc')->get();

        if($results->count()) {
            return ['status' => true, 'message' => 'Record found.', 'data' => $results];
        }

        return response()->json([
            'status' => false,
            'message' => 'No data found.',
            'data' => new \stdClass()
        ]);
    } 


    // delete section
    public function deleteGalleryRepeater(Request $request, $id = NULL)
    {
        $row = GalleryDetail::find($id);
        if($row) {
            \ImageUploadHelper::deleteImage($row->gallery_image, \App\Http\Controllers\Admin\GalleryController::$moduleConfig['galleryImageUploadFolder']);
            $row->forceDelete();
            return ['status' => true, 'message' => 'Record deleted successfully.', 'data' => null];
        }
        return response()->json([
            'status' => false,
            'message' => 'Record could not be deleted.',
            'data' => new \stdClass()
        ]);
    }
    
}
