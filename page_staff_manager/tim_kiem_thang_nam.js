document.addEventListener("DOMContentLoaded", function() {

    // 1. LỌC DOANH THU (Giữ nguyên vì đúng ID)
    const revInput = document.getElementById("revenueSearch");
    if (revInput) {
        revInput.addEventListener("keyup", function() {
            filterTable("revenueTable", this.value, 0); 
        });
    }

    // 2. LỌC KHO (Giữ nguyên vì đúng ID)
    const invInput = document.getElementById("inventorySearch");
    if (invInput) {
        invInput.addEventListener("keyup", function() {
            let filter = this.value.toUpperCase();
            let table = document.getElementById("inventoryTable");
            let tr = table.getElementsByTagName("tr");
            let foundAny = false;

            for (let i = 1; i < tr.length; i++) {
                let tdID = tr[i].getElementsByTagName("td")[0];   
                let tdName = tr[i].getElementsByTagName("td")[1]; 
                if (tdID || tdName) {
                    let text = (tdID.textContent + tdName.textContent).toUpperCase();
                    if (text.indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        foundAny = true;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            const noRes = document.getElementById("noResult");
            if(noRes) noRes.style.display = foundAny ? "none" : "block";
        });
    }

    // 3. LỌC HÓA ĐƠN NHẬP KHO - ĐÃ SỬA ID Ở ĐÂY
    const receiptInputName = document.getElementById("receiptSearchName"); // Đã sửa từ receiptSearch
    const receiptInputDate = document.getElementById("receiptSearchDate"); // Đã sửa từ querySelector name

    function performReceiptFilter() {
        let nameFilter = receiptInputName.value.toUpperCase();
        let dateFilter = receiptInputDate.value; 
        let table = document.getElementById("stockReceiptTable");
        if (!table) return;

        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let tdName = tr[i].getElementsByTagName("td")[1]; // Cột Tên NL
            let tdDate = tr[i].getElementsByTagName("td")[2]; // Cột Ngày Nhập
            
            if (tdName && tdDate) {
                let nameValue = (tdName.textContent || tdName.innerText).toUpperCase();
                let dateValue = (tdDate.textContent || tdDate.innerText).trim(); 

                // So sánh ngày: dateFilter là yyyy-mm-dd, dateValue là yyyy-mm-dd
                let matchName = nameValue.indexOf(nameFilter) > -1;
                let matchDate = (dateFilter === "") || (dateValue === dateFilter);

                if (matchName && matchDate) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    if (receiptInputName) receiptInputName.addEventListener("input", performReceiptFilter);
    if (receiptInputDate) receiptInputDate.addEventListener("change", performReceiptFilter);

    // Hàm bổ trợ lọc bảng chung
    function filterTable(tableId, searchValue, columnIndex) {
        let filter = searchValue.toUpperCase();
        let table = document.getElementById(tableId);
        if (!table) return;
        
        let tr = table.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td")[columnIndex];
            if (td) {
                let txtValue = td.textContent || td.innerText;
                tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }
});

// Hàm reset cho nút "Làm mới"
function resetReceiptFilter() {
    document.getElementById('receiptSearchName').value = "";
    document.getElementById('receiptSearchDate').value = "";
    let tr = document.querySelectorAll("#stockReceiptTable tr");
    tr.forEach(row => row.style.display = "");
}