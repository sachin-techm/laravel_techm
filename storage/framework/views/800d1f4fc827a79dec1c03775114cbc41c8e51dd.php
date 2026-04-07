

<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column-fluid">
    <div class="container">

        <?php echo $__env->make('admin.includes.common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
        <form action="<?php echo e(route($moduleConfig['routes']['updateRoute'], $role->id)); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?php echo e($row->id ?? 0); ?>">
            <input type="hidden" name="role_id" value="<?php echo e($role->id); ?>">
            <?php echo e(csrf_field()); ?>

            <?php echo $__env->make('admin.'.$moduleConfig['viewFolder'].'.forms.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/permission/edit.blade.php ENDPATH**/ ?>