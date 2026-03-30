<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;
use Validator;
use Auth;
use Hash;

class NotificationController extends Controller
{   

    /**
     * construct
     *
     */
    public function __construct()
    {
        // 
    }

    /**
     * Get notification api
     *
     * @param  \Illuminate\Http\Request $request
     * @param string|int $id_or_slug | null
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function index(Request $request, $id_or_slug = NULL)
    {
        try {

            $user = Auth::guard('api')->user();
            
            $validation = Validator::make(['id_or_slug' => $id_or_slug], [
                //'id_or_slug' => 'nullable|exists:jobs,id,slug',
            ]);

            $errors = $validation->errors();

            if (count($errors) > 0) {
                return response()->json([
                    'status' => false,
                    'message' => $errors->first(),
                    'data' => null
                ]);
            }

            Notification::$shouldAppends = false;
            $queryModel = Notification::query();
            $queryModel->where('user_id', $user->id);

            if (!empty($id_or_slug)) {

                if (is_numeric($id_or_slug)) {
                    $queryModel->where('id', $id_or_slug);
                } else if (is_string($id_or_slug)) {
                    $queryModel->where('slug', $id_or_slug);
                }
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

    /**
     * delete notification api
     *
     * @param  \Illuminate\Http\Request $request
     * @param string|int $id_or_slug | null
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function delete(Request $request, $id)
    {
        try {

            $user = Auth::guard('api')->user();
            
            $validation = Validator::make(['id' => $id], [
                //'id' => 'nullable|exists:jobs,id,slug',
            ]);

            $errors = $validation->errors();

            if (count($errors) > 0) {
                return response()->json([
                    'status' => false,
                    'message' => $errors->first(),
                    'data' => null
                ]);
            }

            $queryModel = Notification::query();
            $queryModel->where('user_id', $user->id);
            $queryModel->where('id', $id);
            $queryModel->delete();

            return $this->jsonResponse(true, null, "Notification deleted successfully");

        } catch (\Exception $e) {
            
            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }
    }
}