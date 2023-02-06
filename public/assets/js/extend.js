$(document).ready(function () {
	// $("#sidebarToggle").click();
    $(document).on("click", ".modal-cre", function (e) {
      
        $("#konten").html('<div style="text-align:center; color:red; font-weight:bold;padding:10px">Loading ...</div> ');
        $("#loading-ajax-modal").show();
        var serial = "";
        $.each(this.attributes, function () {
            if (this.specified) {
                serial += "&" + this.name + "=" + this.value;
            }
        });

        var id = $(this).attr("id");
        var judul = $(this).attr("judul");

        if (id == "add-kerma") {
            $("#class").addClass("modal-lg");
        } else {
            $("#class").removeClass("modal-lg");
        }
        $('#myModals').modal('toggle');

        if (judul != null) {
            $(".modal-title").html(judul);
        } else {
            $(".modal-title").html("Kelola Data");
        }

        base_url = $("#base_url").val();

        page = base_url + "/modal/modal-" + id;
        $.post(page, serial, function (data) {
            $("#loading-ajax-modal").hide();
            $("#konten").html(data);
        });
    });

    $(document).on("click", ".modal-hapus-cre", function(e) {
		var serial = "";
		$.each(this.attributes, function() {
			if(this.specified) {
				serial += "&" + this.name + "=" + this.value;
			}
		});


        Swal.fire({
            title: 'Perhatian!',
            text: "Kamu yakin ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
          }).then((result) => {
            if (result.isConfirmed) {
            base_url = $("#base_url").val();
            page = base_url + "/delete";
            $.ajax({
                url: page,
                data: serial,
                method: 'POST',
            }).done((data, textStatus) => {
                Dtabel.ajax.reload();
                Swal.fire({
                    icon: textStatus,
                    title: 'Berhasil terhapus',
                    showConfirmButton: false,
                    timer: 1500
                  })
            }).fail(function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: textStatus,
                    title: 'Kesalahan !',
                    text: jqXHR.responseJSON.message,
                  })
            })
            }
          })

	});

});



$("ul a").click(function(e) {
	var link = $(this);
	var item = link.parent("li");
	if(item.hasClass("active")) {
		item.removeClass("active").children("a").removeClass("active");
	} else {
		item.addClass("active").children("a").addClass("active");
	}
	if(item.children("ul").length > 0) {
		var href = link.attr("href");
		link.attr("href", "#");
		setTimeout(function() {
			link.attr("href", href);
		}, 300);
		e.preventDefault();
	}
}).each(function() {
	var link = $(this);
	if(link.get(0).href === location.href) {
		link.addClass("active").parents("li").addClass("active");
		link.addClass("active").parents(".collapse").addClass("show");
		return false;
	}
});

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(";");

    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setToken(Target) {
    $("input[name=" + Target + "]").val(getCookie("CToken"));
}

