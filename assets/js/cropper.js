window.onload = function () {
  'use strict';
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
					alert('Error data');
				}
			});
		});
	})
};