function previewImage(event) {
    var input = event.target;
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var img = document.getElementById("image-preview");
        img.src = e.target.result;
        img.style.display = "block";
      }
      reader.readAsDataURL(input.files[0]);
    }
  }


  