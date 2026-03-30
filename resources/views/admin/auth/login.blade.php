<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($logo->favicon) && !empty($logo->favicon))
        <link rel="icon" type="image/x-icon" href="{{ asset('uploads/admins/favicons/thumbnails/250/'. $logo->favicon)}}">
    @else
        <link rel="icon" type="image/x-icon" href="">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($logo->app_name) && !empty($logo->app_name))
        <title>{{$logo->app_name}}</title>
    @else
        <title>Demo</title>
    @endif
    <link href="{{asset('assets/backend/login/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/backend/login/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/backend/login/css/style.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  </head>
  <body>
    <section class="form-style">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="form-box">
              <div class="row">
                <div class="col-5 link">
                  <div class="form-box-a">
                    <div class="form-logo">
                        <a href="#" class="text-center mb-10">
                           @if(isset($logo->logo) && !empty($logo->logo))
                                <img src="{{ asset('uploads/admins/logos/thumbnails/250/'. $logo->logo) }}" class="max-h-70px" alt="">
                            @else
                                <img src="{{ asset('public/media/users/blank.png') }}" class="max-h-70px" alt="">
                            @endif
                        </a>
                        @if(isset($logo->app_name) && !empty($logo->app_name))
                            <h2>Welcome to</h2>
                            <h2>{{$logo->app_name}}</h2>
                        @endif
                    </div>
                  </div>
                </div>
                <div class="col-7">
                  <div class="_mn_df">
                    <div class="main-head">
                      <h2>Login to your account</h2>
                    </div>
                    <form method="POST" action="{{ route('admin.login') }}" class="form fv-plugins-bootstrap fv-plugins-framework mx-8" novalidate="novalidate" id="kt_login_signin_form">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg @error('email') is-invalid @enderror" type="text" placeholder="Enter Email" required="" aria-required="true">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative">
                            <input type="password" name="password" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg password-toggle-input @error('password') is-invalid @enderror" type="text" placeholder="Enter Password" required="" aria-required="true">
                            <i class="fas fa-eye password-toggle-icon d-none" aria-hidden="true"></i>
                            <i class="fas fa-eye-slash password-toggle-icon" aria-hidden="true"></i>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="checkbox">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"{{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember"> {{ __('Remember Me') }} </label>
                            </div>
                          <a href="#">Forgot Password</a>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary form-control">Login</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.querySelector('.password-toggle-input');
        const showIcon = document.querySelector('.fa-eye');
        const hideIcon = document.querySelector('.fa-eye-slash');

        showIcon.addEventListener('click', function() {
            passwordInput.type = 'password';
            showIcon.classList.add('d-none');
            hideIcon.classList.remove('d-none');
        });

        hideIcon.addEventListener('click', function() {
            passwordInput.type = 'text';
            hideIcon.classList.add('d-none');
            showIcon.classList.remove('d-none');
        });
    });
</script>
