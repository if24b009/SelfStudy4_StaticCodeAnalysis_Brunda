"use strict";
function handleFileUpload(fileInput) {
    if (fileInput === null || fileInput === void 0 ? void 0 : fileInput.files) {
        const file = fileInput.files[0]; // erste Datei aus dem Input
        if (!file) {
            alert('Bitte zuerst eine Datei auswählen!');
            return;
        }
        const formData = new FormData();
        formData.append('fileToUpload', file);
        fetch('base/imageUpload.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(result => {
            console.log('Upload erfolgreich:', result);
        })
            .catch(error => {
            console.log('Fehler beim Upload: ' + error);
        });
    }
}
function handleQuizSelectionChange(dropdown, selectedQuiz) {
    dropdown.addEventListener("change", () => {
        const selectedText = dropdown.options[dropdown.selectedIndex].text;
        const selectedValue = dropdown.options[dropdown.selectedIndex].value;
        selectedQuiz.textContent = `Du erstellst eine Frage zu Quiz "${selectedText}"`;
        const dataUploadDiv = document.getElementById("dependentData");
        if (Number(selectedValue) === 1 || Number(selectedValue) === 4) {
            dataUploadDiv.innerHTML = '<label for="countryCode" class="form-label fw-semibold">Ländercode ISO_A3<span class="text-primary">*</span></label> <input type="text" class="form-control" id="countryCode" name="countryCode">';
        }
        else {
            dataUploadDiv.innerHTML = '<label for="fileToUpload" class="form-label">Bild hinzufügen <small class="text-muted">(.jpg .jpeg .png .svg)</small></label> <input type="file" class="form-control" accept=".jpg, .jpeg, .png, .svg" name="fileToUpload" id="fileToUpload">';
        }
    });
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            if (checkbox.checked) {
                checkboxes.forEach((box) => {
                    if (box !== checkbox)
                        box.checked = false;
                });
            }
        });
    });
    //File upload
}
document.addEventListener("DOMContentLoaded", () => {
    //Dropdown for Quiz-Selection
    const dropdown = document.getElementById("selection");
    const selectedQuiz = document.getElementById("displayQuiz");
    handleQuizSelectionChange(dropdown, selectedQuiz);
    // AB DAAAAAAAAAAAAAAAAAAAAA
    const uploadBtn = document.getElementById('uploadBtn');
    if (uploadBtn) {
        uploadBtn.addEventListener('click', () => {
            const fileInput = document.getElementById('fileToUpload');
            handleFileUpload(fileInput);
        });
    }
});
