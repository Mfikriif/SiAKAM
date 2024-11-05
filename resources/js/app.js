import "./bootstrap";

import "./sweetalertHelper";

import "./button";

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

document.addEventListener("DOMContentLoaded", function () {
    const textElement = document.getElementById("typing-text");
    const text = textElement.textContent;
    textElement.textContent = "";
    let index = 0;

    function typeEffect() {
        if (index < text.length) {
            textElement.textContent += text.charAt(index);
            index++;
            setTimeout(typeEffect, 100);
        }
    }

    typeEffect();
});
