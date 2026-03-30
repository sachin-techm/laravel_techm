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
                    <div class="col-8 gallery-images">
                        <h3 class="card-label"> Select Gallery </h3>
                        @if(isset($galleryImages) && !empty($galleryImages))
                            @foreach($galleryImages as $galleryImageKey => $galleryImage)
                                @include('admin.'.$moduleConfig['viewFolder'].'.forms.galery_image_repeater')
                            @endforeach
                        @else
                            @include('admin.'.$moduleConfig['viewFolder'].'.forms.galery_image_repeater')
                        @endif
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
