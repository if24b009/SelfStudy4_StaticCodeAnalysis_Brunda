document.addEventListener("DOMContentLoaded", () => {
    const rows: NodeListOf<HTMLTableRowElement> = document.querySelectorAll(".clickable-row");

    rows.forEach((row: HTMLTableRowElement) => {
        row.addEventListener("click", () => {
            const href = row.dataset.href;
            if (href) {
                window.location.href = href;
            } else {
                console.warn("Keine data-href gesetzt für Zeile:", row);
            }
        });
    });
});
