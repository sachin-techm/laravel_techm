@extends('layouts.backend')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container">

        @include('admin.includes.common.error')
            
        <form action="{{ route($moduleConfig['routes']['storeRoute']) }}" method="POST" enctype="multipart/form-data">

         	{{ csrf_field() }}
            @include('admin.'.$moduleConfig['viewFolder'].'.forms.form')

        </form>
	</div>
</div>
@endsection
