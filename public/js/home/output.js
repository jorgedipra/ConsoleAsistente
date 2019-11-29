class output {
  constructor() {}

  //salida en chat escrita de la IA
  static messageIA(msg = "") {
    let data2;
    setTimeout(() => {
      data2 = {
        user: "Al",
        message: msg,
        rol: "Alis",
        time: Time.horaSimple()
      };
      app.actividades.push(data2);
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
