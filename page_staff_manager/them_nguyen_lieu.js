
/* =========================
   1. LẤY TÊN MÓN THEO ID
========================= */
document.getElementById('ID_Food').addEventListener('change', function () {
    const foodID = this.value;
    const nameInput = document.getElementById('food_name');

    if (foodID === "") {
        nameInput.value = "";
        return;
    }

    const formData = new FormData();
    formData.append('ID_food', foodID);

    fetch('lay_ten_food.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        nameInput.value = data;
    })
    .catch(() => {
        nameInput.value = "Lỗi lấy tên món";
    });
});


/* =========================
   2. THÊM NGUYÊN LIỆU
========================= */
function addMaterial() {
    const materials = document.getElementById("materials");
    const firstRow = document.querySelector(".material-row");

    // clone dòng đầu
    const newRow = firstRow.cloneNode(true);

    // reset dữ liệu
    newRow.querySelectorAll("input").forEach(input => {
        input.value = "";
    });

    newRow.querySelectorAll("select").forEach(select => {
        select.selectedIndex = 0;
    });

    materials.appendChild(newRow);
}


