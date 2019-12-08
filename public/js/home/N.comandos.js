class comandos {
  constructor() {
    this.command;
    comandos.on();
  }
  static on() {
    comandos.command = {
        "VER COMANDOS": "cm-all",
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

