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
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">User Name </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="name" value="{{ old('name') ? old('name') :( isset($row->name) ? $row->name : '') }}" class="form-control" required placeholder="Enter User Name" />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left">Email </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" name="email" value="{{ old('email') ? old('email') : ( isset($row->email) ? $row->email : '') }}" class="form-control" required placeholder="Enter Email"/>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                            </div>
                        </div>

                        <div class="form-group row validated">
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
                        </div>

                        <div class="form-group row validated">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-left"> Role </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <select class="form-control selectpicker" name="role_id" tabindex="null" required>
                                    <option value="">Select</option>
                                    @if($roles->count())
                                        @foreach($roles as $role)

                                           <option {{ !empty(old('role_id')) && old('role_id') == $role->id ? 'selected' : ( isset($row->role_id) && $row->role_id == $role->id ? 'selected' : '' ) }} value="{{$role->id}}">{{$role->name}}</option>

                                        @endforeach
                                    @endif
                                </select>
                                @error('role_id')
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
    

</script>
@endpush