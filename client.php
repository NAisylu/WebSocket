<!Doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
	<h1>Exampe of a Websocket-client</h1>
	<form action="" name="messages">
        	<div class="row">Name: <input type="text" name="fname"></div>
		<div class="row">Message: <input type="text" name="msg"></div>
		<div class="row"><input type="submit" value="Send"></div>
	</form>
	<div id="status"></div>
	<script>
    	window.onload = function()	{
		var socket = new WebSocket("ws://localhost:8082");
        	var status = document.querySelector("#status");
        	console.log(socket)
	
	   	// открытие соединения
	   	socket.onopen = function(event) {
           		status.innerHTML = "The connection is established!<br>";
		};
		// закрытие соединения
		socket.onclose = function(event) {
			//проверка на то, как закрыто соединение
           		if (event.wasClean) {
               			//если "хорошо" закрыто
               			status.innerHTML = "The connection is closed<br>";
           		} else {
               			// если "плохо" закрыто
               			status.innerHTML = "The connection is closed somehow<br>";
			};
           		status.innerHTML += "<br>code: " + event.code + "<br>the reason: " + event.reason;	
       		};
		// получение данных
		socket.onmessage = function(event) {
			// прописываем, какие данные пришли
           		let message = JSON.parse(event.data);
           		status.innerHTML += "Data came in: <b>" + message.name + "</b> " + message.msg + "<br>";
       		};
       		// возникновение ошибок
       		socket.onerror = function(event) {
           		status.innerHTML = "error: " + event.message;
       		};
        
       		document.forms["messages"].onsubmit = function(){
           		// объявляем 2 переменные и данные из полей формы записываем в них
           		let message = {
               			name: this.fname.value,
               			msg: this.msg.value
           		}
           		// отправление данных в виде строки на websocket-сервер
           		socket.send(JSON.stringify(message));
           		return false;
       		}
	}
	</script>
</body>
</html>