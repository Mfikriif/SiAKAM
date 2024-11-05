document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".pilih-checkbox");

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            const id = this.id.split("-").pop();
            const label = document.getElementById(`pilihLabel-${id}`);

            if (this.checked) {
                label.textContent = "Dipilih";
            } else {
                label.textContent = "Pilih";
            }
        });
    });
});
