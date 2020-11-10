<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Base Meta/CSS -->
    <?php $this->view('components/common/meta_css', $data); ?>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/cropper/cropper.min.css'); ?>">
</head>

<body>

    <!-- Wrapper -->
	<div class="wrapper">

        <!-- Navbar -->
        <?php $this->view('components/common/navbar', $data); ?>
        <!-- End Navbar -->

        <!-- Main Content -->
        <div class="content my-3 my-md-5">

            <!-- Page Content -->
            <div class="container">

                <div class="row no-gutters overflow-hidden">
                    <div class="col-lg-2 pt-0">
                        <h3 class="page-title mb-2 mt-4">Media</h3>
                        <div class="pr-5">
                            <div class="list-group list-group-transparent mb-0">
                                <a href="<?php echo site_url('media'); ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fa fa-book"></i></span>Library
                                </a>
                                <a href="<?php echo site_url('media/upload'); ?>" class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                    <span class="icon mr-3"><i class="fa fa-plus-circle"></i></span>New Media
                                </a>
                                <a href="<?php echo current_url(); ?>" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    <span class="icon mr-3"><i class="fa fa-pencil"></i></span>Edit <?php echo $file_name; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10 mt-35">

                        <div class="row">
                            <div class="col-md-9">

                                <div class="img-container">
                                    <img id="cropper-image" src="<?php echo $file_path . '/' . $file_name; ?>" alt="Edit Image">
                                </div>
                                <input type="text" class="form-control mb-3" name="file_name" id="file_name" value="<?php echo $file_name; ?>">

                            </div>
                            <div class="col-md-3 mb-2">

                                <!-- Preview -->
                                <div class="mb-3 clearfix">
                                    <div class="cropper-preview lg"></div>
                                    <div class="cropper-preview md"></div>
                                    <div class="cropper-preview sm"></div>
                                    <div class="cropper-preview xs"></div>
                                </div>

                                <!-- Data -->
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">X</span>
                                    </div>
                                    <input type="text" class="form-control" id="dataX" placeholder="x" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Y</span>
                                    </div>
                                    <input type="text" class="form-control" id="dataY" placeholder="y" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Width</span>
                                    </div>
                                    <input type="text" class="form-control" id="dataWidth" placeholder="width" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Height</span>
                                    </div>
                                    <input type="text" class="form-control" id="dataHeight" placeholder="height" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rotate</span>
                                    </div>
                                    <input type="text" class="form-control" id="dataRotate" placeholder="rotate" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">deg</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">ScaleX</span>
                                    </div>
                                    <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX" readonly>
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">ScaleY</span>
                                    </div>
                                    <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY" readonly>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="cropper-buttons col-md-9">

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" id="zoom_in" data-method="zoom" data-option="0.1" title="Zoom In">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="zoom in">
                                            <span class="fa fa-search-plus"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" id="zoom_out" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="zoom out">
                                            <span class="fa fa-search-minus"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" id="move_left" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="move left">
                                            <span class="fa fa-arrow-left"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" id="move_right" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="move right">
                                            <span class="fa fa-arrow-right"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" id="move_up" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="move up">
                                            <span class="fa fa-arrow-up"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" id="move_down" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="move down">
                                            <span class="fa fa-arrow-down"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" id="rotate_left" data-method="rotate" data-option="-45" title="Rotate Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="rotate left">
                                            <span class="fa fa-rotate-right"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" id="rotate_right" data-method="rotate" data-option="45" title="Rotate Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="rotate right">
                                            <span class="fa fa-rotate-left"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" id="scale_x" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="flip horizontal">
                                            <span class="fa fa-arrows-h"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" id="scale_y" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="flip vertical">
                                            <span class="fa fa-arrows-v"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" id="reset" data-method="reset" data-option="-1" title="Reset">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="reset">
                                            <i class="fa fa-refresh"></i>
                                        </span>
                                    </button>
                                </div>

                            </div>

                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" id="save_btn" class="btn btn-primary spinner">Save changes</button>&nbsp;
                            <a href="<?php echo site_url('media'); ?>" class="btn btn-outline-primary" role="button">Cancel</a>
                        </div>

                    </div>

                </div>

            </div>
            <!-- End Page Content -->

		</div>
		<!-- End Main Content -->

        <!-- Footer -->
        <?php $this->view('components/common/footer', $data); ?>
        <!-- End Footer -->

    </div>
    <!-- End Wrapper -->

    <!-- Base Javascript -->
    <?php $this->view('components/common/javascript', $data); ?>
    <script src="<?php echo site_url('assets/vendor/cropper/cropper.min.js'); ?>" type="text/javascript"></script>

    <script type="text/javascript">
    $(function () {
    	var Cropper = window.Cropper;
    	var URL = window.URL || window.webkitURL;
    	var image = document.getElementById('cropper-image');
    	var download = document.getElementById('download');
    	var actions = document.getElementById('actions');
    	var dataX = document.getElementById('dataX');
    	var dataY = document.getElementById('dataY');
    	var dataHeight = document.getElementById('dataHeight');
    	var dataWidth = document.getElementById('dataWidth');
    	var dataRotate = document.getElementById('dataRotate');
    	var dataScaleX = document.getElementById('dataScaleX');
    	var dataScaleY = document.getElementById('dataScaleY');
    	var scaleX = 1;
    	var scaleY = 1;
    	var options = {
    		aspectRatio: 16 / 9,
            preview: '.cropper-preview',
            checkCrossOrigin: false,
    		ready: function (e) {
    			console.log(e.type);
    		},
    		cropstart: function (e) {
    			console.log(e.type, e.detail.action);
    		},
    		cropmove: function (e) {
    			console.log(e.type, e.detail.action);
    		},
    		cropend: function (e) {
    			console.log(e.type, e.detail.action);
    		},
    		crop: function (e) {
    			var data = e.detail;

    			console.log(e.type);
    			console.log(e.detail.x);
    			console.log(e.detail.y);
    			dataX.value = Math.round(data.x);
    			dataY.value = Math.round(data.y);
    			dataHeight.value = Math.round(data.height);
    			dataWidth.value = Math.round(data.width);
    			dataRotate.value = typeof data.rotate !== 'undefined' ? data.rotate : '';
    			dataScaleX.value = typeof data.scaleX !== 'undefined' ? data.scaleX : '';
    			dataScaleY.value = typeof data.scaleY !== 'undefined' ? data.scaleY : '';
    		},
    		zoom: function (e) {
    			console.log(e.type, e.detail.ratio);
    		}
        };

    	var cropper = new Cropper(image, options);

    	// Tooltip
    	$('[data-toggle="tooltip"]').tooltip();

    	$("#zoom_in").click(function(){
    		cropper.zoom(0.1);
    	});

    	$("#zoom_out").click(function(){
    		cropper.zoom(-0.1);
    	});

    	$("#move_left").click(function(){
    		cropper.move(-10, 0);
    	});

    	$("#move_right").click(function(){
    		cropper.move(10, 0);
    	});

    	$("#move_up").click(function(){
    		cropper.move(0, -10);
    	});

    	$("#move_down").click(function(){
    		cropper.move(0, 10);
    	});

    	$("#rotate_left").click(function(){
    		cropper.rotate(-45);
    	});

    	$("#rotate_right").click(function(){
    		cropper.rotate(45);
    	});

    	$("#scale_x").click(function(){
    		if (scaleX == -1) {
    			scaleX = 1;
    		}
    		else {
    			scaleX = -1;
    		}
    		cropper.scaleX(scaleX);
    	});

    	$("#scale_y").click(function(){
    		if (scaleY == -1) {
    			scaleY = 1;
    		}
    		else {
    			scaleY = -1;
    		}
    		cropper.scaleY(scaleY);
    	});

    	$("#reset").click(function(){
    		cropper.reset();
    	});

    	document.getElementById('save_btn').addEventListener('click', function(){
    		cropper.getCroppedCanvas().toBlob(function (blob) {
    			var formData = new FormData();
    			var filename = document.getElementById('file_name').value;
    			formData.append('croppedImage', blob);
    			// Use `jQuery.ajax` method
    			$.ajax("<?php echo site_url('media/ajax_upload/'); ?>" + filename, {
                    method: "POST",
                    crossDomain: true,
    				data: formData,
    				processData: false,
    				contentType: false,
    				success: function (){
    					console.log('Upload success');
    					window.location.href="<?php echo site_url('media'); ?>";
    				},
    				error: function (){
    					alert('Error: Unable to upload file');
    				}
    			});
    		});
    	})
    });
    </script>

</body>
</html>