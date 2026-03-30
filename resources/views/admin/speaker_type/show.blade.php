@extends('layouts.backend')
@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Show {{$moduleConfig['moduleTitle']}} Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Name:</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">{{ $row->name ?? 'N/A' }}</label>
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