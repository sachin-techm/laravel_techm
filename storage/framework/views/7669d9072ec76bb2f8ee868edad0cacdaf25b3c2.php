

<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column-fluid">
    <div class="container">

        <?php echo $__env->make('includes.common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
        <form action="<?php echo e(route($moduleConfig['routes']['storeRoute'])); ?>" method="POST" enctype="multipart/form-data">

            <?php echo e(csrf_field()); ?>

            <?php echo $__env->make('admin.'.$moduleConfig['viewFolder'].'.forms.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/sponsor/create.blade.php ENDPATH**/ ?>