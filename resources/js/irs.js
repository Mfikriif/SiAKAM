const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

export async function approveCancelIrs(mahasiswa_id, action) {
    const url =
        action === "approve"
            ? `/dosenwali/approve-irs/${mahasiswa_id}`
            : action === "cancel"
            ? `/dosenwali/cancel-approval/${mahasiswa_id}`
            : null;

    if (!url) {
        console.error("Invalid action:", action);
        return;
    }

    $.ajax({
        url: url,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function (response) {
            if (response.success) {
                const statusText =
                    action === "approve" ? "Disetujui" : "Belum Disetujui";

                // update status text
                $(`#status-${mahasiswa_id}`).text(statusText);

                // update button
                if (action === "approve") {
                    $(`#status-${mahasiswa_id}`)
                        .removeClass("text-yellow-500")
                        .addClass("text-green-500");
                    $(`#aksi-${mahasiswa_id}`).html(`
                        <div class="flex justify-center space-x-4">
                            <button onclick="approveCancelIrs(${mahasiswa_id}, 'cancel')" 
                                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-4 border border-blue-500 hover:border-transparent rounded">
                                Batalkan Persetujuan
                            </button>
                            <button onclick="deleteIrs(${mahasiswa_id})" 
                                class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-4 border border-red-500 hover:border-transparent rounded">
                                Batalkan IRS
                            </button>
                        </div>
                    `);

                    Swal.fire(
                        "Berhasil!",
                        response.message || "Tindakan berhasil dilakukan.",
                        "success"
                    );
                } else if (action === "cancel") {
                    $(`#status-${mahasiswa_id}`)
                        .removeClass("text-green-500")
                        .addClass("text-yellow-500");
                    $(`#aksi-${mahasiswa_id}`).html(`
                        <div class="flex justify-center">
                            <button onclick="approveCancelIrs(${mahasiswa_id}, 'approve')" 
                                class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-4 border border-green-500 hover:border-transparent rounded">
                                Setujui
                            </button>
                        </div>
                    `);

                    Swal.fire(
                        "Berhasil!",
                        response.message || "Tindakan berhasil dilakukan.",
                        "success"
                    );
                }
            } else {
                Swal.fire(
                    "Gagal!",
                    response.message || "Gagal memperbarui status.",
                    "error"
                );
            }
        },
        error: function (xhr, error) {
            console.error("AJAX Error:", error);
            const errorMessage =
                xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : "Terjadi kesalahan pada server.";
            Swal.fire("Kesalahan!", errorMessage, "error");
        },
    });
}

export function deleteIrs(mahasiswaId) {
    Swal.fire({
        title: "Konfirmasi",
        text: "Apakah Anda yakin ingin membatalkan IRS ini? Data IRS akan dihapus, dan status herreg akan menjadi cuti (-1).",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Batalkan IRS",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/dosenwali/delete/${mahasiswaId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        Swal.fire(
                            "Berhasil",
                            "IRS berhasil dibatalkan.",
                            "success"
                        ).then(() => {
                            // Refresh halaman
                            window.location.reload(); // Menyegarkan halaman
                        });
                    } else {
                        Swal.fire(
                            "Gagal",
                            data.message || "Terjadi kesalahan.",
                            "error"
                        );
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire(
                        "Kesalahan!",
                        "Terjadi kesalahan saat menghubungi server.",
                        "error"
                    );
                });
        }
    });
}
