<div class="row mb-7 position-relative pt-2 pb-2 gallery-image" style="border: lightgray 1px dashed">
    <div class="col-12 mt-7">
        <div class="form-group row validated">
            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Gallery Image Alt</label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <input type="text" name="image_alt[]" value="{{ @old('image_alt', [$galleryImage->image_alt ?? ''])[0]}}" class="form-control" placeholder="Enter Gallery Image Alt"/>
                @error('image_alt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row validated">
            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Gallery Image</label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                @php
                $customClass = 'gallery-image-item';
                @endphp

                <div class="image-input image-input-outline {{$customClass}}" id="image_{{$galleryImageKey ?? '0'}}" data-galleryImage-id="{{ $galleryImage->id ?? ''}}" style="background-image: url('{{asset("assets/backend/media/users/blank_Img.jpg")}}')">

                    @if(isset($galleryImage->gallery_image) && !empty($galleryImage->gallery_image))
                        <div class="image-input-wrapper" style="background-image: url('{{asset("uploads/galleries/galleries/".$galleryImage->gallery_image)}}')"></div>
                    @else
                        <div class="image-input-wrapper image_{{$galleryImageKey ?? '0'}}_base64"></div>
                    @endif

                    @if(isset($galleryImage->gallery_image) && !empty($galleryImage->gallery_image))
                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="gallery_images[]" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="gallery_image_{{$galleryImageKey ?? '0'}}_remove"/>
                            <input type="hidden" name="gallery_image_ids[]" value="{{$galleryImage->id ?? 0}}" />
                        </label>
                    @else
                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="gallery_images[]" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="gallery_image_{{$galleryImageKey ?? '0'}}_remove"/>
                            <input type="hidden" name="gallery_image_ids[]" value="{{$galleryImage->id ?? 0}}" />
                        </label>
                    @endif

                    @if(isset($galleryImage->gallery_image) && !empty($galleryImage->gallery_image))
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove">
                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>
                    @else
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel">
                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="action-container" data-gallery-image-id="{{ $galleryImage->id ?? 0 }}">
        @if((isset($galleryImages) && isset($galleryImageKey) && @$galleryImageKey == count($galleryImages) - 1) || !isset($galleryImages))
            <a href="javascript:void(0)" onclick="addMoreGalleryImage(this)" class="btn btn-primary btn-sm" style="position: absolute;right: 0;top: -15px; back">+</a>
        @else
            <a href="javascript:void(0)" onclick="removeGalleryImage(this, {{ $galleryImage->id ?? 0 }})" class="btn btn-danger btn-sm" style="position: absolute;right: 0;top: -15px; back">X</a>
        @endif
    </div>
</div>


@push('scripts')
<script type="text/javascript">

    $(document).ready(function(){
        
        $('.gallery-image-item').each(function(){

            var id = $(this).attr('id');
            __home__initInputFile(id);

        });
        
    });

    function __home__initInputFile(id) {

        var home_images = new KTImageInput(id);

        home_images.on('change', function(imageInput) {
        });
        
        home_images.on('cancel', function(imageInput) {
            deleteGalleryImage(imageInput);                    
            imageInput.element.querySelector('.image-input-wrapper').style.backgroundImage = 'none';
            __sweetAlert('Image successfully cancelled !', 'success');
        });

        home_images.on('remove', function(imageInput) {
            deleteGalleryImage(imageInput);                    
            imageInput.element.querySelector('.image-input-wrapper').style.backgroundImage = 'none';
            __sweetAlert('Image successfully removed !', 'error');
        });
    }

    function deleteGalleryImage(imageInput) {
        var id = imageInput.element.getAttribute('data-galleryImage-id');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/gallery/delete-image') }}/" + id,
            datatype: 'json',
            success: function(response) {
                console.log('Image deleted successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error deleting image:', error);
            }
        });
    }

    function addMoreGalleryImage(_this){

        var length = ($(".gallery-image").length ?? 0);
        var imageUploaderHtml = `
            <div class="image-input image-input-outline gallery-image-item" id="gallery_image_${length}" style="background-image: url('{{asset("assets/backend/media/users/blank_Img.jpg")}}')">
                <div class="image-input-wrapper gallery_image_${length}_base64"></div>
                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                    <i class="fa fa-pen icon-sm text-muted"></i>
                    <input type="file" name="gallery_images[]" accept=".png, .jpg, .jpeg"/>
                    <input type="hidden" name="gallery_image_${length}_remove"/>
                    <input type="hidden" name="gallery_image_ids[]" value="0" />
                </label>
                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel">
                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                </span>
            </div>`;

        var html = '\
            <div class="row mb-7 position-relative pt-2 pb-2 gallery-image" style="border: lightgray 1px dashed">\
                <div class="col-12 mt-7">\
                    <div class="form-group row validated">\
                        <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Gallery Image Alt </label>\
                        <div class="col-lg-9 col-md-9 col-sm-12">\
                            <input type="text" name="image_alt[]" class="form-control" placeholder="Enter Gallery Image Alt" />\
                        </div>\
                    </div>\
                    <div class="form-group row validated">\
                        <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Gallery Image </label>\
                        <div class="col-lg-9 col-md-9 col-sm-12">\
                            <input type="hidden" name="gallery_image_ids[]" value="0" />\
                            '+imageUploaderHtml+'\
                        </div>\
                    </div>\
                </div>\
                <div class="action-container" data-gallery-image-id="">\
                    <a href="javascript:void(0)" onclick="addMoreGalleryImage(this)" class="btn btn-primary btn-sm" style="position: absolute;right: 0;top: -15px; back">+</a>\
                </div>\
            </div>';        

            $('.action-container').html(`            
                <a href="javascript:void(0)" onclick="removeGalleryImage(this)" class="btn btn-danger btn-sm" style="position: absolute; right: 0; top: -15px;">X</a>`);

            $(".gallery-image:last").after(html);
            __home__initInputFile('gallery_image_'+length);
    }

    function removeGalleryImage(_this){
        var id2 = $(_this).parent().attr('data-gallery-image-id');
        if(id2 > 0){
            if(confirm('Are you sure')){
                $.ajax({
                    type: "GET",
                    url: "{{ url('delete-gallery-repeater') }}/" + id2,
                    datatype: 'json',
                    success: function (response) {
                        if(response?.status){
                            $(_this).parents('.gallery-image:first').remove();
                        } else {
                            alert(response?.message);
                        }
                    }
                });
            }
        } else {
            $(_this).parents('.gallery-image:first').remove();
        }
    }

</script>
@endpush
