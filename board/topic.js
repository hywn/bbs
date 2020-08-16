const SUBMIT_BUTTON = document.querySelector('#submit_button')
const CONTENT_FIELD = document.querySelector('#content')

SUBMIT_BUTTON.addEventListener('click', e => {
	const temp = document.createElement('p');

	temp.innerHTML = document.getElementById("name").value + ":<br>";
	temp.innerHTML += CONTENT_FIELD.value;
	temp.style = "font-family:courier; background-color: pink; padding: 10px";

	document.getElementById("div").append(temp);

	CONTENT_FIELD.value = ''
})