// SweetAlert untuk opsi Aktif
function showConfirm(title, text, icon, confirm, confirmText, status) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Pilih!",
    });
    if (result.isConfirmed) {
        Swal.fire({
            title: confirm,
            text: confirmText,
            icon: status,
        });
        // Redirect atau aksi lainnya
    }
}

window.showConfirm = showConfirm;

// SweetAlert untuk opsi Cuti
function showAlert(title, text, icon, confirm, confirmText, status) {
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

async function deleteIrs(event, title, text, icon, confirmText, status) {
    event.preventDefault(); // Mencegah form dari melakukan submit secara otomatis

    const result = await Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: confirmText,
    });

    if (result.isConfirmed) {
        Swal.fire("Confirmed!", "Your action has been confirmed.", status);
        // Jika perlu, submit form secara manual di sini atau lakukan aksi lain
        // Misal, submit form:
        event.target.form.submit();
    }
}

window.deleteIrs = deleteIrs;
