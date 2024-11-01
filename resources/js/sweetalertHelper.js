// SweetAlert untuk opsi Aktif
async function showConfirm(title, text, icon, confirm, confirmText, status) {
    const result = await Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Pilih!",
    });
    if (result.isConfirmed) {
        await Swal.fire({
            title: confirm,
            text: confirmText,
            icon: status,
        });
        // Redirect atau aksi lainnya
    }
}

window.showConfirm = showConfirm;

// SweetAlert untuk opsi Cuti
async function showAlert(title, text, icon, confirm, confirmText, status) {
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
            Swal.fire({
                title: confirm,
                text: confirmText,
                icon: status,
            });
            // Redirect atau aksi lainnya
        }
    });
}

window.showAlert = showAlert;
