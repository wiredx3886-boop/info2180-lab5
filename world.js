document.addEventListener("DOMContentLoaded", function () {
    const lookupButton = document.getElementById("lookup");
    const countryInput = document.getElementById("country");
    const result = document.getElementById("result");

    if (!lookupButton || !countryInput || !result) return;

    lookupButton.addEventListener("click", function (event) {
        event.preventDefault();

        const params = new URLSearchParams();
        params.set("country", countryInput.value.trim());

        const lookupType = document.querySelector('input[name="lookup"]:checked');
        if (lookupType) params.set("lookup", lookupType.value);

        result.textContent = "Loading...";
        fetch("world.php?" + params.toString())
            .then(function (response) {
                if (!response.ok) throw new Error("Request failed");
                return response.text();
            })
            .then(function (html) {
                result.innerHTML = html;
            })
            .catch(function () {
                result.textContent = "Unable to retrieve results. Please try again.";
            });
    });
});