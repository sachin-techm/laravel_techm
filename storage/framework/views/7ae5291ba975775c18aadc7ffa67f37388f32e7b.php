<li class="menu-item menu-item-submenu <?php echo e($helper->isActivate(['admin.sponsor.index', 'admin.sponsor.create', 'admin.sponsor.show', 'admin.sponsor.edit'])); ?>" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="flaticon2-user "></i>
        </span>
        <span class="menu-text">Sponsors</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item menu-item-parent" aria-haspopup="true">
                <span class="menu-link">
                    <span class="menu-text">Sponsors</span>
                </span>
            </li>

            <li class="menu-item <?php echo e($helper->isActivate(['admin.sponsor.create'])); ?>" aria-haspopup="true">
                <a href="<?php echo e(route('admin.sponsor.create')); ?>" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Add</span>
                </a>
            </li>

            <li class="menu-item <?php echo e($helper->isActivate(['admin.sponsor.index'])); ?>" aria-haspopup="true">
                <a href="<?php echo e(route('admin.sponsor.index')); ?>" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">List</span>
                </a>
            </li>         
        </ul>
    </div>
</li><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/includes/sidebar/sponsor.blade.php ENDPATH**/ ?>