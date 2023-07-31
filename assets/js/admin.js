const showToastr = (type, message, title) => {
	toastr.options = {
		closeButton: true,
		progressBar: true,
		onclick: null,
		timeOut: 4000,
	};

	toastr[type](message, title);
};

const errorHandler = (error) => {
	const { status, responseText = '{}' } = error;
	let responseJSON;

	try {
		responseJSON = error.responseJSON ? error.responseJSON : JSON.parse(responseText);
	} catch {
		responseJSON = {};
	}

	if(status === 401) {
		const { message = 'Terjadi Kesalahan' } = responseJSON;
		showToastr('info', message, 'Unauthorize');
		setTimeout(() => location.reload(), 1000);
	}
	else if(status === 404) {
		const { message = 'Resource Tidak ditemukan', title = 'Info' } = responseJSON;
		showToastr('info', message, title);
	}
	else if(status === 422) {
		const { $parentElement = $(document) } = error;
		const { form_errors = {} } = responseJSON;
		for(let key in form_errors) {
			$parentElement.find(`#${key}_feedback`).html(form_errors[key]);
		}
	}
	else if(status === 500) {
		const { message = 'Terjadi Kesalahan Pada Server' } = responseJSON;
		showToastr('error', message, 'Server Error');
	}
	else {
		const { message = 'Terjadi Kesalahan' } = responseJSON;
		showToastr('error', message, 'Error');
	}
}

const downloadFile = ({ file, fileName }) => {
	const $a = $('<a>');
	$a.attr('href', file);
	$a.attr('download', fileName);
	$('body').append($a);
	$a[0].click();
	$a.remove();
};

const MyBootstrap = {
	modalBodyScrollTop: function(selector = '.modal') {
		$(selector).on('show.bs.modal', function(){
			$(this).find('.modal-body').animate({ scrollTop: 0 }, 'slow');
		});
	},
};

const formatNumber = (num) => {
	return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(function(){
	// init Tooltip
	$('body').tooltip({
		selector: '.show-tooltip',
		trigger: 'hover',
	});

	MyBootstrap.modalBodyScrollTop();
});
