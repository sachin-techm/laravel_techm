
<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Show <?php echo e($moduleConfig['moduleTitle']); ?> Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Title:</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left"><?php echo e($row->title ?? 'N/A'); ?></label>
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left title-case">Description:</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left"><?php echo $row->description ?? 'N/A'; ?></label>
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Image:</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <div class="image-input image-input-outline" id="image_1" style="background-image: url('<?php echo e(asset("assets/backend/media/users/blank.png")); ?>')">
                                            <?php if(isset($row->feature_image) && !empty($row->feature_image)): ?>
                                                <div class="image-input-wrapper" style="background-image: url('<?php echo e(asset("uploads/posts/thumbnails/250/".$row->feature_image)); ?>')"></div>
                                            <?php else: ?>
                                                <div class="image-input-wrapper image_base64"></div>
                                            <?php endif; ?>
                                        </div>                                    
                                    </div>
                                </div>

                                <div class="form-group row validated">
                                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Status: </label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <label class="col-form-label text-lg-left">
                                            <?php echo $row->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>

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
                                <a class="btn btn-light-danger" href="<?php echo e(route($moduleConfig['routes']['listRoute'])); ?>" aria-label="Back">
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/post/show.blade.php ENDPATH**/ ?>