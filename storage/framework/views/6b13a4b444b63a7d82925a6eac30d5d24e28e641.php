<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label"><?php echo e(isset($row) && !empty($row) ? 'Edit' : 'Add'); ?> <?php echo e($moduleConfig['moduleTitle']); ?></h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Name </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="name" value="<?php echo e(old('name', $row->name ?? '')); ?>" class="form-control" placeholder="Enter Name" required />
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Time </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="time" value="<?php echo e(old('time', $row->time ?? '')); ?>" class="form-control" placeholder="Enter Time" required />
                                <?php $__errorArgs = ['time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Description </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <textarea name="description" class="form-control summernote-editor" placeholder="Enter Description" required><?php echo e(old('description', $row->description ?? '')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div> 
                    
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Status:</label>
                            <div class="col-3">
                                <span class="switch switch-icon">
                                    <label>
                                       <input type="checkbox" value="1" name="status" <?php echo e(old('status', $row->status ?? 1) == '1' ? 'checked' : ''); ?> />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-center">
                        <button type="submit" class="btn btn-primary mr-2" aria-label="Submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Submit
                        </button>
                        <a class="btn btn-light-danger" href="<?php echo e(route($moduleConfig['routes']['listRoute'])); ?>" aria-label="Cancel">
                            <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- include('admin.includes.common.cropperjs'); -->

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    var testimonialImage = new KTImageInput('testimonialImage');

    if(typeof testimonialImage != 'underfined') {

        testimonialImage.on('cancel', function(imageInput) {
            __sweetAlert('Image successfully canceled!', 'success');
        });

        testimonialImage.on('change', function(imageInput) {
            console.log("testimonialImage this==>", this);
        });

        testimonialImage.on('remove', function(imageInput) {
            __sweetAlert('Image successfully removed!', 'error');
        });
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/schedule/forms/form.blade.php ENDPATH**/ ?>