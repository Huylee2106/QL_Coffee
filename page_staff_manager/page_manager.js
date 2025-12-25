function showPage(pageId) {
    // Ẩn tất cả page
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
    });

    // Hiện page được chọn
    document.getElementById(pageId).classList.add('active');

    // Active menu
    document.querySelectorAll('.menu li').forEach(item => {
        item.classList.remove('active');
    });

    event.target.classList.add('active');
}
