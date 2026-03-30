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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left"> App Name:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="app_name" value="<?php echo e(old('app_name', $row->app_name ?? '')); ?>" class="form-control" required placeholder="Enter App Name"/>
                                <?php $__errorArgs = ['app_name'];
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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Admin Logo:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">                                
                                <div class="image-input image-input-outline" id="logo_image" style="background-image: url(<?php echo e(asset('assets/backend/media/users/blank.png')); ?>)">
                                    <?php if(isset($row->logo) && !empty($row->logo)): ?>
                                        <div class="image-input-wrapper" style="background-image: url(<?php echo e(asset('uploads/admins/logos/thumbnails/250/'.$row->logo)); ?>)"></div>
                                    <?php else: ?>
                                        <div class="image-input-wrapper"></div>
                                    <?php endif; ?>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="logo" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="image_remove"/>
                                    </label>
                                    <?php if(isset($row->logo) && !empty($row->logo)): ?>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php $__errorArgs = ['logo'];
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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Favicon:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">                                
                                <div class="image-input image-input-outline" id="favicon_image" style="background-image: url(<?php echo e(asset('assets/backend/media/users/blank.png')); ?>)">
                                    <?php if(isset($row->favicon) && !empty($row->favicon)): ?>
                                        <div class="image-input-wrapper" style="background-image: url(<?php echo e(asset('uploads/admins/favicons/thumbnails/250/'.$row->favicon)); ?>)"></div>
                                    <?php else: ?>
                                        <div class="image-input-wrapper"></div>
                                    <?php endif; ?>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="favicon" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="image_remove"/>
                                    </label>
                                    <?php if(isset($row->favicon) && !empty($row->favicon)): ?>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php $__errorArgs = ['favicon'];
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
   var avatarFavicon = new KTImageInput('favicon_image');

    avatarFavicon.on('cancel', function(imageInput) {
        swal.fire({
            title: 'Image successfully canceled !',
            type: 'success',
            buttonsStyling: false,
            confirmButtonText: 'Okay!',
            confirmButtonClass: 'btn btn-primary font-weight-bold'
        });
    });

    avatarFavicon.on('change', function(imageInput) {

        // swal.fire({
        //  title: 'Image successfully uploaded !',
        //  type: 'error',
        //  buttonsStyling: false,
        //  confirmButtonText: 'Okay!',
        //  confirmButtonClass: 'btn btn-primary font-weight-bold'
        // });
    });

    avatarFavicon.on('remove', function(imageInput) {
        swal.fire({
            title: 'Image successfully removed !',
            type: 'error',
            buttonsStyling: false,
            confirmButtonText: 'Got it!',
            confirmButtonClass: 'btn btn-primary font-weight-bold'
        });
    });

    var avatarLogo = new KTImageInput('logo_image');

    avatarLogo.on('cancel', function(imageInput) {
        swal.fire({
            title: 'Image successfully canceled !',
            type: 'success',
            buttonsStyling: false,
            confirmButtonText: 'Okay!',
            confirmButtonClass: 'btn btn-primary font-weight-bold'
        });
    });

    avatarLogo.on('change', function(imageInput) {

        // swal.fire({
        //  title: 'Image successfully uploaded !',
        //  type: 'error',
        //  buttonsStyling: false,
        //  confirmButtonText: 'Okay!',
        //  confirmButtonClass: 'btn btn-primary font-weight-bold'
        // });
    });

    avatarLogo.on('remove', function(imageInput) {
        swal.fire({
            title: 'Image successfully removed !',
            type: 'error',
            buttonsStyling: false,
            confirmButtonText: 'Got it!',
            confirmButtonClass: 'btn btn-primary font-weight-bold'
        });
    });
 

</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/admin_settings/forms/form.blade.php ENDPATH**/ ?>