function previewImage(event) {
  const input = event.target;
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('image-preview');
      img.src = e.target.result;
      img.style.display = 'block';
      const imagePath = document.getElementById('image-path');
      const filePath = window.URL.createObjectURL(input.files[0]);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
