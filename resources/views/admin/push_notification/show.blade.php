@extends('layouts.backend')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container">

        <div class="row">
            <div class="col-md-12">

                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Show {{$moduleConfig['moduleTitle']}} Account Details</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-8">

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Title</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">{{ $row->title ?? 'N/A' }}</label>
                                    </div>
                                </div>

                                 <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Body</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">{!! $row->body ?? 'N/A' !!}</label>
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">All Users</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">{{ $row->all_users ? 'Yes' : 'No' }}</label>
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Users</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">{{ implode(', ', $row->getUserName() ?? 'N/A') }}</label>
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left title-case">Topic</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">{{ $row->topic ?? 'N/A' }}</label>
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left title-case">Channel</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">{{ $row->channel ?? 'N/A' }}</label>
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Image</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <div class="image-input image-input-outline" style="background-image: url('{{asset("assets/backend/media/users/blank_Img.jpg")}}')">
                                            @if(isset($row->image) && !empty($row->image))
                                                <div class="image-input-wrapper" style="background-image: url('{{asset( "uploads/push_notifications/".$row->image )}}')"></div>
                                            @else
                                                <div class="image-input-wrapper"></div>
                                            @endif
                                        </div>                                
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Status: </label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">
                                            {!! $row->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4 text-center">
                                <a class="btn btn-light-danger" href="{{ route($moduleConfig['routes']['listRoute']) }}" aria-label="Back">
                                    <i class="fa fa-fw fas fa-chevron-left"></i>Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection