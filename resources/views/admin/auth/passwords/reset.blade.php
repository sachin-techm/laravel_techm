@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #F2C98A;">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <!--begin::Aside header-->
                <a href="#" class="text-center mb-10">
                <img src="{{asset('media/logos/logo.png')}}" class="max-h-70px" alt="">
                </a>
                <!--end::Aside header-->
                <!--begin::Aside title-->
                <!-- <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #986923;">Discover Amazing Metronic 
                    <br>with great build tools
                </h3> -->
                <!--end::Aside title-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url({{asset('image/login-visual-1.svg')}})"></div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin">
                    <!--begin::Form-->

                    <form method="POST" action="{{ route('password.update') }}" class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate" id="kt_login_signin_form">
                    	@csrf

                    	<input type="hidden" name="token" value="{{ $token }}">

                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Reset Password</h3>
                            <!-- <span class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password -->
                        </div>
                        <!--end::Title-->

                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <label class="font-size-h6 font-weight-bolder text-dark">E-Mail Address</label>

                            <input id="email" type="email" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="Email" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <label class="font-size-h6 font-weight-bolder text-dark">Password</label>

                            <input id="password" type="password" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <!--end::Form group-->
                        
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <label class="font-size-h6 font-weight-bolder text-dark">Confirm Password</label>

                            <input id="confirm-password" type="password" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg @error('password_confirmation') is-invalid @enderror" name="password_confirmation"  placeholder="Confirm Password" required autocomplete="new password">

                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <!--end::Form group-->
                        
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Reset Password</button>
                            
                        </div>
                        <!--end::Action-->
                        <input type="hidden">
                        <div></div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
                
            </div>
            <!--end::Content body-->
            
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
@endsection
