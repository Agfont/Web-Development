// Value
function changeText() {
	var textbox = document.getElementById("output");
	textbox.value += "Hello, world!"; // usar en <input>
};

// innerHTML
function addText() {
	var span = document.getElementById("output2");
	console.log(span);
	span.innerHTML += " bro!"; // innerHTML supports tags
};
