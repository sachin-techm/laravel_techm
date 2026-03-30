@extends('layouts.backend')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container">

        <div class="row">
		    <div class="col-md-12">
		        
		        <div class="card card-custom gutter-b">
		            <div class="card-header">
		                <div class="card-title">
		                    <h3 class="card-label"> {{$moduleConfig['moduleTitles'].' "'. $role[0]->name.'"' }}</h3>
		                </div>
		            </div>
		            
		            <form method="POST" action="{{ route($moduleConfig['routes']['permissionRoute']) }}">
		            	<?php
			            	$row = json_decode($row);
		            		if (!empty($row[0])) {
		            			$id = $row[0]->id;		            			
	                        	$permission = json_decode($row[0]->permission_data)->module;
		            		}else{
		            			$id = '';
		            			$row[0] = [];
		            			$permission  = [];

		            		}
                        ?>
		            	<input type="hidden" name="role_id" value="{{$role_id}}">
		            	<input type="hidden" name="id" value="{{$id}}">
		            	@error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
		            	      {{ csrf_field() }}
			            <div class="card-body">
							<table class="table">
			            		<tr>
	                            	<th>Module Name</th>
	                               	<th>Access</th>
	                            
	                            </tr>
                            	
			            	 	@if($modules->count())
	                            	@foreach($modules as $role)		            		
		                            <tr>
		                            	<td>{{$role->name}} </td>
		                               	<td><div class="col-3"><span class="switch switch-icon"><label>
										<input type="checkbox" value="{{$role->controller}}" name="modules[]" {{ (in_array($role->id, $permission) ? 'checked' : '')}} />
										<span></span></label></span></div></td>                            
		                            </tr>
		                        	@endforeach
	                        	@endif
		                    </table>
			            </div>

			            <div class="card-footer">
			                <div class="row">
			                    <div class="col-lg-4"></div>
			                    <div class="col-lg-4 text-center">
			                    	<button type="submit" class="btn btn-primary mr-2" aria-label="Submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Submit
                        </button>
			                        <a class="btn btn-primary" href="{{ route($moduleConfig['routes']['listRoute']) }}">Back</a>
			                    </div>
			                </div>
			            </div>
		            </form>

		        </div>
		    </div>

		</div>

    </div>
</div>
@endsection