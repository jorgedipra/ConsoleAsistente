class duda {
  constructor() {}

  static palabraDesconocida(palabra, cont) {
    console.log(cont);
    output.messageIA("No entiendo. ¿Que significa: '" + palabra + "' ?");
    localStorage.setItem("status", '100');
    return "100";
  }
  static significado(significado) {
    return "200";
  }
}
new duda();
