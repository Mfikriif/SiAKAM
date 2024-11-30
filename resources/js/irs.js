const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

export async function approveCancelIrs(mahasiswa_id, action) {
    const url = action === "approve"
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
                    action === "approve"
                        ? "Disetujui"
                        : "Belum Disetujui";

                // update status text
                $(`#status-${mahasiswa_id}`).text(statusText);

                // update button
                if (action === "approve") {
                    $(`#status-${mahasiswa_id}`)
                        .removeClass("text-yellow-500")
                        .addClass("text-green-500");
                    $(`#aksi-${mahasiswa_id}`).html(`
                        <div class="flex justify-center">
                            <button onclick="approveCancelIrs(${mahasiswa_id}, 'cancel')" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">Batalkan Persetujuan</button>
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
                            <button onclick="approveCancelIrs(${mahasiswa_id}, 'approve')" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">Setujui</button>
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