const conFile = document.querySelector('.con-input-file')

const imgFile = document.querySelector('.bg')
const input = document.querySelector('.input')
const toast1 = document.getElementById('2')
const toast2 = document.getElementById('add_main_bloc2')

function dropHandler(evt) {
	var container = $(evt.target).closest('.con-input-file');
	$(container).removeClass('drop');
}

function dragOverHandler(evt) {
	var container = $(evt.target).closest('.con-input-file');
	$(container).addClass('drop');
}

function dragLeave(evt) {
	var container = $(evt.target).closest('.con-input-file');
	$(container).removeClass('drop');
} 

function dragEnter(evt) {
	var container = $(evt.target).closest('.con-input-file');
	$(container).addClass('drop');
}

function processFile(evt) {
	function getBase64(file) {
		var reader = new FileReader();
		reader.readAsDataURL(file);
		reader.onload = function () {
			var container = $(evt.target).closest('.con-input-file');
			$(container).addClass('hasFile');
			$(container).find('img').attr('src', reader.result);
		}
	}

	var file = evt.target.files[0];
	getBase64(file);
}

function handleClickRemove(evt) {
	var target 		= evt.target;
	var container 	= target.closest('.con-input-file');
	$(container).removeClass('hasFile');
	setTimeout(function() {
		$(container).find('img').attr('src', '');
	}, 250);
	$(container).find('input[type="file"]').val(null);
}