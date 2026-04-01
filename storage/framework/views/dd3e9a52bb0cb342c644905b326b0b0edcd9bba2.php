<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label"><?php echo e(isset($row) && !empty($row) ? 'Edit' : 'Add'); ?>

                    <?php echo e($moduleConfig['moduleTitle']); ?></h3>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-8">

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Title</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="title" value="<?php echo e(old('title', $row->title ?? '')); ?>" class="form-control" placeholder="Enter Title" required />
                                <?php $__errorArgs = ['title'];
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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Short Description </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <textarea name="short_description" class="form-control" placeholder="Enter Short Description"><?php echo e(old('short_description', $row->short_description ?? '')); ?></textarea>
                                <?php $__errorArgs = ['short_description'];
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
                                <textarea name="description" class="form-control summernote-editor" placeholder="Enter Description"><?php echo e(old('description', $row->description ?? '')); ?></textarea>
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

                    </div>

                    <div class="col-4">
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Publish Date</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="input-group date">
                                    <input type="text" name="published_at" class="form-control kt_datepicker" value="<?php echo e(old('published_at', $row->published_at ?? '')); ?>" readonly placeholder="Select Publish Date"/>
                                    <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Feature Image:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="image-input image-input-empty image-input-outline" id="blogImage" style="background-image: url('<?php echo e(asset("assets/backend/media/users/blank.png")); ?>')">
                                    <?php if(isset($row->feature_image) && !empty($row->feature_image)): ?>
                                        <div class="image-input-wrapper" style="background-image: url('<?php echo e(asset("uploads/posts/".$row->feature_image)); ?>')"></div>
                                    <?php else: ?>
                                        <div class="image-input-wrapper"></div>
                                    <?php endif; ?>

                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="feature_image" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="image_remove"/>
                                    </label>

                                    <?php if(isset($row->feature_image) && !empty($row->feature_image)): ?>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Feature Image Alt</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="feature_image_alt" value="<?php echo e(old('feature_image_alt', $row->feature_image_alt ?? '')); ?>" class="form-control" placeholder="Enter Feature Image Alt"/>
                                <?php $__errorArgs = ['feature_image_alt'];
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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Status</label>
                            <div class="col-3">
                                <span class="switch switch-icon">
                                    <label>
                                        <input type="checkbox" value="1" name="status" <?php echo e(old('status', $row->status ?? 1) == '1' ? 'checked' : ''); ?>>
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


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    var blogImage = new KTImageInput('blogImage');

    if(typeof blogImage != 'underfined') {

        blogImage.on('cancel', function(imageInput) {
            __sweetAlert('Image successfully canceled!', 'success');
        });

        blogImage.on('change', function(imageInput) {
        });

        blogImage.on('remove', function(imageInput) {
            __sweetAlert('Image successfully removed!', 'error');
        });
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/post/forms/form.blade.php ENDPATH**/ ?>