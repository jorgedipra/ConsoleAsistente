class funcionesComandos {
  constructor() {
    funcionesComandos.on();
  }
  static on() {return true;}

  static hola() {
    if (localStorage.getItem("user")) {
      output.messageIA(
        "Hola " + localStorage.getItem("user") + ", en que te puedo ayudar?"
      );
    } else {
      output.messageIA("Hola, como te llamas?");
      duda.status = 200;
    }
    return true;
  }
  static vercomandos() {
    $("#tablero").innerHTML = "";
  }
}
new funcionesComandos();
