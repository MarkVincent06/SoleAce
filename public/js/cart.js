document.addEventListener("DOMContentLoaded", function () {
    const sizeSelects = document.querySelectorAll("[id^=product-size-]");
    const quantitySelects = document.querySelectorAll(
        "[id^=product-quantity-]"
    );

    sizeSelects.forEach((sizeSelect) => {
        sizeSelect.addEventListener("change", function () {
            const productId = this.getAttribute("data-product-id");
            const size = this.value;
            updateProductSize(productId, size);
        });
    });

    quantitySelects.forEach((quantitySelect) => {
        quantitySelect.addEventListener("change", function () {
            const productId = this.getAttribute("data-product-id");
            const quantity = this.value;
            updateProductQuantity(productId, quantity);
        });
    });

    function updateProductSize(productId, size) {
        const formData = new FormData();
        formData.append(
            "_token",
            document.querySelector('input[name="_token"]').value
        );
        formData.append("product_id", productId);
        formData.append("product_size", size);

        fetch(`/cart/${productId}`, {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.type === "success") {
                    console.log(data.message);
                    updateTotalPrice(data.totalPrice);
                } else {
                    console.error(data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

    function updateProductQuantity(productId, quantity) {
        const formData = new FormData();
        formData.append(
            "_token",
            document.querySelector('input[name="_token"]').value
        );
        formData.append("product_id", productId);
        formData.append("product_quantity", quantity);

        fetch(`/cart/${productId}`, {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.type === "success") {
                    console.log(data.message);
                    updateTotalPrice(data.totalPrice);
                } else {
                    console.error(data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

    function updateTotalPrice(totalPrice) {
        const totalPriceElements = document.querySelectorAll(
            ".summary--total p:last-child, .summary--subtotal p:last-child"
        );
        totalPriceElements.forEach((element) => {
            element.textContent = `₱ ${totalPrice}`;
        });
    }
});
