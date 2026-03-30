@extends('layouts.backend')
@section('title', __('Server Error'))
@section('content')
<section class="error-page">
    <div class="container error-content">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{ asset('assets/backend/media/error/404.png') }}" alt="404 Error" class="error-image">
                <h2 class="content">OOPS! Something went wrong here.</h2>
                <h1 class="component">Nothing to see here!</h1>
                <p>
                    The page you are looking for has been moved or doesn’t exist anymore. If you like, you can return to our 
                    <a href="{{ route('admin.dashboard') }}">homepage</a>. If the problem persists, please send us an email at 
                    <a href="mailto:developer@techmistriz.com">developer@techmistriz.com</a>.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection