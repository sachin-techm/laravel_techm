<li class="menu-item menu-item-submenu <?php echo e($helper->isActivate(['admin.speaker.index', 'admin.speaker.create', 'admin.speaker.show', 'admin.speaker.edit','admin.speaker_type.index', 'admin.speaker_type.create', 'admin.speaker_type.show', 'admin.speaker_type.edit'])); ?>" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="flaticon2-user "></i>
        </span>
        <span class="menu-text">Speakers</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item menu-item-parent" aria-haspopup="true">
                <span class="menu-link">
                    <span class="menu-text">Speakers</span>
                </span>
            </li>

            <li class="menu-item <?php echo e($helper->isActivate(['admin.speaker.create'])); ?>" aria-haspopup="true">
                <a href="<?php echo e(route('admin.speaker.create')); ?>" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Add Speaker</span>
                </a>
            </li>

            <li class="menu-item <?php echo e($helper->isActivate(['admin.speaker.index'])); ?>" aria-haspopup="true">
                <a href="<?php echo e(route('admin.speaker.index')); ?>" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Speakers List</span>
                </a>
            </li> 

            <li class="menu-item <?php echo e($helper->isActivate(['admin.speaker_type.index'])); ?>" aria-haspopup="true">
                <a href="<?php echo e(route('admin.speaker_type.index')); ?>" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Speaker Types List</span>
                </a>
            </li>           
        </ul>
    </div>
</li><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/admin/includes/sidebar/speaker.blade.php ENDPATH**/ ?>