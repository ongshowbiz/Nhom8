// js/cart.js
function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalItems = cart.reduce((sum, item) => sum + parseInt(item.quantity || 0), 0);
    
    let cartCountElement = document.getElementById('cartCount');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}

function addToCart(productId, productName, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Kiểm tra sản phẩm đã có chưa
    let existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity = parseInt(existingItem.quantity) + 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: price,
            image: image,
            quantity: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    
    alert('Đã thêm sản phẩm vào giỏ hàng!');
}

// Chạy khi trang load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});