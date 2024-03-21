function onlyAlphabet(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode < 65 || charCode > 90)&&(charCode < 97 || charCode > 122)&&charCode>32&&charCode > 57)
		return false;
	return true;
}

function onlyNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode > 57))
		return false;
	return true;
}

function autoFormInput(data, tipe) {
	for(var key in data) {
		$('[name="'+key+'"]').val(data[key]);
		if(tipe == "viewed") {
			$('[name="'+key+'"]').attr("disabled", 'disabled');
		}
	}
}

function formatPhoneNumber() {
	var cleavePN = new Cleave('.phone-number', {
		phone: true,
		phoneRegionCode: 'id'
	});
}

$('.daterange-cus').daterangepicker({
	locale: {format: 'YYYY-MM-DD'},
	drops: 'down',
	opens: 'right'
});


$(document).ready(function () {
	bsCustomFileInput.init();
});

$('.data-tables').DataTable({
	responsive: true,
	"oLanguage": {
		"sEmptyTable": "Tidak ada data",
		"sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
		"sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
		"sInfoFiltered": "",
		"sZeroRecords": "Tidak ditemukan data yang sesuai",
		"oPaginate": {
			"sFirst": "Pertama",
			"sLast": "Terakhir",
			"sNext": "Selanjutnya",
			"sPrevious": "Sebelumnya"
		},
		"sLengthMenu": "_MENU_",
		"sSearch": "Pencarian :"
	},
	drawCallback: function(settings){
		var api = this.api();
		$('[data-toggle="tooltip"]').tooltip();
	},
	fnDrawCallback: function () {
		$(".chocolat").Chocolat({
			className: 'chocolat',
			imageSelector: '.chocolat-item',
			imageSize: 'contain'
		});
	}
});

$('#created').on('click', function(e) {
	e.preventDefault();

	breadcrumb_header.push("Tambah " + title_header);

	$('#data-home').fadeOut(1500);

	makeLoading('created', title_header, breadcrumb_header);
});

function makeLoading(tipe) {
	jQuery(function($){
		$.ajax({
			type: 'GET'
		}).done(function() {
			$("#overlay").fadeIn(1500);
			setTimeout(function(){
				$("#overlay").fadeOut(1500);
				$('#data-' + tipe).fadeIn(1700);
				if(tipe == "home") {
					$('#back-header').removeClass("show-content");
					$('#back-header').addClass("hide-content");

					$("#data-form-created").trigger("reset");
					$("#data-form-modified").trigger("reset");
				}
				makeSectionHeader(tipe, title_header, breadcrumb_header);
			},500);
		});
	});
}

function makeSectionHeader(title_header, breadcrumb_header) {
	var breadcrumb_html = [];

	for(var i = 0; i < breadcrumb_header.length; i++) {
		var nomor = i + 1;
		if(nomor == 1) {
			breadcrumb_html.push("<div class='breadcrumb-item active'><a href='"+breadcrumb_header[i].toLowerCase()+"'>"+breadcrumb_header[i]+"</a></div>");
		}else if(nomor == breadcrumb_header.length) {
			breadcrumb_html.push("<div class='breadcrumb-item'>"+breadcrumb_header[i]+"</div>");
		}else {
			breadcrumb_html.push("<div class='breadcrumb-item'><a href='"+breadcrumb_header[i].toLowerCase()+"' class='back-index'>"+breadcrumb_header[i]+"</a></div>");
		}
	}

	$('#title-header').text(title_header);

	$('#breadcrumb-header').html(breadcrumb_html.join(''));
}

function trashData(url, hash_id, table) {
	$.ajax({
		type: "POST",
		url: url,
		data: {'hash_id':hash_id, 'function':'trashData'},
		success: function(response) {
			var result = JSON.parse(response);
			if(result.status_code == 200) {
				swal({
					title: "Pemberitahuan",
					text: result.message,
					icon: "success"
				}).then(function() {
					table.draw();
				});
			}else {
				swal('Peringatan', result.message, 'error');
			}
		}
	});
}

function restoreData(url, hash_id, table) {
	$.ajax({
		type: "POST",
		url: url,
		data: {'hash_id':hash_id, 'function':'restoreData'},
		success: function(response) {
			var result = JSON.parse(response);
			if(result.status_code == 200) {
				swal({
					title: "Pemberitahuan",
					text: result.message,
					icon: "success"
				}).then(function() {
					table.draw();
				});
			}else {
				swal('Peringatan', result.message, 'error');
			}
		}
	});
}

function deleteData(url, hash_id, table) {
	$.ajax({
		type: "POST",
		url: url,
		data: {'hash_id':hash_id, 'function':'deleteData'},
		success: function(response) {
			var result = JSON.parse(response);
			if(result.status_code == 200) {
				swal({
					title: "Pemberitahuan",
					text: result.message,
					icon: "success"
				}).then(function() {
					table.draw();
				});
			}else {
				swal('Peringatan', result.message, 'error');
			}
		}
	});
}

$(document).on('click','#user-logout', function(e) {
	e.preventDefault();
	var id = 1;
	swal({
		title: 'Peringatan',
		text: 'Apakah Anda yakin ingin keluar ?',
		icon: 'warning',
		buttons: {
			cancel: {
				text: "Tidak",
				value: false,
				visible: true,
				className: "",
				closeModal: true,
			},
			confirm: {
				text: "Ya",
				value: true,
				visible: true,
				className: "",
				closeModal: true
			},
		},
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.ajax({
				type: "POST",
				url: "http://localhost/winnow-anplag/routes/web/site.php",
				data: {'id':id, 'function':'logout'},
				success: function(response) {
					var result = JSON.parse(response);
					if(result.status_code == 200) {
						swal({
							title: "Pemberitahuan",
							text: result.message,
							icon: "success"
						}).then(function() {
							window.location.href = 'http://localhost/winnow-anplag/app/'
						});
					}else {
						swal('Peringatan', result.message, 'error');
					}
				}
			});
		}
	});
});

function removeElements() {
	$('.no-access').remove();
}