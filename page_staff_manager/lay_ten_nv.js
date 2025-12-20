document.getElementById('ID_NV').addEventListener('change', function() {
    var employeeID = this.value;
    var nameInput = document.getElementById('name_NV');

    if (employeeID !== "") {
        // Sử dụng Fetch API để lấy dữ liệu từ server
        var formData = new FormData();
        formData.append('id', employeeID);

        fetch('lay_ten_nv.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            nameInput.value = data; // Điền tên vào ô input
        })
        .catch(error => {
            console.error('Lỗi:', error);
            nameInput.value = "Lỗi kết nối";
        });
    } else {
        nameInput.value = ""; // Xóa trắng nếu không chọn ID
    }
});
