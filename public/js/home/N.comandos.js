class comandos {
  constructor() {
    this.command;
    comandos.on();
  }
  static on() {
    comandos.command = {
        HOLA: "hola",
        ADIÓS: "exit",
        ADIOS: "exit",
        "QUE HACES": "Aprender",
        SALIR: "adios!"
      };
    return true;
  }
}
new comandos();

