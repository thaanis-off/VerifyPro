document.addEventListener("DOMContentLoaded", function () {
  const dropArea = document.getElementById("drop-area");
  const fileInput = document.getElementById("dropzone-file");
  const dropdownContent = document.getElementById("dropdownContent");
  const imgName = document.getElementById("img-name");

  // Click to upload
  // dropArea.addEventListener("click", () => {
  //     fileInput.click();
  // });

  // Show file name when file is selected
  fileInput.addEventListener("change", (event) => {
    const file = event.target.files[0];
    if (file) {
      imgName.textContent = `${file.name}`;
      imgName.style.display = "block";
      dropdownContent.style.display = "none"; // Hide the default text
    }
  });

  // Drag-and-drop functionality
  dropArea.addEventListener("dragover", (event) => {
    event.preventDefault();
    dropArea.style.borderColor = "#007bff"; // Highlight border on drag over
  });

  dropArea.addEventListener("dragleave", () => {
    dropArea.style.borderColor = "#ccc"; // Reset border color on drag leave
  });

  dropArea.addEventListener("drop", (event) => {
    event.preventDefault();
    const file = event.dataTransfer.files[0];
    if (file) {
      fileInput.files = event.dataTransfer.files; // Populate input field with dropped file
      imgName.textContent = `Selected File: ${file.name}`;
      imgName.style.display = "block";
      dropdownContent.style.display = "none"; // Hide the default text
    }
    dropArea.style.borderColor = "#ccc"; // Reset border color
  });
});
