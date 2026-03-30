<div class="modal fade" id="__cropperjs_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Cropper</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-12">
                            <canvas id="canvas">
                                Your browser does not support the HTML5 canvas element.
                            </canvas>
                            <p class="text-center text-danger" id="__cropperjs_modal_loading_text">Loading...</p>
                            <div id="result"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnCrop">Crop</button>
                <button type="button" class="btn btn-info" id="btnRestore">Reset</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        $('.__cropperjs').on( 'change', function(){
            $('#__cropperjs_modal_loading_text').show();
            $('#__cropperjs_modal').modal('show');
            const _this = this;
            setTimeout(function(){
    
                const cropperConfigStr = $(_this).attr('cropper_config');
                const cropperConfig = JSON.parse(cropperConfigStr);
                initCropper(_this, cropperConfig);
                $('#__cropperjs_modal_loading_text').hide();

            }, 1000);
        });
    });
    
    function initCropper(__this, cropperConfig = null, __aspectRatio = 5 / 2, btnCrop = '#btnCrop', btnRestore = '#btnRestore') {
    
        var canvas  = $("#__cropperjs_modal #canvas"),
        context     = canvas.get(0).getContext("2d");
        // context.clearRect(0, 0, canvas.width, canvas.height);
        // $(".cropper-container").html('');
        canvas.cropper && canvas.cropper('destroy');

        if (__this.files && __this.files[0]) {
            if ( __this.files[0].type.match(/^image\//) ) {
                var reader = new FileReader();
                reader.onload = function(evt) {
                    var img = new Image();
                    img.onload = function() {
    
                        // console.log("initCropper img.height==>", img.height);
                        // console.log("initCropper img.width==>", img.width);
    
                        context.canvas.height = img.height;
                        context.canvas.width  = img.width;
                        context.drawImage(img, 0, 0);
                        var cropper = canvas.cropper({
                            viewMode: 2,
                            // zoomOnWheel: false,
                            aspectRatio: cropperConfig?.aspectRatio1 ? (parseInt(cropperConfig?.aspectRatio1) / parseInt(cropperConfig?.aspectRatio2)) : __aspectRatio
                        });
    
                        $(btnCrop).click(function() {

                            // Get a string base 64 data url
                            var croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png"); 
                            // $("#result").append( $('<img>').attr('src', croppedImageDataURL) );
                            // console.log("croppedImageDataURL==>", croppedImageDataURL);
    
                            if(cropperConfig) {

                                // set base64 to target selector
                                if(cropperConfig?.preview_target) {

                                    $("#" + cropperConfig?.preview_target).css('background-image', "url("+croppedImageDataURL+")");
                                }

                                if(cropperConfig?.target) {

                                    $("#" + cropperConfig?.target).val(croppedImageDataURL);
                                }

                                $('#__cropperjs_modal').modal('hide');
                            }
                        });
    
                        $(btnRestore).click(function() {
                           canvas.cropper('reset');
                           // $result.empty();
                        });
                    };

                    img.src = evt.target.result;
                };

                reader.readAsDataURL(__this.files[0]);
    
                // $('#__cropperjs_modal').modal('show');
            } else {

                alert("Invalid file type! Please select an image file.");
            }

        } else {

            alert('No file(s) selected.');
        }
    }
</script>
@endpush