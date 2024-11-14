function getCsrfToken() {
    return document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
}

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

// SweetAlert for Confirm Delete Action
async function confirmDelete(url) {
    const result = await Swal.fire({
        title: "Apakah kamu yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
    });

    if (result.isConfirmed) {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = url;

        const csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = getCsrfToken();
        form.appendChild(csrfInput);

        const methodInput = document.createElement("input");
        methodInput.type = "hidden";
        methodInput.name = "_method";
        methodInput.value = "DELETE";
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    } else {
        Swal.fire("Dibatalkan", "Data Anda aman!", "error");
    }
}

window.confirmDelete = confirmDelete;

// Helper function for displaying success alerts
function showSuccessAlert(title, text, callback = null) {
    Swal.fire({
        title: title,
        text: text,
        icon: "success",
        confirmButtonText: "OK",
    }).then(() => {
        if (callback) callback();
    });
}

// Helper function for displaying error alerts
function showErrorAlert(title, text) {
    Swal.fire({
        title: title,
        text: text,
        icon: "error",
        confirmButtonText: "OK",
    });
}

// Expose these functions globally
window.showSuccessAlert = showSuccessAlert;
window.showErrorAlert = showErrorAlert;

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
