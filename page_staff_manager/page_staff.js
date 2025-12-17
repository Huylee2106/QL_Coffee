function showPage(id, el) {
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
    });

    document.getElementById(id).classList.add('active');

    document.querySelectorAll('.menu li').forEach(li => {
        li.classList.remove('active');
    });

    el.classList.add('active');
}
