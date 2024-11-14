import "./bootstrap";
import "./sweetalertHelper";
import "./button";
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

document.addEventListener("DOMContentLoaded", function () {
    // Memulai event listeners
    setupOptionListeners();

    const jurusanSelect = document.getElementById("jurusanFilter");
    if (jurusanSelect) {
        jurusanSelect.addEventListener("change", filterRuangan);
    }
});
