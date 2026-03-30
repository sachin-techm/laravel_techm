<!--begin::Profile Personal Information-->
<div class="d-flex flex-row">
    
    <!--begin::Aside-->
    @include('admin.admin_profile.inc.admin_profile_aside')
    <!--end::Aside-->

    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
        <!--begin::Card-->
        <div class="card card-custom card-stretch">
            <!--begin::Header-->
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                    <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
                </div>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-primary mr-2" aria-label="Save Changes">
                        <i class="fa fa-fw fa-lg fa-check-circle"></i>Save Changes
                    </button>
                    <a class="btn btn-light-danger" href="{{ url()->previous() }}" aria-label="Cancel">
                        <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel
                    </a>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                
                <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">User Image:</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">                                
                        <div class="image-input image-input-outline" id="admin_profile_image" style="background-image: url({{ asset('assets/backend/media/users/blank.png') }})">
                            @if(isset($row->image) && !empty($row->image))
                                <div class="image-input-wrapper" style="background-image: url({{ asset('uploads/admin_users/thumbnails/250/'.$row->image) }})"></div>
                            @else
                                <div class="image-input-wrapper"></div>
                            @endif
                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                <input type="hidden" name="image_remove"/>
                            </label>
                            @if(isset($row->image) && !empty($row->image))
                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            @else
                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            @endif
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror                            
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="input-group input-group-lg input-group-solid">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="la la-user"></i>
                                </span>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $row->name ?? '') }}" class="form-control" required placeholder="Name"/>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Contact Number</label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="input-group input-group-lg input-group-solid">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="la la-phone"></i>
                                </span>
                            </div>
                            <input type="phone" name="contact" value="{{ old('contact', $row->contact ?? '') }}" class="form-control" required placeholder="Contact Number" maxlength="10" />
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="input-group input-group-lg input-group-solid">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="la la-at"></i>
                                </span>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $row->email ?? '') }}" class="form-control" required placeholder="Email Address"/>
                        </div>
                    </div>
                </div>                          
            </div>
            <!--end::Body-->
        </div>
    </div>
    <!--end::Content-->
</div>
<!--end::Profile Personal Information-->

@push('scripts')
<script type="text/javascript">
    var admin_profile_image = new KTImageInput('admin_profile_image');

    admin_profile_image.on('cancel', function(imageInput) {
        showNotification('Image successfully canceled!', 'success');
    });

    admin_profile_image.on('change', function(imageInput) {
        // You can uncomment the following lines if needed
        /*
        showNotification('Image successfully uploaded!', 'error');
        */
    });

    admin_profile_image.on('remove', function(imageInput) {
        showNotification('Image successfully removed!', 'error');
    });

    function showNotification(message, type) {
        swal.fire({
            title: message,
            type: type,
            buttonsStyling: false,
            confirmButtonText: 'Okay!',
            confirmButtonClass: 'btn btn-primary font-weight-bold'
        });
    }
</script>
@endpush