document.observe("dom:loaded", function() {
    $("destination").observe("keyup", function() {
        if ($F("destination").length == 0) { // Key without output (ex: Alt, Ctrl)
            $("destination").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    $("destination").innerHTML += this.responseText;
                }
            };
            xmlhttp.open("POST", "gethint.php?q=" + $F("destination"), true);
            xmlhttp.send();
        }
    });
});