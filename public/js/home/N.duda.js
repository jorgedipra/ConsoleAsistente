class duda {
  constructor() {
    let palabra = this.palabra;
    let ciclos = this.ciclos;
    this.word = {};
    this.status;
    this.msg;
    this.cont = 0;
  }

  static palabras(palabra, ciclos) {
    let i = 0;
    let cont = 0;
    var text = '{ "json" : [{ "id":"" , "palabra":"" , "status":"true" } ]}';
    var obj = JSON.parse(text);
    var h = setInterval(() => {
      i++;
      if (i == 20) {
        clearInterval(h);
      }
      if (stack.count == palabra.length) {
        for (let i in palabra) {
          if (stack.one(i).status != "true") {
            cont++;
            this.word = obj;
            this.word.json[cont] = {
              id: cont,
              palabra: stack.one(i).palabra,
              status: "false"
            };
            this.word = obj;
          }
          if (i == ciclos) {
            duda.palabraDesconocida(cont, 1);
          }
        } //::END=>for
        for (let i in palabra) {
          stack.pop();
        }
        clearInterval(h); //rompe el ciclo
      } //::END=>if
    }, 100);

    return true;
  } //::END=>palabras

  static palabraDesconocida(ciclos, num) {
    if (ciclos > 0) {
      this.status = 100;
      this.cont = num;
      var r = Math.floor(Math.random() * 3 + 1);
      switch (r) {
        case 1:
          this.msg =
            "No entiendo, ¿que significa: " +
            this.word.json[num].palabra +
            " ?<br>¿Podrías definir " +
            this.word.json[num].palabra +
            "?";
          break;
        case 2:
          this.msg =
            "Espera, ¿que significa: " + this.word.json[num].palabra + " ?";
          break;
        case 3:
          this.msg =
            "Antes, ¿que significa: " + this.word.json[num].palabra + " ?";
          break;
      } //::END=>switch

      output.messageIA(this.msg, "code");
    } else {
      try {
        for (let i in duda.palabra) {
          stack.pop();
        }
      } catch (error) {}
      stack.count = 0;
      output.messageIA("ok -respuesta"); //respuesta
    }
    return true;
  }

  static significado(status, cadena) {
    this.word.json[this.cont].status = "true";
    this.cont++;
    output.messageIA("Entonces, " + cadena);
    output.messageIA("Entiendo, pero aun no tengo respuesta");
    try {
      for (let i in duda.palabra) {
        stack.pop();
      }
    } catch (error) {}
    try {
      if (this.word.json[this.cont].palabra) {
        duda.palabraDesconocida(1, this.cont);
      }
    } catch (error) {
      delete this.word;
      this.status = undefined;
    }
    stack.count = 0;
    return true;
  }
}
new duda();
