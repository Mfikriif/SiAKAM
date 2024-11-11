import "./bootstrap";

import "./sweetalertHelper";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

function approveJadwal(id) {
    if (confirm("Apakah Anda yakin ingin menyetujui jadwal ini?")) {
        $.ajax({
            url: `/jadwal/approve/${id}`,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                alert(response.message);
                location.reload(); // Reload to see the updated status
            },
            error: function (xhr) {
                alert("Terjadi kesalahan: " + xhr.responseJSON.message);
            },
        });
    }
}

function rejectJadwal(id) {
    if (confirm("Apakah Anda yakin ingin menolak jadwal ini?")) {
        $.ajax({
            url: `/jadwal/reject/${id}`,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                alert(response.message);
                location.reload(); // Reload to see the updated status
            },
            error: function (xhr) {
                alert("Terjadi kesalahan: " + xhr.responseJSON.message);
            },
        });
    }
}

function approveAllJadwal() {
    const semester = $("#semester").val();
    const programStudi = $('input[name="program_studi"]').val();

    $.ajax({
        url: "/jadwal/approveAll",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            semester: semester,
            program_studi: programStudi,
        },
        success: function (response) {
            alert(response.message);
            location.reload(); // Reload to see the updated status
        },
        error: function (xhr) {
            alert("Terjadi kesalahan: " + xhr.responseJSON.message);
        },
    });
}

// Function to toggle password visibility
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eye-icon");
    const eyeOpen = eyeIcon.querySelector("#eye-open");
    const eyeClosed = eyeIcon.querySelector("#eye-closed");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
    } else {
        passwordInput.type = "password";
        eyeOpen.classList.remove("hidden");
        eyeClosed.classList.add("hidden");
    }
}
window.togglePassword = togglePassword;

// document.addEventListener("DOMContentLoaded", function () {
//     const textElement = document.getElementById("typing-text");
//     const text = textElement.textContent;
//     textElement.textContent = "";
//     let index = 0;

//     function typeEffect() {
//         if (index < text.length) {
//             textElement.textContent += text.charAt(index);
//             index++;
//             setTimeout(typeEffect, 100);
//         }
//     }

//     typeEffect();
// });

// Tambahkan event listener untuk select element

// ("X-CSRF-TOKEN");
// document.querySelector('meta[name="csrf-token"]').getAttribute("content");
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
    const courseList = document.getElementById("courseList");
    if (!courseList) {
        console.error("courseList element not found!");
        return;
    }

    courseList.innerHTML = ""; // Optionally clear existing entries if needed

    data.forEach((course, index) => {
        courseList.appendChild(createCourseRow(course, index));
    });
}

function createCourseRow(course, index) {
    const row = document.createElement("tr");

    row.innerHTML = `
        <td>${index + 1}</td>
        <td>${course.kode_mk}</td>
        <td>${course.nama}</td>
        <td>${course.semester}</td>
        <td>${course.sks}</td>
        <td>${course.sifat}</td>
        <td>${course.kelas}</td>
        <td>${course.ruangan}</td>
        <td>${course.hari}</td>
        <td>${course.jam_mulai} - ${course.jam_selesai}</td>
    `;
    row.appendChild(createActionCell(course, row)); // Pass 'row' to the function
    return row;
}

function createActionCell(course, row) {
    // Pass 'row' as a parameter
    const actionCell = document.createElement("td");

    const isSelected = course.is_selected;
    const pilihButton = createButton(
        isSelected ? "Dipilih" : "Pilih",
        isSelected ? "bg-gray-500" : "bg-[#2EC060]",
        isSelected
            ? null
            : async (event) => {
                  event.preventDefault();
                  const success = await postCourse(course);
                  if (success) {
                      event.target.textContent = "Dipilih";
                      event.target.classList.remove("bg-[#2EC060]");
                      event.target.classList.add("bg-gray-500");
                      event.target.disabled = true;
                  }
              },
        isSelected
    );

    actionCell.appendChild(pilihButton);

    const batalButton = createButton("Batal", "bg-red-600", () => {
        deleteCourse(course.kode_mk, course.nama, row); // Pass 'row' to the delete function
    });
    actionCell.appendChild(batalButton);
    return actionCell;
}

function createButton(text, bgColor, eventHandler, isDisabled = false) {
    const button = document.createElement("button");
    button.textContent = text;
    button.className = `w-16 h-8 text-center pt-px rounded-lg mt-4 ml-2 ${bgColor} text-white`;
    if (isDisabled) {
        button.disabled = true;
    } else {
        button.addEventListener("click", eventHandler);
    }
    return button;
}

async function postCourse(course) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    try {
        const response = await fetch("/mahasiswa/irs/store", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                semester: course.semester,
                kode_mk: course.kode_mk,
                nama_mk: course.nama,
                sks: course.sks,
            }),
        });
        const data = await response.json();
        if (!response.ok)
            throw new Error(data.message || "Failed to add course");
        console.log("Course selected successfully:", data);
        alert("Course selected successfully");
        return true; // Indicate success
    } catch (error) {
        console.error("Error adding course:", error);
        alert(error.message);
        return false; // Indicate failure
    }
}

function deleteCourse(kode_mk, nama_mhs, row) {
    fetch("/mahasiswa/irs/delete", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ kode_mk, nama_mhs }),
    })
        .then((response) => {
            if (response.ok) {
                return response.json(); // Only parse as JSON if the response is OK
            } else {
                throw new Error(
                    "Failed to delete course: Server responded with " +
                        response.status
                );
            }
        })
        .then((data) => {
            if (data.success) {
                console.log("Deletion successful:", data.message);
                row.remove(); // Remove the row from the table
            } else {
                throw new Error(data.message);
            }
        })
        .catch((error) => {
            console.error("Failed to delete course:", error);
        });
}
