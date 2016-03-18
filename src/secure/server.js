window.onload = init;
function init() {
	var button = document.getElementById("searchUser");
	button.onclick = handleButtonClick;
}

function handleButtonClick(){

	//Procurar na BD por IdUser.value

	//Retornar todos os serviços associados a esse user

	//Quando o user clica num serviço devolve a pass

	
	var li = document.createElement("li");
	li.innerHTML = "A ANA É LINDA " + IdUser.value;
	var ul = document.getElementById("serverList");
	ul.appendChild(li);
}