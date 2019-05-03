//respuesta automatica
const message = (msg = "") => {
    setTimeout(() => {
        data2 = {
            user: "Al",
            message: msg,
            rol: "Alis"
        };
        app.actividades.push(data2);
        hablar(msg);
    }, 1000);
}

function hablar(message) {
    var speech = new SpeechSynthesisUtterance();

    // Establecer los atributos de texto y voz.
    speech.text = message;
    speech.volume = 1;
    speech.rate = 1;
    speech.pitch = 1;

    window.speechSynthesis.speak(speech);
}
var recognizer = null;

function Escuchar() {
    comandosOff()
    //speechRecognization interface inicializando servicios
    window.speechRecognition = window.speechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.webkitSpeechRecognition;
    if (window.speechRecognition == undefined) {
        hablar("Speech Recogniztion API no es compatible");
    } else {
        recognizer = new speechRecognition();
        //Si se establece en 'falso', el reconocedor deja de escuchar automáticamente cuando el usuario deja de hablar la primera oración.
        recognizer.continuous = true;
        recognizer.lang = "es-ES";
        //se establece en verdadero y luego se activa la devolución de llamada de un resultado después de cada palabra hablada por el usuario. De lo contrario, después del final de la oración.
        recognizer.interimResults = true;
        recognizer.onstart = function () {
            hablar("Estoy escuchando");
            app.estado="Estoy escuchando";
        }
        
        //disparado cada vez que el usuario deja de hablar.
        recognizer.onresult = function (event) {          
            for (var count = event.resultIndex; count < event.results.length; count++) { 
                document.getElementById("actividad2").innerHTML += event.results[count][0].transcript;
                document.getElementById("actividad").value = event.results[count][0].transcript;
            } 
            // espera 3 segundos y envia enter
            var i=0;
            clearInterval(h);
            var h = setInterval(() => {
                i++;
                if(i==3){
                    enviar();
                    clearInterval(h);
                }      
             }, 1000);          
        }
        //Se dispara cuando el reconocimiento se detiene manual o automáticamente.
        recognizer.onend = function () {
            recognizer = null;
            enviar();
            // hablar("No Estoy escuchando");
            app.estado="No estoy escuchando";
            comandosOn()
        }
        recognizer.start();
    }
}

function NoEscuchar() {
    if (recognizer != null) {
        recognizer.stop();
        enviar();
        // hablar("No Estoy escuchando");
        app.estado="No estoy escuchando";
        comandosOn()
    }
}

function comandosOff(){
    annyang.abort();
    app.estado="No estoy escuchando comandos";
}

function comandosOn(){
    app.estado="Estoy escuchando comandos";
            if (annyang) {
            // Let's define a command.
            var commands = {
            'hola': function() { alert('hola'); },
            'escuchar': function() { Escuchar() },
            'enviar': function() { enviar() },
            };
            // Add our commands to annyang
            annyang.addCommands(commands);
            //lenguaje
            annyang.setLanguage("es-MX");

            // Start listening.
            annyang.start();
            }
}

function enviar(){
    cadena = document.getElementById("actividad").value;
        if(cadena=="" || cadena==null)
            return false;
    document.getElementById("enviar").click();
    app.actividad="";
    document.getElementById("actividad").value="";
}