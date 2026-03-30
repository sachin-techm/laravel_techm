@include('flash::message')
<style type="text/css">
    .table td, .table th{
        vertical-align: middle;
    }
</style>
<div class="row">
    <div class="col-md-12">
        
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ isset($row) && !empty($row) ? 'Edit' : 'Add' }} {{$moduleConfig['moduleTitle']}} For Role "{{$role->name}}"</h3>
                </div>
            </div>
            
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th rowspan="2">Module Name</th>
                        <th rowspan="2">Access</th>
                        <th colspan="3" class="text-center">Actions</th>
                    </tr>

                    <tr>
                        <th class="text-center">View</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                    </tr>
                    
                    @if($adminModules->count())
                        @foreach($adminModules as $value)                         
                        <tr>
                            <td>{{$value->name}}=>{{$value->controller}} </td>
                            <td class="text-center">
                                <span class="switch switch-icon">
                                    <label>
                                        <input type="checkbox" name="permission_data[{{$value->controller}}][index]" value="1" {{ (array_key_exists($value->controller, $row->permission_data) ? 'checked' : '')}} />
                                        <span></span>
                                    </label>
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="checkbox-inline justify-content-center">
                                    <label class="checkbox theme-text-color">
                                        <input type="checkbox" name="permission_data[{{$value->controller}}][view]" value="1" {{ (array_key_exists('view', ($row->permission_data[$value->controller] ?? [])) ? 'checked' : '')}} />
                                        <span></span>
                                        
                                    </label>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="checkbox-inline justify-content-center">
                                    <label class="checkbox theme-text-color">
                                        <input type="checkbox" name="permission_data[{{$value->controller}}][edit]" value="1" {{ (array_key_exists('edit', ($row->permission_data[$value->controller] ?? [])) ? 'checked' : '')}} />
                                        <span></span>
                                        
                                    </label>
                                </div>
                            </td>
                            
                            <td class="text-center">
                                <div class="checkbox-inline justify-content-center">
                                    <label class="checkbox theme-text-color">
                                        <input type="checkbox" name="permission_data[{{$value->controller}}][delete]" value="1" {{ (array_key_exists('delete', ($row->permission_data[$value->controller] ?? [])) ? 'checked' : '')}} />
                                        <span></span>
                                        
                                    </label>
                                </div>
                            </td>
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