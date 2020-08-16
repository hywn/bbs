document.getElementById("button").addEventListener("click", myFunction);
function myFunction(){
  let temp = document.createElement('p');
  temp.innerHTML = document.getElementById("name").value + ":<br>";
  temp.innerHTML += document.getElementById("content").value;
  temp.style = "font-family:courier; background-color: pink; padding: 10px";
  let div = document.getElementById("div");
  div.append(temp);
  document.getElementById("name").value = "";
  document.getElementById("content").value = "";
}