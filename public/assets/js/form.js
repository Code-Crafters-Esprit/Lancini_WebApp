function previewImage(event) {
  const input = event.target;
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('image-preview');
      img.src = e.target.result;
      img.style.display = 'block';
      const imageUrlInput = document.getElementById('image-url-input');
      const filePath = window.URL.createObjectURL(input.files[0]); // get the local path of the selected file
      imageUrlInput.value = filePath;
      const imagePath = document.getElementById('image-path');
      imagePath.textContent = filePath; // set the text content of the image path div to the local path of the selected file
      imagePath.style.display = 'block'; // display the image path div
    }
    reader.readAsDataURL(input.files[0]);
  }
}