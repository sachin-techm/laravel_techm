<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use Auth;
use Hash;


class MyTestController extends Controller
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
     * Get Courses api
     *
     * @param  \Illuminate\Http\Request $request
     * @param string|int $id_or_slug | null
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function getMyTests(Request $request, $id_or_slug = NULL)
    {
        try {

            $user = Auth::guard('api')->user();
            
            $validation = Validator::make($request->all(), [
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

            // Order::$shouldAppends = false;
            // $orders = Order::where(
            //     [
            //         'type' => 2, 
            //         'user_id' => $user->id, 
            //         'status' => 'SUCCESS', 
            //         'payment_status' => 'SUCCESS'
            //     ])
            //     ->where('test_id', '<>', NULL)->get()->pluck('test_id');

            // if(empty($orders)) {

            //     return $this->jsonResponse(false, $results, "No record found");
            // }
            
            Result::$shouldAppends = false;
            Order::$shouldAppends = false;
            QuestionSet::$shouldAppends = false;
            $queryModel = Order::query();
            $queryModel->where('user_id', $user->id);
            $queryModel->where('status', 'SUCCESS');
            $queryModel->where('payment_status', 'SUCCESS');
            $queryModel->where('type', 2);
            $queryModel->with('questionSet', 'questionSet.subject', 'questionSet.category', 'questionSet.subcategory');
            $queryModel->with('questionSet.result.questionSet');
            $queryModel->with('questionSet.result', function ($query) use ($user) {
                $query->where('user_id', $user->id);
                // $query->makeHidden('meta');
            });
            $queryModel->whereHas('questionSet');

            if (!empty($id_or_slug)) {

                if (is_numeric($id_or_slug)) {
                    $queryModel->where('id', $id_or_slug);
                    $queryModel->with('questionSet.questionSetDetails');
                    $queryModel->with('questionSet.questionSetDetails.question');
                    
                } else if (is_string($id_or_slug)) {
                    // $queryModel->where('slug', $id_or_slug);
                }
            }

            if ($request->has('subject_id') && $request->filled('subject_id')) {
                $queryModel->where('subject_id', $request->subject_id);
            }

            if ($request->has('category_id') && $request->filled('category_id')) {
                $queryModel->where('category_id', $request->category_id);
            }

            if ($request->has('subcategory_id') && $request->filled('subcategory_id')) {
                $queryModel->where('subcategory_id', $request->subcategory_id);
            }

            if ($request->has('mark_as_featured') && $request->filled('mark_as_featured')) {
                $queryModel->where('mark_as_featured', $request->mark_as_featured);
            }

            if ($request->has('search') && $request->filled('search')) {
                $searchKey = $request->search;
                $queryModel->whereHas('questionSet', function ($query) use ($searchKey) {
                    $query->where('set_name', 'LIKE', '%'.$searchKey.'%');
                });
            }
            
            $queryModel->orderBy('created_at', 'DESC');
            $results = $queryModel->get();

            if(empty($results->count())){
                
                return $this->jsonResponse(false, null, "No record found");
            }

            return $this->jsonResponse(true, $results, "Record found");

        } catch (\Exception $e) {
            
            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }
    }
}