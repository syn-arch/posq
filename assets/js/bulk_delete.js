$(".check_all").click(function(){
	if (this.checked) {
		$(".data_checkbox").prop("checked", true)
	}else{
		$(".data_checkbox").prop("checked", false)
	}
})

$(".hapus_bulk").click(function(e){
	e.preventDefault();

	var data = [];

	$(':checkbox:checked').each(function(i){
		data[i] = $(this).val();
	});

	if (data.length == 0) {
		swal({
			title: "Gagal!",
			text: 'Anda Belum Memilih Data',
			icon: "error"
		})
		return 
	}

	swal({
		title: "Apakah anda yakin?",
		text: "Data yang dihapus tidak dapat dikembalikan!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {

			$.ajax({
				method : "post",
				url : base_url + table_name + '/hapus_bulk',
				data : { data : data},
				success : function(data){
					swal('Berhasil','Data berhail dihapus', 'success');
					window.location.href = base_url + table_name
				}
			})

		}
	});
})