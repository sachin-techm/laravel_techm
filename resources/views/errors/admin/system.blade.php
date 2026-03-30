@extends('layouts.app')

@section('title', __('Server Error'))

@section('content')
   

@php dd($error); @endphp

<div class="limiter">
    <div class="container-login100">
        <div class="w-full">
            <div class="text-center">
                
            </div>
        </div>
        <div class="wrap-login100 ">
           @if(!empty($error))
              @foreach($error as $key => $val)
               <div class="alert-danger alert">
                  {{  $val }}
               </div>
              @endforeach
           @else
                <div class="alert-success alert mt-5 text-center" style="font-size: 35px;">
                    Seems everything is fine.
                </div>
           @endif
        </div>
    </div>
</div>   


@endsection
