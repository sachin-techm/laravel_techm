@extends('layouts.backend')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container">

        @include('admin.includes.common.error')
            
        <form action="{{route($moduleConfig['routes']['updateRoute'], $row->id)}}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="{{$row->id}}">
            {{ csrf_field() }}
            @include('admin.'.$moduleConfig['viewFolder'].'.forms.form')
        </form>
    </div>
</div>
@endsection