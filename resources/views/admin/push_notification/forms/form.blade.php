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
                                <input type="text" name="title" value="{{ old('title', $row->title ?? '') }}"
                                    class="form-control" placeholder="Enter Title" required />
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Body</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <textarea rows="3" type="text" class="form-control" name="body" placeholder="Enter Body" required>{{ old('body', $row->body ?? '') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">All Users</label>
                            <div class="col-3">
                                <span class="switch switch-icon">
                                    <label>
                                        <input type="checkbox" onchange="hideUserDropdown()" value="1" name="all_users" 
                                            {{ old('all_users', $row->all_users ?? 0) == '1' ? 'checked' : '' }} />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row validated" id="userDropdown">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Users</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <select class="form-control selectpicker" name="user_ids[]" tabindex="null" title="Select Users" multiple data-live-search="true">
                                    @if($users->count())
                                        @foreach($users as $value)

                                        <option {{ in_array($value->id, old('user_ids', $row->user_ids ?? [])) ?
                                            'selected' :'' }} value="{{$value->id}}">{{$value->fullName() . ' (' . $value->email . ') '}}
                                        </option>

                                        @endforeach
                                    @endif
                                </select>
                                @error('user_ids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated" id="userDropdown">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Topic</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <select class="form-control selectpicker" name="topic" tabindex="null" title="Select Topic">
                                    <option value="All">All</option>
                                    <option value="Promotional">Promotional</option>
                                    <option value="Offer">Offer</option>
                                    <option value="Order">Order</option>
                                    <option value="Test">Test</option>
                                    <option value="Course">Course</option>
                                </select>
                                @error('topic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Image</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                
                                <div class="image-input image-input-outline" id="image" style="background-image: url('{{asset("assets/backend/media/users/blank_Img.jpg")}}')">

                                    @if(isset($row->image) && !empty($row->image))
                                        <div class="image-input-wrapper" style="background-image: url('{{asset("uploads/push_notifications/".$row->image)}}')"></div>
                                    @else
                                        <div class="image-input-wrapper image_base64"></div>
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
                    
                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Status</label>
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


@push('scripts')
<script type="text/javascript">
    var avtat4 = new KTImageInput('image');

    avtat4.on('cancel', function(imageInput) {
        swal.fire({
            title: 'Image successfully cancelled!',
            type: 'success',
            buttonsStyling: false,
            confirmButtonText: 'Okay!',
            confirmButtonClass: 'btn btn-primary font-weight-bold'
        });
    });

    avtat4.on('change', function(imageInput) {        
    });

    avtat4.on('remove', function(imageInput) {
        swal.fire({
            title: 'Image successfully removed !',
            type: 'error',
            buttonsStyling: false,
            confirmButtonText: 'Got it!',
            confirmButtonClass: 'btn btn-primary font-weight-bold'
        });
    });

    function hideUserDropdown() {
        var toggleChecked = $('input[name=all_users]').prop('checked');
        if (toggleChecked) {
            $('#userDropdown').hide();
        } else {
            $('#userDropdown').show();
        }
    }

</script>
@endpush