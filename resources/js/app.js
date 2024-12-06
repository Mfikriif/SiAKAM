import "./bootstrap";
import "./sweetalertHelper";
import {
    filterTable,
    approveAll as approveAllJadwal,
    approveRejectJadwal,
    calculateJamSelesai,
    showErrors,
    updateOptions,
    setupOptionListeners,
} from "./jadwal";
import {
    filterRuangan,
    approveAll as approveAllRuangan,
    approveReject,
    changeStatus,
} from "./ruangan";
import { approveCancelIrs, deleteIrs } from "./irs";

import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

// Expose jadwal functions globally so they can be accessed in the HTML
window.filterTable = filterTable;
window.approveAllJadwal = approveAllJadwal;
window.approveRejectJadwal = approveRejectJadwal;
window.calculateJamSelesai = calculateJamSelesai;
window.showErrors = showErrors;
window.updateOptions = updateOptions;
window.setupOptionListeners = setupOptionListeners;

// Expose ruangan functions globally
window.filterRuangan = filterRuangan;
window.approveAllRuangan = approveAllRuangan;
window.approveReject = approveReject;
window.changeStatus = changeStatus;

// Expose irs functions globally
window.approveCancelIrs = approveCancelIrs;
window.deleteIrs = deleteIrs;

document.addEventListener("DOMContentLoaded", function () {
    // Memulai event listeners
    setupOptionListeners();

    const jurusanSelect = document.getElementById("jurusanFilter");
    if (jurusanSelect) {
        jurusanSelect.addEventListener("change", filterRuangan);
    }
});

document
    .getElementById("matakuliah")
    .addEventListener("change", async function () {
        const selectedMK = this.value;
        console.log("Selected MK:", selectedMK);

        try {
            const response = await fetch(
                `/get-matakuliah-detail/${selectedMK}`,
                {
                    method: "GET",
                    headers: { "Content-Type": "application/json" },
                }
            );
            const data = await response.json();
            console.log("Fetched course data:", data);
            displaySelectedCourse(data);
        } catch (error) {
            console.error("Error fetching course details:", error);
        }
    });

function displaySelectedCourse(data) {
    console.log("Data received in displaySelectedCourse:", data);

    // Pastikan data adalah array
    if (!Array.isArray(data)) {
        console.error("Invalid data format: data is not an array", data);
        return;
    }

    const courseList = document.getElementById("courseList");
    if (!courseList) {
        console.error("courseList element not found!");
        return;
    }

    courseList.innerHTML = ""; // Kosongkan daftar sebelumnya

    // Iterasi data untuk membuat baris tabel
    data.forEach((course, index) => {
        course.index = index + 1; // Tambahkan properti 'index' untuk nomor urut
        courseList.appendChild(createCourseRow(course, [])); // Kosongkan selectedCourses untuk saat ini
    });
}

function createCourseRow(course, selectedCourses) {
    const row = document.createElement("tr");
    row.className = "bg-white transition-all duration-500 hover:bg-gray-50";
    row.id = `row-${course.kode_mk}`;

    // Buat isi baris sesuai dengan struktur tabel
    row.innerHTML = `
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 text-center">
            ${course.index} <!-- Ganti dengan loop.index jika diterima dari backend -->
        </td>
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
            ${course.kode_mk}
        </td>
        <td class="px-5 py-3">
            <div class="w-48 flex items-center gap-3">
                <div class="data">
                    <p class="font-normal text-sm text-gray-900">${course.nama}</p>
                </div>
            </div>
        </td>
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
            ${course.semester}
        </td>
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
            ${course.sks}
        </td>
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
            ${course.sifat}
        </td>
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
            ${course.kelas}
        </td>
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
            ${course.ruangan}
        </td>
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
            ${course.hari}
        </td>
        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
            ${course.jam_mulai} - ${course.jam_selesai}
        </td>
    `;

    // Tambahkan kolom aksi (tombol Pilih/Batal)
    const actionCell = createActionCell(course, row);
    if (actionCell instanceof Node) {
        const actionColumn = document.createElement("td");
        actionColumn.className = "flex items-center gap-0.5";
        actionColumn.appendChild(actionCell);
        row.appendChild(actionColumn);
    } else {
        console.error("createActionCell did not return a Node:", actionCell);
    }

    return row;
}

function createActionCell(course, row) {
    const actionCell = document.createElement("td"); // Membuat elemen <td>

    // Cek apakah mata kuliah sudah diambil
    const isSelected = course.is_selected;

    // Tombol Pilih
    const pilihButton = document.createElement("button");
    pilihButton.textContent = isSelected ? "Dipilih" : "Pilih";
    pilihButton.className = `w-16 h-8 text-center pt-px rounded-lg mt-4 ml-2 ${
        isSelected ? "bg-gray-500" : "bg-[#2EC060]"
    } text-white`;
    pilihButton.disabled = isSelected;

    pilihButton.addEventListener("click", async (event) => {
        event.preventDefault();
        console.log("Tombol Pilih diklik!");

        // Kirim permintaan POST ke server
        try {
            const response = await fetch("/mahasiswa/irs/store", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    semester: course.semester,
                    kode_mk: course.kode_mk,
                    nama_mk: course.nama,
                    sks: course.sks,
                    kelas: course.kelas,
                }),
            });

            if (response.ok) {
                console.log("Mata kuliah berhasil dipilih.");
                actionCell.innerHTML = ""; // Bersihkan isi actionCell
                actionCell.appendChild(createBatalButton(course, row));
            } else {
                alert("Gagal memilih mata kuliah.");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });

    actionCell.appendChild(pilihButton); // Tambahkan tombol Pilih ke actionCell

    return actionCell; // Pastikan actionCell adalah elemen Node (td)
}

function createBatalButton(course, row) {
    const batalButton = document.createElement("button");
    batalButton.textContent = "Batal";
    batalButton.className =
        "w-16 h-8 text-center pt-px rounded-lg mt-4 ml-2 bg-red-600 text-white";

    batalButton.addEventListener("click", async (event) => {
        event.preventDefault();
        console.log("Tombol Batal diklik!");

        // Kirim permintaan DELETE ke server menggunakan POST dengan _method=DELETE
        try {
            const response = await fetch("/mahasiswa/irs/delete", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    _method: "DELETE", // Override method untuk DELETE
                    kode_mk: course.kode_mk,
                    nama_mhs: course.nama_mhs, // Pastikan nama mahasiswa dikirim
                    kelas: course.kelas,
                }),
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    console.log("Mata kuliah berhasil dibatalkan.");
                    alert(result.message); // Tampilkan pesan sukses
                } else {
                    console.error(
                        "Gagal membatalkan mata kuliah:",
                        result.message
                    );
                    alert(result.message); // Tampilkan pesan error
                }
            } else {
                console.error("Gagal membatalkan mata kuliah. Server error.");
                alert("Gagal membatalkan mata kuliah. Server error.");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan saat membatalkan mata kuliah.");
        }
    });

    const actionCell = document.createElement("td");
    actionCell.appendChild(batalButton);
    return actionCell;
}
