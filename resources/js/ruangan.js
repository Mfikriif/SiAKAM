// Filter based on selected jurusan
export function filterRuangan() {
    var selectedJurusan = document.getElementById("jurusanFilter").value;

    // Loop through all rows with the class 'jurusan-row' and filter them
    document.querySelectorAll(".jurusan-row").forEach(function (row) {
        // Get the 'data-jurusan' attribute value for each row
        var jurusan = row.getAttribute("data-jurusan");

        // Show or hide row based on selectedJurusan value
        if (selectedJurusan === "" || jurusan === selectedJurusan) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// Approve all rooms for the selected jurusan
export function approveAll() {
    const jurusan = document.getElementById("jurusanFilter").value;
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/dekan/list-pengajuan-ruang/approve-all", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ jurusan: jurusan }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                Swal.fire({
                    title: "Berhasil!",
                    text: `Semua permintaan untuk jurusan ${
                        jurusan || "Semua Jurusan"
                    } telah disetujui.`,
                    icon: "success",
                    confirmButtonText: "OK",
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Gagal!",
                    text: data.message || "Gagal memperbarui status.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                title: "Kesalahan Server",
                text: "Terjadi kesalahan pada server.",
                icon: "error",
                confirmButtonText: "OK",
            });
        });
}

// Approve or reject a specific room
export function approveReject(id, action) {
    const url = `/dekan/${action}-ruang/${id}`;
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $(`#status-${id}`).text(response.status);

                if (action === "approve") {
                    $(`#status-${id}`)
                        .removeClass("text-gray-500 text-red-500")
                        .addClass("text-green-500")
                        .text("Disetujui");
                    $(`#aksi-${id}`).html(`
                        <div class="flex justify-center space-x-2">
                            <button onclick="changeStatus(${id})" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                Batalkan Persetujuan
                            </button>
                        </div>
                    `);
                } else if (action === "reject") {
                    $(`#status-${id}`)
                        .removeClass("text-green-500 text-gray-500")
                        .addClass("text-red-500")
                        .text("Ditolak");
                    $(`#aksi-${id}`).html(`
                        <div class="flex justify-center space-x-2">
                            <button onclick="approveReject(${id}, 'cancel-reject')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">
                                Batalkan Penolakan
                            </button>
                        </div>
                    `);
                } else if (action === "cancel-reject") {
                    $(`#status-${id}`)
                        .removeClass("text-green-500 text-red-500")
                        .addClass("text-gray-500")
                        .text("Belum Disetujui");
                    $(`#aksi-${id}`).html(`
                        <div class="flex justify-center space-x-2">
                            <button onclick="approveReject(${id}, 'approve')" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">
                                Terima
                            </button>
                            <button onclick="approveReject(${id}, 'reject')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">
                                Tolak
                            </button>
                        </div>
                    `);
                }
            } else {
                alert(response.message || "Gagal memperbarui status");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan pada server.");
        },
    });
}

// Change the status of a specific room
export function changeStatus(id) {
    const url = `/dekan/change-status-ruang/${id}`;
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $(`#status-${id}`)
                    .text("Belum Disetujui")
                    .removeClass("text-green-500")
                    .addClass("text-gray-500");
                $(`#aksi-${id}`).html(`
                    <div class="flex justify-center space-x-2">
                        <button onclick="approveReject(${id}, 'approve')" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">
                            Terima
                        </button>
                        <button onclick="approveReject(${id}, 'reject')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">
                            Tolak
                        </button>
                    </div>
                `);
            } else {
                alert("Gagal memperbarui status");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            alert(
                "Terjadi kesalahan. Silakan cek console untuk detail lebih lanjut."
            );
        },
    });
}
