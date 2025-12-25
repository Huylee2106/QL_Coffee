function updateNLDetails() {
    var select = document.getElementById("select_MT");
    if (!select) return; // Bảo vệ nếu không tìm thấy thẻ select

    var selectedOption = select.options[select.selectedIndex];
    var nameInput = document.getElementById("Name_MT");
    var unitInput = document.getElementById("Unit");
    var newIdGroup = document.getElementById("new_id_group");
    var newIdInput = document.getElementById("new_ID_MT");

    if (select.value === "NEW") {
        // TRƯỜNG HỢP THÊM MỚI
        nameInput.value = "";
        unitInput.value = "";
        nameInput.readOnly = false;
        unitInput.readOnly = false;
        
        if(newIdGroup) newIdGroup.style.display = "block";
        if(newIdInput) newIdInput.required = true;
        
        nameInput.placeholder = "Nhập tên mới...";
        unitInput.placeholder = "Nhập đơn vị mới...";
    } 
    else if (select.value !== "") {
        // TRƯỜNG HỢP CHỌN CÓ SẴN
        nameInput.value = selectedOption.getAttribute("data-name") || "";
        unitInput.value = selectedOption.getAttribute("data-unit") || "";
        
        nameInput.readOnly = true;
        unitInput.readOnly = true;
        
        if(newIdGroup) newIdGroup.style.display = "none";
        if(newIdInput) newIdInput.required = false;
    } 
    else {
        nameInput.value = "";
        unitInput.value = "";
        nameInput.readOnly = true;
        unitInput.readOnly = true;
        if(newIdGroup) newIdGroup.style.display = "none";
    }
}


function filterInventory() {
    // 1. Khai báo biến
    let input = document.getElementById("inventorySearch");
    let filter = input.value.toUpperCase();
    let table = document.getElementById("inventoryTable");
    let tr = table.getElementsByTagName("tr");
    let noResult = document.getElementById("noResult");
    let found = false;

    // 2. Lặp qua tất cả các hàng trong bảng (bỏ qua tiêu đề - index 0)
    for (let i = 1; i < tr.length; i++) {
        // Lấy cột Tên Nguyên Liệu (cột thứ 2, index là 1)
        let tdName = tr[i].getElementsByTagName("td")[1];
        // Lấy thêm cột Mã NL nếu muốn tìm theo mã (cột thứ 1, index là 0)
        let tdID = tr[i].getElementsByTagName("td")[0];

        if (tdName || tdID) {
            let nameValue = tdName.textContent || tdName.innerText;
            let idValue = tdID.textContent || tdID.innerText;
            
            // Kiểm tra xem từ khóa có nằm trong Tên hoặc Mã không
            if (nameValue.toUpperCase().indexOf(filter) > -1 || idValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = ""; // Hiện dòng
                found = true;
            } else {
                tr[i].style.display = "none"; // Ẩn dòng
            }
        }
    }

    // 3. Hiển thị thông báo nếu không tìm thấy gì
    noResult.style.display = found ? "none" : "block";
}