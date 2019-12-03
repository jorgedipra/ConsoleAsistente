class respuestas {
  constructor() {
    this.cadena;
    this.user;
  }
  static opciones() {
    let command = {
      HOLA: "hola",
      ADIÓS: "exit",
      ADIOS: "exit",
      "QUE HACES": "Aprender",
      SALIR: "adios!"
    };
    if (this.cadena in command) {
      respuestas.comandos(this.cadena);
    } else {
      output.messageIA("ok -respuesta");
    }
    return true;
  }
  static comandos(cadena) {
    switch (cadena) {
      case "HOLA":
        respuestas.hola();
        break;
      default:
        console.log("comando");
        break;
    }

    return true;
  }
  static hola() {
    if (localStorage.getItem("user")) {
        output.messageIA("Hola " + localStorage.getItem("user") + ", en que te puedo ayudar?");
    }else{
    output.messageIA("Hola, como te llamas?");
    duda.status = 200;
    }
    return true;
  }

  static nombre(data) {
    output.messageUser(data);
    localStorage.setItem("user", data.message);
    this.user=localStorage.getItem("user")
    this.user=preparar.capital(this.user);
    output.messageIA("hola " + this.user);
    output.messageIA("¿en que te puedo ayudar?");
    duda.status = undefined;
    return true;
  }
}
new respuestas();
