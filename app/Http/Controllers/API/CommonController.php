<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Carbon\Carbon;
use Validator;
use Auth;
use Hash;

class CommonController extends Controller
{

    /**
     * construct
     *
     */
    public function __construct()
    {
        // code
    }

    /**
     * Get country api
     *
     * @param  \Illuminate\Http\Request $request
     * @param string|int $id_or_slug | null
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function getCountries(Request $request, $id_or_slug = NULL)
    {

        try {

            $validation = Validator::make($request->all(), [
                // 'slug' => 'required',
            ]);

            $errors = $validation->errors();

            if (count($errors) > 0) {

                return response()->json([
                    'status' => false,
                    'message' => $errors->first(),
                    'data' => null
                ]);
            }

            Country::$shouldAppends = false;

            $queryModel = Country::query();
            $queryModel->where('status', 1);

            if (!empty($id_or_slug)) {

                if (is_numeric($id_or_slug)) {
                    $queryModel->where('id', $id_or_slug);
                } else if (is_string($id_or_slug)) {
                    $queryModel->where('slug', $id_or_slug);
                }
            }

            $queryModel->orderBy('name', 'ASC');
            $results = $queryModel->get();

            return $this->jsonResponse(true, $results, "Record found");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }

    }

    /**
     * Get regions api
     *
     * @param  \Illuminate\Http\Request $request
     * @param string|int $id_or_slug | null
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function getStates(Request $request, $id_or_slug = NULL)
    {

        try {

            $validation = Validator::make($request->all(), [
                // 'slug' => 'required',
            ]);

            $errors = $validation->errors();

            if (count($errors) > 0) {

                return response()->json([
                    'status' => false,
                    'message' => $errors->first(),
                    'data' => null
                ]);
            }

            State::$shouldAppends = false;

            $queryModel = State::query();
            $queryModel->where('status', 1);

            if (!empty($id_or_slug)) {

                if (is_numeric($id_or_slug)) {
                    $queryModel->where('id', $id_or_slug);
                } else if (is_string($id_or_slug)) {
                    $queryModel->where('slug', $id_or_slug);
                }
            }

            if ($request->has('country_id') && $request->filled('country_id')) {
                $searchKey = $request->country_id;
                $queryModel->where('country_id', $searchKey);
            }

            $queryModel->orderBy('name', 'ASC');
            $results = $queryModel->get();

            return $this->jsonResponse(true, $results, "Record found");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }

    }

    /**
     * Get regions api
     *
     * @param  \Illuminate\Http\Request $request
     * @param string|int $id_or_slug | null
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function getCities(Request $request, $id_or_slug = NULL)
    {

        try {

            $validation = Validator::make($request->all(), [
                // 'slug' => 'required',
            ]);

            $errors = $validation->errors();

            if (count($errors) > 0) {

                return response()->json([
                    'status' => false,
                    'message' => $errors->first(),
                    'data' => null
                ]);
            }

            City::$shouldAppends = false;

            $queryModel = City::query();
            $queryModel->where('status', 1);

            if (!empty($id_or_slug)) {

                if (is_numeric($id_or_slug)) {
                    $queryModel->where('id', $id_or_slug);
                } else if (is_string($id_or_slug)) {
                    $queryModel->where('slug', $id_or_slug);
                }
            }

            if ($request->has('region_id') && $request->filled('region_id')) {
                $searchKey = $request->region_id;
                $queryModel->where('state_id', $searchKey);
            }

            if ($request->has('state_id') && $request->filled('state_id')) {
                $searchKey = $request->state_id;
                $queryModel->where('state_id', $searchKey);
            }

            $results = $queryModel->get();

            if(empty($results->count())){
                
                return $this->jsonResponse(false, $results, "No record found");
            }
            
            return $this->jsonResponse(true, $results, "Record found");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }

    }

}