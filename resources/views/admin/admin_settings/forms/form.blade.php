@include('flash::message')

<div class="row">
    <div class="col-md-12">
        
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ isset($row) && !empty($row) ? 'Edit' : 'Add' }} {{$moduleConfig['moduleTitle']}}</h3>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-8">
                        
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left"> App Name:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="app_name" value="{{ old('app_name', $row->app_name ?? '') }}" class="form-control" required placeholder="Enter App Name"/>
                                @error('app_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Admin Logo:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">                                
                                <div class="image-input image-input-outline" id="logo_image" style="background-image: url({{asset('assets/backend/media/users/blank.png')}})">
                                    @if(isset($row->logo) && !empty($row->logo))
                                        <div class="image-input-wrapper" style="background-image: url({{asset('uploads/admins/logos/thumbnails/250/'.$row->logo)}})"></div>
                                    @else
                                        <div class="image-input-wrapper"></div>
                                    @endif
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="logo" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="image_remove"/>
                                    </label>
                                    @if(isset($row->logo) && !empty($row->logo))
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    @else
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    @endif
                                </div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror                            
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Favicon:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">                                
                                <div class="image-input image-input-outline" id="favicon_image" style="background-image: url({{asset('assets/backend/media/users/blank.png')}})">
                                    @if(isset($row->favicon) && !empty($row->favicon))
                                        <div class="image-input-wrapper" style="background-image: url({{asset('uploads/admins/favicons/thumbnails/250/'.$row->favicon)}})"></div>
                                    @else
                                        <div class="image-input-wrapper"></div>
                                    @endif
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="favicon" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="image_remove"/>
                                    </label>
                                    @if(isset($row->favicon) && !empty($row->favicon))
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    @else
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    @endif
                                </div>
                                @error('favicon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror                            
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
                        <a class="btn btn-light-danger" href="{{ route($moduleConfig['routes']['listRoute']) }}" aria-label="Cancel">
                            <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
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
@endpush