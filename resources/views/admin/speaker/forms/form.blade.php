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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Speaker Type</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <select class="form-control selectpicker" name="speaker_type_id" tabindex="null" title="Speaker Type" required>
                                    @foreach($speakerTypes as $value)
                                        <option value="{{ $value->id }}" {{ (old('speaker_type_id', $row->speaker_type_id ?? '') == $value->id) ? 'selected' : '' }}> {{ $value->name }} </option>
                                    @endforeach
                                </select>
                                @error('speaker_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Name </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="name" value="{{ old('name', $row->name ?? '') }}" class="form-control" placeholder="Enter Name" required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Designation </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="designation" name="designation" value="{{ old('designation', $row->designation ?? '') }}" class="form-control" placeholder="Enter Designation" required />
                                @error('designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">LinkedIn </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="link" name="link" value="{{ old('link', $row->link ?? '') }}" class="form-control" placeholder="Enter LinkedIn url" required />
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Image:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="image-input image-input-outline" id="speakerImage" style="background-image: url({{ asset('assets/backend/media/users/blank.png') }})">
                                    @if(isset($row->image) && !empty($row->image))
                                        <div class="image-input-wrapper" style="background-image: url({{ asset('uploads/speakers/thumbnails/250/'.$row->image) }})"></div>
                                    @else
                                        <div class="image-input-wrapper"></div>
                                    @endif
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="image" class="__cropperjs" accept=".png, .jpg, .jpeg"  cropper_config='{"preview_target": "image .image-input-wrapper", "target": "image_base64", "aspectRatio1": "1", "aspectRatio2": "1"}'/>
                                        <input type="hidden" name="image_base64" id="image_base64" value="">
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
                    
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Status:</label>
                            <div class="col-3">
                                <span class="switch switch-icon">
                                    <label>
                                       <input type="checkbox" value="1" name="status" {{ old('status', $row->status ?? 1) == '1' ? 'checked' : '' }} />
                                        <span></span>
                                    </label>
                                </span>
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

<!-- include('admin.includes.common.cropperjs'); -->

@push('scripts')
<script type="text/javascript">
    var speakerImage = new KTImageInput('speakerImage');

    if(typeof speakerImage != 'underfined') {

        speakerImage.on('cancel', function(imageInput) {
            __sweetAlert('Image successfully canceled!', 'success');
        });

        speakerImage.on('change', function(imageInput) {
            console.log("speakerImage this==>", this);
        });

        speakerImage.on('remove', function(imageInput) {
            __sweetAlert('Image successfully removed!', 'error');
        });
    }
</script>
@endpush