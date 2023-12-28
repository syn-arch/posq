const base_url = $('meta[name="base_url"]').attr("content");

// sweetalert delete
$(document).ready(function () {
  $(document).on("click", ".hapus-data", function () {
    hapus($(this).data("href"));
  });
});

// select2
$(".select2").select2();

// datatable
$(".datatable").dataTable();

// ubah akses role
$(".ubah_menu").click(function () {
  const id_menu = $(this).data("menu");
  const id_role = $(this).data("role");

  $.ajax({
    url: `${base_url}user/ubah_akses_role/${id_menu}/${id_role}`,
    method: "post",
    success: function () {
      swal({
        title: "Berhasil",
        text: "Data berhasil diubah",
        icon: "success",
        buttons: false,
      });

      window.location.reload(true);
    },
  });
});

$(".crud_access").click(function () {
  const id_menu = $(this).data("menu");
  const id_role = $(this).data("role");
  const access = $(this).data("access");

  $.ajax({
    url: `${base_url}akses/ubah_crud_akses/${id_menu}/${id_role}/${access}`,
    method: "post",
    success: function () {
      swal({
        title: "Berhasil",
        text: "Data berhasil diubah",
        icon: "success",
        buttons: false,
      });

      // window.location.reload(true);
    },
  });
});

// role
$(document).on("click", ".hapus_role", function () {
  hapus($(this).data("href"));
});

$(document).on("click", ".hapus_backup", function () {
  hapus($(this).data("href"));
});

$(document).on("click", ".hapus-menu", function () {
  const id = $(this).data("id");
  const href = $(this).data("href");

  swal({
    title: "Apakah anda yakin?",
    text: "Data yang dihapus tidak dapat dikembalikan!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      swal({
        title: "Hapus direktori?",
        text: "Hapus beserta direktori modul ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: base_url + "/menu/hapus_direktori/" + id,
            method: "get",
            success: function () {
              window.location = href;
            },
          });
        } else {
          window.location = href;
        }
      });
    }
  });
});

// iconpicker
$(".iconpicker").iconpicker();

$(".menu_utama").change(function () {
  menu_utama = parseInt($(this).val());
  if (menu_utama == 0) {
    $(".pilih_menu").show();
    $(".ada_submenu").val(0);
  } else {
    $(".pilih_menu").hide();
    $(".ada_submenu").val(1);
  }
});

$(".dd").nestable({
  maxDepth: 2,
});

$(".dd").on("change", function () {
  var serializedData = $(this).nestable("serialize");
  $.ajax({
    url: base_url + "/menu/ubah_posisi_menu",
    data: {
      menu: serializedData,
    },
    type: "post",
    success: function (res) {
      swal({
        title: "Berhasil",
        text: "Data berhasil diubah",
        icon: "success",
        buttons: false,
      });

      window.location.reload(true);
    },
  });
});
