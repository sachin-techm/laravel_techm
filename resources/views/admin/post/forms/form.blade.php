@include('flash::message')
<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ isset($row) && !empty($row) ? 'Edit' : 'Add' }}
                    {{$moduleConfig['moduleTitle']}}</h3>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-8">

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Title</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="title" value="{{ old('title', $row->title ?? '') }}" class="form-control" placeholder="Enter Title" required />
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Short Description </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <textarea name="short_description" class="form-control" placeholder="Enter Short Description">{{ old('short_description', $row->short_description ?? '') }}</textarea>
                                @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Description </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <textarea name="description" class="form-control summernote-editor" placeholder="Enter Description">{{ old('description', $row->description ?? '') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="col-4">
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Publish Date</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="input-group date">
                                    <input type="text" name="published_at" class="form-control kt_datepicker" value="{{ old('published_at', $row->published_at ?? '') }}" readonly placeholder="Select Publish Date"/>
                                    @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Feature Image:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="image-input image-input-empty image-input-outline" id="blogImage" style="background-image: url('{{ asset("assets/backend/media/users/blank.png") }}')">
                                    @if(isset($row->feature_image) && !empty($row->feature_image))
                                        <div class="image-input-wrapper" style="background-image: url('{{ asset("uploads/posts/".$row->feature_image) }}')"></div>
                                    @else
                                        <div class="image-input-wrapper"></div>
                                    @endif

                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="feature_image" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="image_remove"/>
                                    </label>

                                    @if(isset($row->feature_image) && !empty($row->feature_image))
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    @else
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div> 

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Feature Image Alt</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="feature_image_alt" value="{{ old('feature_image_alt', $row->feature_image_alt ?? '') }}" class="form-control" placeholder="Enter Feature Image Alt"/>
                                @error('feature_image_alt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>                               

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Status</label>
                            <div class="col-3">
                                <span class="switch switch-icon">
                                    <label>
                                        <input type="checkbox" value="1" name="status" {{old('status', $row->status ?? 1) == '1' ? 'checked' : ''}}>
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


@push('scripts')
<script type="text/javascript">
    var blogImage = new KTImageInput('blogImage');

    if(typeof blogImage != 'underfined') {

        blogImage.on('cancel', function(imageInput) {
            __sweetAlert('Image successfully canceled!', 'success');
        });

        blogImage.on('change', function(imageInput) {
        });

        blogImage.on('remove', function(imageInput) {
            __sweetAlert('Image successfully removed!', 'error');
        });
    }
</script>
@endpush