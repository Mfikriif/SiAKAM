function ambilMatkul(event, kodeMk) {
    event.preventDefault();

    const button = event.target;

    if (button.innerText === "Ambil") {
        button.innerText = "Batalkan";
        button.classList.replace("bg[#22E606]", "bg-red-600");

        const row = document.getElementById("row-" + kodeMk);
        row.classList.add("bg-gray-700", "text-white");
    } else {
        button.innerText = "Ambil";
        button.classList.replace("bg-red-600", "bg-[#22E606]");

        const row = document.getElementById("row-" + kodeMk);
        row.classList, remove("bg-gray-700", "text-white");
    }
}
