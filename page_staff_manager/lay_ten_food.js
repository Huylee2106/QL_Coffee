document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('ID_Food').addEventListener('change', function () {
        var food_id = this.value;
        var nameInput = document.getElementById('food_name');

        if (food_id !== "") {
            var formData = new FormData();
            formData.append('ID_food', food_id);

            fetch('lay_ten_food.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                nameInput.value = data;
            })
            .catch(err => {
                console.log(err);
                nameInput.value = "Lỗi kết nối";
            });
        } else {
            nameInput.value = "";
        }
    });
});

