document.addEventListener("DOMContentLoaded", function () {
    const countryInput = document.getElementById("country");
    const result = document.getElementById("result");

    function search(lookup) {
        const params = new URLSearchParams({ country: countryInput.value.trim() });
        if (lookup) params.set("lookup", lookup);

        result.textContent = "Loading...";
        fetch("world.php?" + params.toString())
            .then(function (response) {
                if (!response.ok) throw new Error("Request failed");
                return response.text();
            })
            .then(function (html) { result.innerHTML = html; })
            .catch(function () {
                result.textContent = "Unable to retrieve results. Please try again.";
            });
    }

    document.getElementById("lookup").addEventListener("click", function (e) {
        e.preventDefault();
        search();
    });

    document.getElementById("lookupCity").addEventListener("click", function (e) {
        e.preventDefault();
        search("cities");   // -> world.php?country=Jamaica&lookup=cities
    });
});