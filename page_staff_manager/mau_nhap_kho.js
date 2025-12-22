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