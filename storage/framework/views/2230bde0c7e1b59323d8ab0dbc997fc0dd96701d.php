<li class="menu-item menu-item-submenu <?php echo e($helper->isActivate(['admin.admin_user.index', 'admin.admin_user.create', 'admin.admin_user.edit'])); ?>" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="flaticon2-user-1 "></i>
        </span>
        <span class="menu-text">Admin Users</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item menu-item-parent" aria-haspopup="true">
                <span class="menu-link">
                    <span class="menu-text">Admin Users</span>
                </span>
            </li>
            <li class="menu-item <?php echo e($helper->isActivate(['admin.admin_user.index'])); ?>" aria-haspopup="true">
                <a href="<?php echo e(route('admin.admin_user.index')); ?>" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">List</span>
                </a>
            </li>
            <li class="menu-item <?php echo e($helper->isActivate(['admin.admin_user.create'])); ?>" aria-haspopup="true">
                <a href="<?php echo e(route('admin.admin_user.create')); ?>" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Add</span>
                </a>
            </li>
        </ul>
    </div>
</li><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/includes/sidebar/admin_user.blade.php ENDPATH**/ ?>