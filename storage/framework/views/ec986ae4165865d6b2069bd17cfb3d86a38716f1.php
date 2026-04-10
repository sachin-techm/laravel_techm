<!DOCTYPE html>
<html lang="<?php echo e(App::getLocale()); ?>" dir="<?php echo e((App::isLocale('ar') ? 'rtl' : 'ltr')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo e($adminSettings->app_name); ?></title>
    <meta name="description" content="<?php echo e(@$metaData['description'] ?? ''); ?>">
    <meta name="keywords" content="<?php echo e(@$metaData['keywords'] ?? ''); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Place favicon.ico in the root directory -->
    <link href="<?php echo e(asset('/uploads/admins/favicons/thumbnails/250/'.$adminSettings->favicon)); ?>" type="img/x-icon" rel="shortcut icon">
    <!-- All css files are included here. -->
    <link rel="stylesheet" href="<?php echo e(asset('/assets/frontend/css/style.css')); ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <div id="app">
        <?php echo $__env->make('includes.headers.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main class="">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <?php echo $__env->make('includes.footers.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</body>
<?php echo $__env->yieldPushContent('scripts'); ?>
</html>
<?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/layouts/app.blade.php ENDPATH**/ ?>