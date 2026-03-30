<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use Auth;
use Hash;


class VerifyController extends Controller
{   

    /**
     * Comment
     */
    private $data;

    /**
     * Comment
     */
    public function __construct() {
       
    }

    /**
     * Comment
     */
    public function verifyOtp(Request $request)
    {
        
        
    }

}