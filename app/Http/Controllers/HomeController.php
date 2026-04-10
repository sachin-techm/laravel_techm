<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\AboutUsSetting;
use App\Traits\UserTrait;
use Carbon\Carbon;

use DB;
use Hash;
use Image;
use ImageUploadHelper;
use FileUploadHelper;

class HomeController extends Controller
{

    use UserTrait;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.home');
    }

    public function about()
    {
        $row = AboutUsSetting::where(['status' => 1, 'id' => 1])->first();

        return view('frontend.about');
    }


}
