// Wait until body charges completely
jQuery(document).ready(function($){
    // jQuery effects
    $("#effect_phrase").show("bounce", 1500);
    $("#center_header").delay(1000).show("scale", 500);
    $("#env_header").delay(500).effect("shake", 1000); // effect after DOM object is already showed
    $("#banner_img").delay(1000).show("bounce", 1000); // effect after DOM object is already showed

    // Submit handler jQuery
    $("#search_button").on("click", formSubmit);

    // Request to get countries destinations
    $.get("getcountries.php", function(data, status){
        if (status === "success") {
            $("#countries_list").append(data); //insertAdjacentHTML("beforeend", data);
            $("#countries_list").show("slide", {direction: "right"}, 1000); // jQuery effect
        }
        else failedResponse();
    });

    // Set onClick to all <a> tags (selector) inside envs_list to dynamic DOM
    $("#envs_list").on("click", "a", envsClick);

    // Request to get destinations environments
    $.get("getenvs.php", function(data, status){
        if (status === "success")  {
            // Insert items inside div
            $("#envs_list").append(data); // Añadir elementos jQuery insertAdjacentHTML("beforeend", data);
            $("#envs_list").show("slide", 1000); // default: left
            // Make items clickable
        }   
        else failedResponse();
    });

    // Search destinations jQuery autocomplete 
    $("#destination").autocomplete({
        source: function(request, response) {
            $.get('gethint.php', { term: request.term }, function(data) {
                $("#destination").after(data);
            });
        },
        minLength: 1
    });

    // Initiate jQuery date pickers and spinner
    $("#checkin").datepicker({ 
            showAnim: "slideDown", // default: show 
            // dateFormat: "mm-dd-yy" // default: mm/dd/yy
    });
    $("#checkout").datepicker({ 
            showAnim: "slideDown", // default: show 
           // dateFormat: "mm-dd-yy" // default: mm/dd/yy
    });
    $("#guests").spinner({
        min: 1,
        max: 20
    });

});

function failedResponse() {
    alert("Failed Response");
    console.log("Failed response");
}

function envsClick(event) {
    // console.log(event.target.innerHTML); // Item clicked
    // Request to get destinations by environment
    $.get("getbyenv.php", {env: event.target.innerHTML}, function(data, status){
        if (status === "success") {
            $("#center_body").empty(); // Remover elementos jQuery
            $("#center_body").append(data);
            $("#cards_row").show('fade', 500);
        }   
        else failedResponse();
    });
}

/* Handle form submission using .val() (Prototype $F) gets the value*/
function formSubmit(event) {
    var destination = $("#destination").val().trim();
    var guests = $("#guests").val();
    var checkin = $("#checkin").val();
    var checkout = $("#checkout").val();
    if (destination.length == 0 || guests == 0 ||
        checkin.length == 0 || checkout.length == 0) {
        alert("Please fill out all fields!"); // show error message
        event.preventDefault(); // stop form submission
        return false;
    }

    else if (!checkDestination(destination)) {
        alert("Destination field should be filled correctly!"); // show error message
        event.preventDefault(); // stop form submission
        return false;
    }

    else if (!checkDates(checkin, checkout)) {
        alert("Checkin must be greater or equal than today and before check-out!"); // show error message
        event.preventDefault(); // stop form submission
        return false;
    }
    else if (!checkGuests(guests)) {
        alert("Guests number must be between 1 and 20!"); // show error message
        event.preventDefault(); // stop form submission
        return false;
    }

    $.ajax ({ 
        url: 'search_results.php',
        method: 'POST',
        data: {  
            "destination": destination, "checkin": checkin, 
            "checkout": checkout, "guests": guests 
        },
        success: function(data, textStatus) {
            $("#results_body")[0].innerHTML = data; //$("#results_body").html(data);
            console.log($("#results_body"));
        },
        error: function(error) {
            $("#results_body")[0].innerHTML = error;
        }
    });
};

function checkDestination(dest) {
    const regex = /^[a-zA-Z\u00C0-\u00FF -]{1,20}$/;  // [1,20] characters,  Unicode do 'À' até o 'ÿ'
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