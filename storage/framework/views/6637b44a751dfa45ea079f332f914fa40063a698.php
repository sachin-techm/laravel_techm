
<?php $__env->startSection('title', __('Server Error')); ?>
<?php $__env->startSection('content'); ?>
<section class="error-page">
    <div class="container error-content">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="<?php echo e(asset('assets/frontend/images/error/404.png')); ?>" alt="404 Error" class="error-image">
                <h2 class="content">OOPS! Something went wrong here.</h2>
                <h1 class="component">Nothing to see here!</h1>
                <p>
                    The page you are looking for has been moved or doesn’t exist anymore. If you like, you can return to our 
                    <a href="<?php echo e(route('admin.dashboard')); ?>">homepage</a>. If the problem persists, please send us an email at 
                    <a href="mailto:developer@techmistriz.com">developer@techmistriz.com</a>.
                </p>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/errors/404.blade.php ENDPATH**/ ?>