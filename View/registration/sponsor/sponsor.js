
const fileInput = document.getElementById("file-upload");
const previewCard = document.getElementById("preview-card");
const logoPreview = document.getElementById("logo-preview");
const displayName = document.getElementById("display-name");
const removeBtn = document.getElementById("remove-btn");

fileInput.addEventListener("change", function () {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            logoPreview.src = e.target.result;
            displayName.textContent = file.name;
            previewCard.style.display = "block";
        };

        reader.readAsDataURL(file);
    }
});

// Remove image preview
removeBtn.addEventListener("click", function () {
    fileInput.value = "";
    previewCard.style.display = "none";
    logoPreview.src = "#";
});

function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}

function closeModalOutside(event, id) {
    if (event.target === document.getElementById(id)) {
        closeModal(id);
    }
}