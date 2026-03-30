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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">First Name </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="first_name" value="{{ old('first_name', $row->first_name ?? '') }}" class="form-control" placeholder="Enter First Name" required />
                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Last Name </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="last_name" value="{{ old('last_name', $row->last_name ?? '') }}" class="form-control" placeholder="Enter Last Name" required />
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Email </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="email" name="email" value="{{ old('email', $row->email ?? '') }}" class="form-control" placeholder="Enter Email" required />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Contact </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="contact" value="{{ old('contact', $row->contact ?? '') }}" class="form-control" placeholder="Enter Contact" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="10" />
                                @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Organization </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="organization" value="{{ old('organization', $row->organization ?? '') }}" class="form-control" placeholder="Enter Organization" required />
                                @error('organization')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Password </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="password" name="password" value="" class="form-control" {{isset($row->password) ? '':'required'}} placeholder="Enter Password" autocomplete="new-password" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Confirm Password </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="password" name="password_confirm" value="" class="form-control" {{isset($row->password) ? '':'required'}} placeholder="Enter Confirm Password" autocomplete="new-password_confirm" />
                                @error('password_confirm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                            </div>
                        </div> -->

                        <!-- <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Gender</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="male" {{ old('gender', $row->gender ?? '') == 'male' ? 'checked' : '' }} required />
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="female" {{ old('gender', $row->gender ?? '') == 'female' ? 'checked' : '' }} required />
                                    <label class="form-check-label">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="other" {{ old('gender', $row->gender ?? '') == 'other' ? 'checked' : '' }} required />
                                    <label class="form-check-label">Other</label>
                                </div>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> -->

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Country</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <select class="form-control selectpicker" name="country_id" tabindex="null" onchange="getState()" data-live-search="true"  title="Select Country">
                                    @if($countries->count())
                                        @foreach($countries as $value)
                                          <option {{ (old('country_id') ?? optional($row)->country_id) == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">State</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <select class="form-control selectpicker" name="state_id" tabindex="null" onchange="getCity()" data-live-search="true" title="Select State"> </select>
                                @error('state_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">City</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <select class="form-control selectpicker" name="city_id" tabindex="null" data-live-search="true" title="Select City">
                                </select>
                                @error('city_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Pin Code</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="number" name="pin_code" value="{{ old('pin_code', $row->pin_code ?? '') }}" class="form-control" placeholder="Enter Pin Code" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                                @error('pin_code')
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

    $(document).ready(function(){        
        getState();
    });

    function getState() {

        var country_id = $('select[name=country_id]').val();
        if (country_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('states') }}?country_id=" + country_id,
                dataType: 'json',
                success: function (response) {
                    if (response && response.status) {
                        var options = '<option value="">Select State</option>';
                        if (response.data.length) {

                            var selectedId = '{{ $row->state_id ?? old('state_id') }}';

                            for (var i = 0; i < response?.data?.length; i++) {
                                var _selected = '';

                                if (selectedId == response?.data?.[i].id) {
                                    _selected = 'selected';
                                }

                                options += '<option ' + _selected + ' value="' + response?.data?.[i].id + '">' + response?.data?.[i].name + '</option>';
                            }

                            $("select[name='state_id']").html(options);
                            $("select[name='state_id']").selectpicker('refresh');
                            getCity();
                        }
                    } else {

                        $("select[name='state_id']").html('<option value="">Select State</option>');
                        $("select[name='state_id']").selectpicker('refresh');
                    }
                }
            });

        } else {

            $("select[name='state_id']").html('<option value="">Select State</option>');
            $("select[name='state_id']").selectpicker('refresh');
        }
    }

    function getCity() {

        var state_id = $('select[name=state_id]').val();

        if (state_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('cities') }}?state_id=" + state_id,
                datatype: 'json',
                success: function (response) {
                    if (response && response.status) {
                        var options = '<option value="">Select City</option>';
                        if (response.data.length) {

                            var selectedId = '{{ $row->city_id ?? old('city_id') }}';

                            for (var i = 0; i < response.data.length; i++) {
                                var _selected = '';

                                if (selectedId == response.data[i].id) {
                                    _selected = 'selected';
                                }

                                options += '<option ' + _selected + ' value="' + response.data[i].id + '">' + response.data[i].name + '</option>';
                            }

                            $("select[name='city_id']").html(options);
                            $("select[name='city_id']").selectpicker('refresh');
                        }
                    }
                }
            });

        } else {
            
            $("select[name='city_id']").html('<option value="">Select City</option>');
            $("select[name='city_id']").selectpicker('refresh');
        }
    }

</script>
@endpush