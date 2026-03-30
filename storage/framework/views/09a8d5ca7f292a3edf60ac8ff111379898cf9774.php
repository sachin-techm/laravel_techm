<?php 
    $helper     =   new \App\Helpers\Helper;
?>

<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav">
            <li class="menu-item <?php echo e($helper->isActivate(['admin.dashboard'])); ?>" aria-haspopup="true">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <i class="flaticon-layer "></i>
                    </span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            
            <?php

            $rolePermissionArr = session('rolePermission');

            ?> 

            <?php if(\Helper::isSuperAdmin('AdminUserControllerController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/admin_user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Helper::isSuperAdmin('UserRoleController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/role', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            
            <?php if(\Helper::isSuperAdmin('AdminModuleController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/admin_module', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <li class="menu-section">
                <h4 class="menu-text">User Data</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>

            <?php if(\Helper::isSuperAdmin('UserController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Helper::isSuperAdmin('SeakerController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/speaker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Helper::isSuperAdmin('ScheduleController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/schedule', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Helper::isSuperAdmin('SponsorController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/sponsor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Helper::isSuperAdmin('EditionController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/edition', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Helper::isSuperAdmin('GalleryController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/gallery', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Helper::isSuperAdmin('TestimonialController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/testimonial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Helper::isSuperAdmin('PushNotificationController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/push_notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <!-- <li class="menu-section">
                <h4 class="menu-text">Masters</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li> -->
            
            <!-- New Section Start -->
            <li class="menu-section">
                <h4 class="menu-text">Settings</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>

        	<?php if(\Helper::checkPermisson('SmsTemplateController', $rolePermissionArr) || \Helper::checkPermisson('EmailTemplateController', $rolePermissionArr)): ?>
            	<?php echo $__env->make('admin/includes/sidebar/template', $rolePermissionArr, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php endif; ?>

            <?php if(\Helper::checkPermisson('SystemSettingsController', $rolePermissionArr) || \Helper::checkPermisson('AdminController', $rolePermissionArr)): ?>
                <?php echo $__env->make('admin/includes/sidebar/system_settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php endif; ?>

        </ul>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/includes/sidebar/menu.blade.php ENDPATH**/ ?>