class output {
  constructor() {}

  //salida en chat escrita de la IA
  static messageIA(msg = "", code) {
    let data2;
    setTimeout(() => {
      
      if (code == "code") {
        data2 = {
          user: "Al",
          message: msg,
          rol: "Alis",
          time: Time.horaSimple(),
          isclass: 'Color-Ia'
        };
        app.actividades.push(data2);
        //ejecuta codigo html
        var k = setInterval(() => {
          try {
            let cadena = document.getElementsByName("Al");
            let cont = cadena.length - 1;
            cadena[cont].style.color = "#840d46";
            cadena[cont].innerHTML = output.convertHTMLEntity(
              cadena[cont].innerHTML
            );
            cadena[cont].style.color = "#fff";
            clearInterval(k);
          } catch (e) {}
        }, 10);
      }else{
        data2 = {
          user: "Al",
          message: msg,
          rol: "Alis",
          time: Time.horaSimple(),
          isclass: ''
        };
        app.actividades.push(data2);
      } //::END=>if

      output.speech(msg);
      app.actividad = null;
    }, 1000);
  } //::END=>messageIA

  //salida en chat escrita por el usuario
  static messageUser = data => {
    data.time = Time.horaSimple();
    setTimeout(() => {
      app.actividades.push(data);
    }, 500);
  }; //::END=>messageUser

  //Salida de chat en voz
  static speech = message => {
    let speech = new SpeechSynthesisUtterance();
    // Establecer los atributos de texto y voz.
    speech.text = message;
    speech.volume = 1;
    speech.rate = 1;
    speech.pitch = 1;
    window.speechSynthesis.speak(speech);
  };

  static convertHTMLEntity(text) {
    const span = document.createElement("span");
    return text.replace(/&[#A-Za-z0-9]+;/gi, (entity, position, text) => {
      span.innerHTML = entity;
      return span.innerText;
    });
  } //::END=>convertHTMLEntity
}
new output();

//salida en chat escrita
const message = (msg = "") => {
  setTimeout(() => {
    data2 = {
      user: "Al",
      message: msg,
      rol: "Alis"
    };
    app.actividades.push(data2);
    hablar(msg);
    app.actividad = null;
  }, 1000);
};
const messageUser = data => {
  setTimeout(() => {
    app.actividades.push(data);
  }, 500);
};
//Salida de chat en voz
const hablar = message => {
  var speech = new SpeechSynthesisUtterance();
  // Establecer los atributos de texto y voz.
  speech.text = message;
  speech.volume = 1;
  speech.rate = 1;
  speech.pitch = 1;
  window.speechSynthesis.speak(speech);
};
