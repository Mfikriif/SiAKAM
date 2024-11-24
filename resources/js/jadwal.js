// Retrieve CSRF token from the meta tag
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

// Filter Table Function
export function filterTable() {
    const semester = document.getElementById("semester").value;
    const jurusan = document.getElementById("jurusan").value.toLowerCase();
    const rows = document.querySelectorAll("#jadwal-tbody tr");

    rows.forEach((row) => {
        const rowSemester = row.getAttribute("data-semester");
        const kodeMK = row.querySelector("td:nth-child(1)").innerText;

        // Determine Jurusan based on kode_mk prefix
        let rowJurusan = "";
        if (kodeMK.startsWith("PAIK")) {
            rowJurusan = "informatika";
        } else if (kodeMK.startsWith("LAB") || kodeMK.startsWith("PAB")) {
            rowJurusan = "bioteknologi";
        }

        // Show/hide row based on selected filters
        const semesterMatch = semester === "" || rowSemester === semester;
        const jurusanMatch = jurusan === "" || rowJurusan === jurusan;

        row.style.display = semesterMatch && jurusanMatch ? "" : "none";
    });
}

// Approve All Function
export function approveAll() {
    const semester = document.getElementById("semester").value;
    const jurusan = document.getElementById("jurusan").value;

    fetch("/jadwal/approve-all", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ semester, jurusan }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showSuccessAlert(
                    "Berhasil!",
                    `Semua permintaan untuk semester ${semester} dan jurusan ${
                        jurusan || "Semua Jurusan"
                    } telah disetujui.`,
                    () => location.reload()
                );
            } else {
                showErrorAlert(
                    "Gagal!",
                    data.message ||
                        "Terjadi kesalahan saat menyetujui semua permintaan."
                );
            }
        })
        .catch((error) => {
            console.error("Fetch Error:", error);
            showErrorAlert(
                "Kesalahan Server",
                "Terjadi kesalahan pada server."
            );
        });
}

