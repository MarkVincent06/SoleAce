document.addEventListener("DOMContentLoaded", function () {
    const toastMsgInput = document.getElementById("toastMsg-input");
    const toastTypeInput = document.getElementById("toastType-input");

    if (toastMsgInput && toastTypeInput) {
        const message = toastMsgInput.value;
        const type = toastTypeInput.value;

        Swal.fire({
            toast: true,
            position: "top-end",
            icon: type,
            title: message,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });
    }
});
