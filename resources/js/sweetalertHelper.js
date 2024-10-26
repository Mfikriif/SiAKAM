// SweetAlert untuk opsi Aktif
function showConfirm(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Pilih!",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                "Dipilih!",
                "Anda telah memilih status Aktif.",
                "success"
            );
            // Redirect atau aksi lainnya
        }
    });
}

window.showConfirm = showConfirm;

// SweetAlert untuk opsi Cuti
function showAlert(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Pilih!",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Dipilih!", "Anda telah memilih status Cuti.", "success");
            // Redirect atau aksi lainnya
        }
    });
}

window.showAlert = showAlert;
