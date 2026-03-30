<li class="menu-item menu-item-submenu {{ $helper->isActivate(['admin.question_set.index', 'admin.question_set.create', 'admin.question_set.edit']) }}" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="flaticon2-checking "></i>
        </span>
        <span class="menu-text">Question Set</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item menu-item-parent" aria-haspopup="true">
                <span class="menu-link">
                    <span class="menu-text">Question Set</span>
                </span>
            </li>
            <li class="menu-item {{ $helper->isActivate(['admin.question_set.index']) }}" aria-haspopup="true">
                <a href="{{route('admin.question_set.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Question Set List</span>
                </a>
            </li>
            <li class="menu-item {{ $helper->isActivate(['admin.question_set.create']) }}" aria-haspopup="true">
                <a href="{{route('admin.question_set.create')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Add Question Set</span>
                </a>
            </li>
        </ul>
    </div>
</li>