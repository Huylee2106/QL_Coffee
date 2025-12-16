document.addEventListener('DOMContentLoaded', () => {
      
      // === CÁC BIẾN CỦA GIỎ HÀNG (Đã có) ===
      let cart = []; // Mảng chứa các sản phẩm trong giỏ hàng
      const cartItemsContainer = document.getElementById('cart-items');
      const cartTotalPriceEl = document.getElementById('cart-total-price');
      const productListContainer = document.querySelector('.water');
      const emptyCartMsg = '<p class="empty-cart">Giỏ hàng của bạn đang trống.</p>';

      // === CÁC BIẾN MỚI CHO TÌM KIẾM ===
      const searchInput = document.getElementById('search-input');
      // Lấy danh sách TẤT CẢ các item sản phẩm (do PHP tạo ra)
      const allProductItems = document.querySelectorAll('.water .item'); 

      // --- Hàm định dạng tiền tệ (Đã có) ---
      function numberFormat(number) {
        return new Intl.NumberFormat('vi-VN').format(number);
      }

      // --- Hàm cập nhật giao diện giỏ hàng (Đã có) ---
      function renderCart() {
        // 1. Xóa nội dung cũ
        cartItemsContainer.innerHTML = '';
        
        // 2. Kiểm tra giỏ hàng rỗng
        if (cart.length === 0) {
          cartItemsContainer.innerHTML = emptyCartMsg;
          cartTotalPriceEl.textContent = '0 VND';
          return;
        }
        
        let totalPrice = 0;
        
        // 3. Vẽ lại từng món hàng
        cart.forEach(item => {
          const itemTotalPrice = item.gia * item.quantity;
          totalPrice += itemTotalPrice;
          
          const cartItemHTML = `
            <div class="cart-item">
              <img src="${item.img}" alt="${item.ten}">
              <div class="cart-item-info">
                <h4>${item.ten}</h4>
                <p>${numberFormat(item.gia)} VND x ${item.quantity}</p>
              </div>
              <button class="remove-from-cart" data-id="${item.id}">Xóa</button>
            </div>
          `;
          cartItemsContainer.innerHTML += cartItemHTML;
        });
        
        // 4. Cập nhật tổng tiền
        cartTotalPriceEl.textContent = numberFormat(totalPrice) + ' VND';
      }

      // --- Hàm thêm sản phẩm vào giỏ hàng (Đã có) ---
      function addToCart(id, ten, gia, img) {
        const existingItem = cart.find(item => item.id === id);
        
        if (existingItem) {
          existingItem.quantity++;
        } else {
          cart.push({ id, ten, gia, img, quantity: 1 });
        }
        renderCart();
      }

      // --- Hàm xóa sản phẩm khỏi giỏ hàng (Đã có) ---
      function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
      }

      // --- Lắng nghe sự kiện click GIỎ HÀNG (Đã có) ---

      // 1. Lắng nghe click trên DANH SÁCH SẢN PHẨM
      productListContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('add-to-cart')) {
          const button = e.target;
          const id = button.dataset.id;
          const ten = button.dataset.ten;
          const gia = parseFloat(button.dataset.gia);
          const img = button.dataset.img;
          
          addToCart(id, ten, gia, img);
        }
      });

      // 2. Lắng nghe click trên KHUNG GIỎ HÀNG (cho nút Xóa)
      cartItemsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-from-cart')) {
          const id = e.target.dataset.id;
          removeFromCart(id);
        }
      });

      // === HÀM LẮNG NGHE SỰ KIỆN TÌM KIẾM (MỚI) ===
      searchInput.addEventListener('input', () => {
        // Lấy từ khóa, chuyển sang chữ thường và bỏ dấu cách thừa
        const searchTerm = searchInput.value.toLowerCase().trim();

        // Lặp qua tất cả sản phẩm
        allProductItems.forEach(item => {
          // Lấy tên sản phẩm từ thẻ <h3>
          const productNameElement = item.querySelector('h3');
          
          if (productNameElement) {
            const productName = productNameElement.textContent.toLowerCase();
            
            // Kiểm tra xem tên sản phẩm có chứa từ khóa không
            if (productName.includes(searchTerm)) {
              item.style.display = ''; // Hiển thị sản phẩm (trả về CSS ban đầu)
            } else {
              item.style.display = 'none'; // Ẩn sản phẩm
            }
          }
        });
      });
      
        // === LỌC THEO LOẠI NƯỚC ===
    const filterButtons = document.querySelectorAll('.typewater button');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {

        // Xóa active cũ
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filterType = btn.dataset.filter;  // Lấy loại người dùng bấm

        // Lọc tất cả sản phẩm
        allProductItems.forEach(item => {
            const itemType = item.dataset.loai;  // Lấy 'loai' từ PHP

            if (filterType === "Tất cả") {
            item.style.display = "";
            } else if (itemType === filterType) {
            item.style.display = "";
            } else {
            item.style.display = "none";
            }
        });
        });
    });
    // dua du lieu gio hang sang trang thanh toan
    const checkoutBtn = document.getElementById('checkout-btn');
    const cartInput = document.getElementById('cart-input');
    const totalInput = document.getElementById('total-input');

    checkoutBtn.addEventListener('click', () => {
        cartInput.value = JSON.stringify(cart); // cart là mảng JS của bạn
        totalInput.value = cart.reduce((sum, item) => sum + item.gia * item.quantity, 0);
        document.getElementById('checkout-form').submit();
    });
      // Khởi tạo giỏ hàng khi tải trang (Đã có)
      renderCart();

    });