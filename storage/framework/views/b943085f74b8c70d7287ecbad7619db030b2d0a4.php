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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Title: </label>
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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Image:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="image-input image-input-outline" id="sponsorImage" style="background-image: url(<?php echo e(asset('assets/backend/media/users/blank.png')); ?>)">
                                    <?php if(isset($row->image) && !empty($row->image)): ?>
                                        <div class="image-input-wrapper" style="background-image: url(<?php echo e(asset('uploads/sponsors/thumbnails/250/'.$row->image)); ?>)"></div>
                                    <?php else: ?>
                                        <div class="image-input-wrapper"></div>
                                    <?php endif; ?>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="image" class="__cropperjs" accept=".png, .jpg, .jpeg"  cropper_config='{"preview_target": "image .image-input-wrapper", "target": "image_base64", "aspectRatio1": "1", "aspectRatio2": "1"}'/>
                                        <input type="hidden" name="image_base64" id="image_base64" value="">
                                        <input type="hidden" name="image_remove"/>
                                    </label>
                                    <?php if(isset($row->image) && !empty($row->image)): ?>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php $__errorArgs = ['image'];
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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Link: </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                            <input type="text" name="link" value="<?php echo e(old('link', $row->link ?? '')); ?>" class="form-control" placeholder="Enter Link" required />
                                <?php $__errorArgs = ['link'];
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
    var sponsorImage = new KTImageInput('sponsorImage');

    if(typeof sponsorImage != 'underfined') {

        sponsorImage.on('cancel', function(imageInput) {
            __sweetAlert('Image successfully canceled!', 'success');
        });

        sponsorImage.on('change', function(imageInput) {
            console.log("sponsorImage this==>", this);
        });

        sponsorImage.on('remove', function(imageInput) {
            __sweetAlert('Image successfully removed!', 'error');
        });
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/sponsor/forms/form.blade.php ENDPATH**/ ?>