window.addEventListener('scroll', function () {
    var header = document.querySelector('.header-menu');
    if (window.scrollY > 0) {
        header.classList.add('shadow');
    } else {
        header.classList.remove('shadow');
    }
});