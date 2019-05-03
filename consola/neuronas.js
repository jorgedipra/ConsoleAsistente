//respuesta automatica
const message = (msg = "") => {
    data2 = {
        user: "Al",
        message: msg,
        rol: "Alis"
    };
    setTimeout(() => {
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
        }
        //disparado cada vez que el usuario deja de hablar.
        recognizer.onresult = function (event) {           
            for (var count = event.resultIndex; count < event.results.length; count++) { 
                document.getElementById("actividad2").innerHTML += event.results[count][0].transcript;
                document.getElementById("actividad").value = event.results[count][0].transcript;
            }
        }
        //Se dispara cuando el reconocimiento se detiene manual o automáticamente.
        recognizer.onend = function () {
            recognizer = null;
            hablar("No Estoy escuchando");
        }
        recognizer.start();
    }
}

function NoEscuchar() {
    if (recognizer != null) {
        recognizer.stop();
        document.getElementById("enviar").click();
        hablar("No Estoy escuchando");
    }
}