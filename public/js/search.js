document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const clearBtn = document.getElementById("clearBtn");
    const form = document.getElementById("searchForm");
    let timeout = null;

    if (searchInput && form) {
        searchInput.addEventListener("input", function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.submit();
            }, 500);
        });
    }

    if (clearBtn && form && searchInput) {
        clearBtn.addEventListener("click", function (e) {
            e.preventDefault();
            searchInput.value = "";
            clearTimeout(timeout);
            form.submit();
        });
    }
});
