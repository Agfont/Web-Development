window.onload = pageLoad; // Wait until body charges completely
function pageLoad() {
    var form = $("search_form"); // $ equal to document.getElementById()
	form.observe = ("click", formSubmit); // Event handler Protoype observe
    // Scriptaculous autocompletes
    new Autocompleter.Local("destination","destlist",
        ["Barcelona", "Paris", "Porto", "São Paulo", "Brisbane", "Roma", "Rio de Janeiro"],
        {}
    );
    // Scriptaculous 
    $("google_msg").grow({
        duration: 1.0,
    });
    $("deals_header").shake({
        duration: 1.0,
    });
};

/* Handle form submission using Prototype*/
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

    else if (!checkDates($F("checkin"),$F("checkout"))) {
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
