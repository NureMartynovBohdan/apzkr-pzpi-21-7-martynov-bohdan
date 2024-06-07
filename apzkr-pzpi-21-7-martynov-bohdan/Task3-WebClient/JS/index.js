// Получаем текущий URL страницы
var currentURL = window.location.href;

// Находим ссылку, соответствующую текущему URL и добавляем классы "active" и "text-white"
var navLinks = document.querySelectorAll('.navbar-nav .nav-link');

for (var i = 0; i < navLinks.length; i++) {
   if (navLinks[i].href === currentURL) {
      navLinks[i].classList.add('active', 'text-white');
   }
}
