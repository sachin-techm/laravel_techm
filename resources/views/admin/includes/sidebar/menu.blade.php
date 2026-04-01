@php 
    $helper     =   new \App\Helpers\Helper;
@endphp

<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav">
            <li class="menu-item {{$helper->isActivate(['admin.dashboard'])}}" aria-haspopup="true">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <i class="flaticon-layer "></i>
                    </span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            
            @php

            $rolePermissionArr = session('rolePermission');

            @endphp 

            @if(\Helper::isSuperAdmin('AdminUserControllerController', $rolePermissionArr))
                @include('admin/includes/sidebar/admin_user')
            @endif

            @if(\Helper::isSuperAdmin('UserRoleController', $rolePermissionArr))
                @include('admin/includes/sidebar/role')
            @endif
            
            @if(\Helper::isSuperAdmin('AdminModuleController', $rolePermissionArr))
                @include('admin/includes/sidebar/admin_module')
            @endif

            <li class="menu-section">
                <h4 class="menu-text">User Data</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>

            @if(\Helper::isSuperAdmin('PostController', $rolePermissionArr))
                @include('admin/includes/sidebar/post')
            @endif

            @if(\Helper::isSuperAdmin('UserController', $rolePermissionArr))
                @include('admin/includes/sidebar/user')
            @endif

            @if(\Helper::isSuperAdmin('SeakerController', $rolePermissionArr))
                @include('admin/includes/sidebar/speaker')
            @endif

            @if(\Helper::isSuperAdmin('ScheduleController', $rolePermissionArr))
                @include('admin/includes/sidebar/schedule')
            @endif

            @if(\Helper::isSuperAdmin('SponsorController', $rolePermissionArr))
                @include('admin/includes/sidebar/sponsor')
            @endif

            @if(\Helper::isSuperAdmin('EditionController', $rolePermissionArr))
                @include('admin/includes/sidebar/edition')
            @endif

            @if(\Helper::isSuperAdmin('GalleryController', $rolePermissionArr))
                @include('admin/includes/sidebar/gallery')
            @endif

            @if(\Helper::isSuperAdmin('TestimonialController', $rolePermissionArr))
                @include('admin/includes/sidebar/testimonial')
            @endif

            @if(\Helper::isSuperAdmin('PushNotificationController', $rolePermissionArr))
                @include('admin/includes/sidebar/push_notification')
            @endif

            <!-- <li class="menu-section">
                <h4 class="menu-text">Masters</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li> -->
            
            <!-- New Section Start -->
            <li class="menu-section">
                <h4 class="menu-text">Settings</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>

        	@if(\Helper::checkPermisson('SmsTemplateController', $rolePermissionArr) || \Helper::checkPermisson('EmailTemplateController', $rolePermissionArr))
            	@include('admin/includes/sidebar/template', $rolePermissionArr)

            @endif

            @if(\Helper::checkPermisson('SystemSettingsController', $rolePermissionArr) || \Helper::checkPermisson('AdminController', $rolePermissionArr))
                @include('admin/includes/sidebar/system_settings')

            @endif

        </ul>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>