export async function approveRejectJadwal(id, action) {
    // Determine URL based on action
    const url =
        action === "approve"
            ? `/jadwal/approve/${id}`
            : action === "reject"
            ? `/jadwal/reject/${id}`
            : action === "cancel"
            ? `/jadwal/cancel/${id}`
            : null;

    if (!url) {
        console.error("Invalid action:", action);
        return;
    }

    // If the action is "reject", use SweetAlert to prompt for a reason
    let reason = null;
    if (action === "reject") {
        const { value: text } = await Swal.fire({
            input: "textarea",
            inputLabel: "Masukkan alasan penolakan",
            inputPlaceholder: "Ketik alasan penolakan di sini...",
            inputAttributes: {
                "aria-label": "Masukkan alasan penolakan",
            },
            showCancelButton: true,
            confirmButtonText: "Kirim",
            cancelButtonText: "Batal",
            preConfirm: (inputValue) => {
                if (!inputValue) {
                    Swal.showValidationMessage("Alasan penolakan diperlukan!");
                }
            },
        });

        if (!text) {
            return; // Exit if the user cancels or submits empty input
        }

        reason = text;
    }

    // AJAX request to the server
    $.ajax({
        url: url,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: {
            reason: reason, // Only sent if the action is "reject"
        },
        success: function (response) {
            if (response.success) {
                // Determine status text based on the action
                const statusText =
                    action === "approve"
                        ? "Disetujui"
                        : action === "reject"
                        ? `Ditolak: ${reason}`
                        : "Belum Disetujui";

                // Update status display
                $(`#status-${id}`).text(statusText);

                // Update status and action buttons
                if (action === "approve") {
                    $(`#status-${id}`)
                        .removeClass("text-red-500 text-gray-500")
                        .addClass("text-green-500");
                    $(`#aksi-${id}`).html(`
                        <div class="flex justify-center space-x-2">
                            <button onclick="approveRejectJadwal(${id}, 'cancel')" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">Batalkan Persetujuan</button>
                        </div>
                    `);
                } else if (action === "reject") {
                    $(`#status-${id}`)
                        .removeClass("text-green-500 text-gray-500")
                        .addClass("text-red-500");
                    $(`#aksi-${id}`).html(`
                        <div class="flex justify-center space-x-2">
                            <button onclick="approveRejectJadwal(${id}, 'cancel')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">Batalkan Penolakan</button>
                        </div>
                    `);

                    // Show SweetAlert only when rejecting
                    Swal.fire(
                        "Ditolak!",
                        "Jadwal berhasil ditolak.",
                        "warning"
                    );
                } else if (action === "cancel") {
                    $(`#status-${id}`)
                        .removeClass("text-green-500 text-red-500")
                        .addClass("text-gray-500")
                        .text("Belum Disetujui");
                    $(`#aksi-${id}`).html(`
                        <div class="flex justify-center space-x-2">
                            <button onclick="approveRejectJadwal(${id}, 'approve')" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">Setujui</button>
                            <button onclick="approveRejectJadwal(${id}, 'reject')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">Tolak</button>
                        </div>
                    `);
                }
            } else {
                Swal.fire(
                    "Gagal!",
                    response.message || "Gagal memperbarui status",
                    "error"
                );
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            const errorMessage =
                xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : "Terjadi kesalahan pada server.";
            Swal.fire("Kesalahan!", errorMessage, "error");
        },
    });
}

// Function to calculate and validate the end time (jam_selesai) based on SKS and jam_mulai
export function calculateJamSelesai() {
    const jamMulaiInput = document.getElementById("jam_mulai");
    const jamSelesaiInput = document.getElementById("jam_selesai");
    const sksInput = document.getElementById("sks");

    // Retrieve values
    const jamMulai = jamMulaiInput.value;
    const sks = parseInt(sksInput.value) || 0;

    // Validate and adjust jam_mulai
    if (jamMulai) {
        const [hours, minutes] = jamMulai.split(":").map(Number);

        // Round minutes to nearest 10
        let adjustedMinutes = Math.round(minutes / 10) * 10;
        let adjustedHours = hours;

        // Handle minutes overflow (e.g., 60 minutes)
        if (adjustedMinutes === 60) {
            adjustedMinutes = 0;
            adjustedHours = (hours + 1) % 24; // Wrap around after 23:59
        }

        // Format adjusted jam_mulai
        const adjustedJamMulai = `${String(adjustedHours).padStart(
            2,
            "0"
        )}:${String(adjustedMinutes).padStart(2, "0")}`;
        jamMulaiInput.value = adjustedJamMulai;

        // Proceed to calculate jam_selesai if SKS is provided
        if (sks > 0) {
            const durationMinutes = sks * 50; // Each SKS is 50 minutes
            const jamMulaiDate = new Date();
            jamMulaiDate.setHours(adjustedHours, adjustedMinutes);

            // Calculate jam selesai
            const jamSelesaiDate = new Date(
                jamMulaiDate.getTime() + durationMinutes * 60000
            );
            let jamSelesaiHours = jamSelesaiDate.getHours();
            let jamSelesaiMinutes =
                Math.ceil(jamSelesaiDate.getMinutes() / 10) * 10;

            // Handle minutes overflow for jam_selesai
            if (jamSelesaiMinutes === 60) {
                jamSelesaiMinutes = 0;
                jamSelesaiHours = (jamSelesaiHours + 1) % 24;
            }

            // Format jam selesai
            const jamSelesai = `${String(jamSelesaiHours).padStart(
                2,
                "0"
            )}:${String(jamSelesaiMinutes).padStart(2, "0")}`;
            jamSelesaiInput.value = jamSelesai;
        }
    }
}

// Function to show errors using SweetAlert if there are any validation errors
export function showErrors(errors) {
    if (errors.length > 0) {
        Swal.fire({
            icon: "error",
            title: "Waduh...",
            html: `<ul style="text-align: center;">${errors
                .map((error) => `<li>${error}</li>`)
                .join("")}</ul>`,
        });
    }
}

// Function to disable already selected options across multiple select inputs
export function updateOptions() {
    const selects = document.querySelectorAll('select[name^="pengampu"]');

    const selectedValues = Array.from(selects)
        .map((select) => select.value)
        .filter((value) => value !== "");

    selects.forEach((select) => {
        const options = select.querySelectorAll("option");
        options.forEach((option) => {
            option.disabled =
                selectedValues.includes(option.value) &&
                option.value !== select.value;
        });
    });
}

// Set up event listeners for the select elements
export function setupOptionListeners() {
    const selects = document.querySelectorAll('select[name^="pengampu"]');
    selects.forEach((select) =>
        select.addEventListener("change", updateOptions)
    );
    updateOptions(); // Initial call to disable options on load
}

// Initialize the above functions on page load
document.addEventListener("DOMContentLoaded", () => {
    setupOptionListeners();
});
