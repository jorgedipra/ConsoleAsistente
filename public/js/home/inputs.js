var recognizer = null;

/**
 *  
  PENDING : 
 # 1 revisar la version de movil la de escritorio responde bien 
 # 2 pasar a clases
 # 3 revisar copmandos de voz
 */
function Escuchar() {
  output.contar=0;
  comandosOff();
  //speechRecognization interface inicializando servicios
  window.speechRecognition =
    window.speechRecognition ||
    window.webkitSpeechRecognition ||
    window.mozSpeechRecognition ||
    window.webkitSpeechRecognition;
  if (window.speechRecognition == undefined) {
    hablar("Speech Recogniztion API no es compatible");
  } else {
    recognizer = new speechRecognition();
    //Si se establece en 'falso', el reconocedor deja de escuchar automáticamente cuando el usuario deja de hablar la primera oración.
    recognizer.continuous = true;
    recognizer.lang = "es-ES";
    //se establece en verdadero y luego se activa la devolución de llamada de un resultado después de cada palabra hablada por el usuario. De lo contrario, después del final de la oración.
    recognizer.interimResults = true;
    recognizer.onstart = function() {
      // hablar("Estoy escuchando");
      app.estado = "Estoy escuchando";
      app.classMicroIco = "fas fa-microphone"; //cambio de icono
    };

    //disparado cada vez que el usuario deja de hablar.
    recognizer.onresult = function(event) { 
      let tem = "";
      let fin = false;
      output.contar++;
      for (
        var count = event.resultIndex;
        count < event.results.length;
        count++
      ) {
        if (event.results[count].isFinal) {
          tem = event.results[count][0].transcript;
          fin = event.results[count].isFinal;
        } else {
          tem = "Escuchando...";
        }
      }
      setTimeout(function(param1){
        if(param1==output.contar){
          if (recognizer != null)
             recognizer.stop();
        }
      }, 2500,output.contar);

      $("#actividad").value = tem;

      if (fin) {
        //envia enter
        var i = 0;
            NoEscuchar();
            setTimeout(() => {
              comandosOn();
            }, 2000);

      }//::END=>if
    };
    //Se dispara cuando el reconocimiento se detiene manual o automáticamente.
    recognizer.onend = function() {
      recognizer = null;
      if($("#actividad").value!='Escuchando...'){
        enviar();
      }
      // hablar("No Estoy escuchando");
      app.estado = "No estoy escuchando";
      app.classMicroIco = "fas fa-microphone-slash"; //cambio de icono
      comandosOn();
    };
    recognizer.start();
  }
}

function NoEscuchar() {
  if (recognizer != null) {
    recognizer.stop();
    enviar();
    // hablar("No Estoy escuchando");
    app.estado = "No estoy escuchando";
    app.classMicroIco = "fas fa-microphone-slash"; //cambio de icono
  }
}

function comandosOff() {
  annyang.abort();
  app.estado = "No estoy escuchando comandos";
  app.classMicroIco = "fas fa-microphone-slash"; //cambio de icono
  app.classComanON = "ComanOFF";
  app.classComanOFF = "ComanON";
}

function comandosOn() {
  if (annyang) { 
  
    // Let's define a command.
    var commands = {
      hola: function() {
        alert("hola");
      },
      escuchar: function() { 
      
        Escuchar();
      },
      alice: function() {
        Escuchar();
      },
      alis: function() {
        Escuchar();
      },
      enviar: function() {
        enviar();
      }
    };
    // Add our commands to annyang
    annyang.addCommands(commands);
    //lenguaje
    annyang.setLanguage("es-MX");

    // Start listening.
    annyang.start();
    app.estado = "Estoy escuchando comandos";
    app.classMicroIco = "fas fa-microphone-slash"; //cambio de icono
    app.classComanON = "ComanON";
    app.classComanOFF = "ComanOFF";
    app.classMicro = "micro-in";
    app.classEnviar = "enviar-on";
  }
}
var cache = "";
function enviar() {
  cadena = $("#actividad").value;
  if (cache == cadena) return false;
  if (cadena == "" || cadena == null) return false;
  cache = cadena;
  $("#enviar").click();
  app.actividad = "";
  app.actividad = null;
  $("#actividad").value = "";
}
