<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if(isset($logo->favicon) && !empty($logo->favicon)): ?>
        <link rel="icon" type="image/x-icon" href="<?php echo e(asset('uploads/admins/favicons/thumbnails/250/'. $logo->favicon)); ?>">
    <?php else: ?>
        <link rel="icon" type="image/x-icon" href="">
    <?php endif; ?>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(isset($logo->app_name) && !empty($logo->app_name)): ?>
        <title><?php echo e($logo->app_name); ?></title>
    <?php else: ?>
        <title>Demo</title>
    <?php endif; ?>
    <link href="<?php echo e(asset('assets/backend/login/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/backend/login/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/backend/login/css/style.css')); ?>" rel="stylesheet">
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
                           <?php if(isset($logo->logo) && !empty($logo->logo)): ?>
                                <img src="<?php echo e(asset('uploads/admins/logos/thumbnails/250/'. $logo->logo)); ?>" class="max-h-70px" alt="">
                            <?php else: ?>
                                <img src="<?php echo e(asset('public/media/users/blank.png')); ?>" class="max-h-70px" alt="">
                            <?php endif; ?>
                        </a>
                        <?php if(isset($logo->app_name) && !empty($logo->app_name)): ?>
                            <h2>Welcome to</h2>
                            <h2><?php echo e($logo->app_name); ?></h2>
                        <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="col-7">
                  <div class="_mn_df">
                    <div class="main-head">
                      <h2>Login to your account</h2>
                    </div>
                    <form method="POST" action="<?php echo e(route('admin.login')); ?>" class="form fv-plugins-bootstrap fv-plugins-framework mx-8" novalidate="novalidate" id="kt_login_signin_form">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" placeholder="Enter Email" required="" aria-required="true">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group position-relative">
                            <input type="password" name="password" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg password-toggle-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" placeholder="Enter Password" required="" aria-required="true">
                            <i class="fas fa-eye password-toggle-icon d-none" aria-hidden="true"></i>
                            <i class="fas fa-eye-slash password-toggle-icon" aria-hidden="true"></i>

                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="checkbox">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"<?php echo e(old('remember') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="remember"> <?php echo e(__('Remember Me')); ?> </label>
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
<?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>