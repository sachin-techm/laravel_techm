@extends('layouts.backend')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container">

        @include('admin.includes.common.error')
        @include('flash::message')
            
        <form action="{{route($moduleConfig['routes']['updatePasswordRoute'])}}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            @include('admin.'.$moduleConfig['viewFolder'].'.forms.change_password');
        </form>
    </div>
</div>
@endsection