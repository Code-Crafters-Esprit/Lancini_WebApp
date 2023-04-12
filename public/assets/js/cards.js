const contactSellerBtns = document.querySelectorAll('.contact-seller-btn');
const contactSellerPopups = document.querySelectorAll('.contact-seller-popup');

for (let i = 0; i < contactSellerBtns.length; i++) {
  contactSellerBtns[i].addEventListener('click', function(e) {
    e.stopPropagation();
    contactSellerPopups[i].classList.toggle('show');
  });
}

window.addEventListener('click', function() {
  for (let i = 0; i < contactSellerPopups.length; i++) {
    if (contactSellerPopups[i].classList.contains('show')) {
      contactSellerPopups[i].classList.remove('show');
    }
  }
});