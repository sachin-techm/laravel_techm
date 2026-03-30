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
                    <a class="btn btn-light-danger" href="{{ route($moduleConfig['routes']['editRoute']) }}" aria-label="Cancel">
                        <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel
                    </a>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
		        <div class="alert alert-custom alert-light-danger fade show mb-10" role="alert">
					<div class="alert-icon">
						<span class="svg-icon svg-icon-3x svg-icon-danger">
							<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Info-circle.svg-->
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24" />
									<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
									<rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />
									<rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />
								</g>
							</svg>
							<!--end::Svg Icon-->
						</span>
					</div>
					<div class="alert-text font-weight-bold">Configure user passwords to expire periodically. Users will need warning that their passwords are going to expire,
					<br />or they might inadvertently get locked out of the system!</div>
					<div class="alert-close">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">
								<i class="ki ki-close"></i>
							</span>
						</button>
					</div>
				</div>
		        <!-- end::Alert -->
		        <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="input-group input-group-lg input-group-solid">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                   <i class="la la-lock"></i>
                                </span>
                            </div>
                           	<input type="password" name="current_password"  class="form-control" required placeholder="Current Password"/>
                           	@error('current_password')
                            	<div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
				    <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
				    <div class="col-lg-9 col-xl-6">
				        <div class="input-group input-group-lg input-group-solid">
				            <div class="input-group-prepend">
				                <span class="input-group-text">
				                    <i class="la la-key"></i>
				                </span>
				            </div>
				            <input type="password" name="password" class="form-control form-control-lg form-control-solid" id="passwordInput" placeholder="New password" required>
				            <div class="input-group-append">
				                <span class="input-group-text" id="showPasswordToggle">
				                    <i class="fas fa-eye"></i>
				                </span>
				            </div>
				            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				        </div>
				    </div>
				</div>

				<div class="form-group row">
				    <label class="col-xl-3 col-lg-3 col-form-label">Verify Password</label>
				    <div class="col-lg-9 col-xl-6">
				        <div class="input-group input-group-lg input-group-solid">
				            <div class="input-group-prepend">
				                <span class="input-group-text">
				                    <i class="la la-key"></i>
				                </span>
				            </div>
				            <input type="password" name="password_confirmation" class="form-control form-control-lg form-control-solid" placeholder="Verify password" required>
				            @error('password_confirmation')
                            	<div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				        </div>
				    </div>
				</div>
		    </div>
		</div>
	</div>
	<!--end::Content-->
</div>

@push('scripts')
<script>
    document.getElementById('showPasswordToggle').addEventListener('click', function () {
        var passwordInput = document.getElementById('passwordInput');
        var icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endpush
