// Wait until body charges completely
window.onload = pageLoad; // equal to document.observe("dom:loaded", function() {
function pageLoad() {
    var form = $("search_form"); // equal to document.getElementById()
    form.onsubmit = formSubmit; // Submit event

    // Request to get countries destinations
    new Ajax.Request("getcountries.php", {
        method: "GET",
        onSuccess: countriesSuccessfulResponse,
        onFailure: failedResponse
    });

    // Request to get destinations environments
    new Ajax.Request("getenvs.php", {
        method: "GET",
        onSuccess: envsSuccessfulResponse,
        onFailure: failedResponse
    });

    // Scriptaculous 
    $("center_header").grow({
        duration: 1.0,
    });
    $("env_header").shake({
        duration: 1.0,
    });
};

function countriesSuccessfulResponse(ajax) {
    if (ajax.status === 200) 
        $("countries_list").insertAdjacentHTML("beforeend", ajax.responseText);
}

function envsSuccessfulResponse(ajax) {
    if (ajax.status === 200) {
        // Insert items inside div
        $("envs_list").insertAdjacentHTML("beforeend", ajax.responseText);
        // Make items clickable
        var envs_list = $("envs_list");
        var nodes = envs_list.getElementsByTagName("a");
        for (let i = 0; i < nodes.length; i++) {
            nodes[i].onclick = envsClick;
        }
    }
}

function getByEnvSuccessfulResponse(ajax) {
    if (ajax.status === 200) {
        var center_body = document.getElementById("center_body");
        while (center_body.hasChildNodes())center_body.removeChild(center_body.firstChild);
        center_body.insertAdjacentHTML("beforeend", ajax.responseText);
    }
}

function failedResponse(ajax) {
    alert("Failed Response");
    console.log("Failed response");
}
function envsClick(event) {
    // console.log(event.target.innerHTML); // Item clicked
    // Request to get destinations by environment
    new Ajax.Request("getbyenv.php", {
        method: "GET",
        parameters: {env: event.target.innerHTML} ,
        onSuccess: getByEnvSuccessfulResponse,
        onFailure: failedResponse
    });

}
/* Handle form submission using Prototype
   $F gets the value*/
function formSubmit(event) {
    if ($F("destination").trim().length == 0 || $F("guests") == 0 ||
        $F("checkin").length == 0 || $F("checkout").length == 0) {
        alert("Please fill out all fields!"); // show error message
        event.preventDefault(); // stop form submission
        return false;
    }

    else if (!checkDestination($F("destination").trim())) {
        alert("Destination field should be filled correctly!"); // show error message
        event.preventDefault(); // stop form submission
        return false;
    }

    else if (!checkDates($F("checkin"), $F("checkout"))) {
        alert("Checkin must be greater or equal than today and before check-out!"); // show error message
        event.preventDefault(); // stop form submission
        return false;
    }
    else if (!checkGuests($F("guests"))) {
        alert("Guests number must be between 1 and 20!"); // show error message
        event.preventDefault(); // stop form submission
        return false;
    }
};

function checkDestination(dest) {
    const regex = /^[a-zA-Z -]{1,20}$/;  // [1,20] characters
    return regex.test(dest);
};

function checkGuests(guests) {
    const regex = /^[1-9]$|^1[0-9]$|^20$/; // [1,20] guests
    return regex.test(guests);
};

function checkDates(d1, d2) {
    var date1 = new Date(d1);
    var date2 = new Date(d2);
    return date1 < date2 && date1 >= new Date();
};