document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const clearBtn = document.getElementById("clearBtn");
    const form = searchInput.form;
    let timeout = null;

    searchInput.addEventListener("input", function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            form.submit();
        }, 500);
    });

    clearBtn.addEventListener("click", function () {
        searchInput.value = "";
        clearTimeout(timeout);
        form.submit();
    });
});
