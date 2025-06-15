"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const rows = document.querySelectorAll(".clickable-row");
    rows.forEach((row) => {
        row.addEventListener("click", () => {
            const href = row.dataset.href;
            if (href) {
                window.location.href = href;
            }
            else {
                console.warn("Keine data-href gesetzt für Zeile:", row);
            }
        });
    });
});
