<li class="menu-item menu-item-submenu {{ $helper->isActivate(['admin.system_settings.index', 'admin.admin_settings.edit']) }}" aria-haspopup="true" data-menu-toggle="hover">

    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="flaticon2-gear "></i>
        </span>
        <span class="menu-text">System Settings</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item menu-item-parent" aria-haspopup="true">
                <span class="menu-link">
                    <span class="menu-text">System Settings</span>
                </span>
            </li>
            <li class="menu-item" aria-haspopup="true">
                <a href="{{route('admin.system_settings.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">System Config</span>
                </a>
            </li>

            @if(\Helper::checkPermisson('AdminSettingsController', $rolePermissionArr))
                <li class="menu-item {{ $helper->isActivate(['admin.admin_settings.index', 'admin.admin_settings.create', 'admin.admin_settings.edit', 'admin.admin_settings.show']) }}" aria-haspopup="true">
                    <a href="{{route('admin.admin_settings.edit', 1)}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Admin Settings</span>
                    </a>
                </li>
            @endif
            
        </ul>
    </div>
</li>