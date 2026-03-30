@extends('layouts.app')

@section('title', __('Server Error'))

@section('content')
	
<div class="limiter">
    <div class="container-login100">
        <div class="w-full">
           <div class="text-center">
              
           </div>
        </div>
        <div class="wrap-login100 ">
        	<div class="alert-danger alert">
           	 	{{  \Session::get('alert-danger') }}
           	</div>
           	<div class="alert-danger alert hide d-none">
           	 	{{  \Session::get('alert-file') }}
           	</div>
           	<div class="alert-danger alert hide d-none">
           	 	{{  \Session::get('alert-line') }}
           	</div>
        </div>
    </div>
</div>   

@endsection
