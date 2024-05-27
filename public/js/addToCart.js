document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");

    addToCartButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");
            const sizeSelect = document.getElementById(
                `product-size-${productId}`
            );
            const quantitySelect = document.getElementById(
                `product-quantity-${productId}`
            );
            const size = sizeSelect.value;
            const quantity = quantitySelect.value;

            const formData = new FormData();
            formData.append(
                "_token",
                document.querySelector('input[name="_token"]').value
            );
            formData.append("product_id", productId);
            formData.append("product_size", size);
            formData.append("product_quantity", quantity);

            fetch("/add-to-cart", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: data.type,
                        title: data.message,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 3000,
                        didOpen: (toast) => {
                            toast.addEventListener(
                                "mouseenter",
                                Swal.stopTimer
                            );
                            toast.addEventListener(
                                "mouseleave",
                                Swal.resumeTimer
                            );
                        },
                    });
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "Failed to add product to cart",
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 3000,
                        didOpen: (toast) => {
                            toast.addEventListener(
                                "mouseenter",
                                Swal.stopTimer
                            );
                            toast.addEventListener(
                                "mouseleave",
                                Swal.resumeTimer
                            );
                        },
                    });
                });
        });
    });
});
