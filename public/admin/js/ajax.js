document.getElementById("category").addEventListener("change", function () {
    var category = this.value;
    var subcategorySelect = document.getElementById("subcategory");

    // Clear previous subcategory options
    subcategorySelect.innerHTML =
        "<option selected>Please choose a subcategory</option>";

    if (category) {
        fetch("/admin/get-subcategories/" + category)
            .then((response) => response.json())
            .then((data) => {
                subcategorySelect.disabled = false;
                data.forEach((subcategory) => {
                    var option = document.createElement("option");
                    option.value = subcategory.id;
                    option.text = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
            })
            .catch((error) =>
                console.error("Error fetching subcategories:", error)
            );
    } else {
        subcategorySelect.disabled = true;
    }
});
