class duda {
  constructor() {
    let palabra = this.palabra;
    let ciclos = this.ciclos;
    this.word = {};
    this.status;
    this.msg;
    this.cont = 0;
    this.original;
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
    console.log('=== DEBUG palabraDesconocida ===');
    console.log('ciclos:', ciclos);
    console.log('num:', num);
    console.log('duda.original:', duda.original);

    // Si hay palabras desconocidas, consultar directamente al LLM
    // sin pedir definición de cada palabra
    if (ciclos > 0 && duda.original) {
      console.log('Consultando LLM directamente...');

      fetch('/api/llm/chat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mensaje: duda.original, historial: [] })
      })
      .then(res => res.json())
      .then(llmData => {
        console.log('Respuesta LLM:', llmData);
        if (llmData.respuesta) {
          // Limpiar HTML de la respuesta
          const limpia = llmData.respuesta
            .replace(/<br\s*\/?>/gi, '\n')
            .replace(/<[^>]+>/g, '')
            .trim();
          output.messageIA(limpia);
        } else {
          output.messageIA("Lo siento, no pude obtener una respuesta");
        }
      })
      .catch(err => {
        console.error('Error consultando LLM:', err);
        output.messageIA("Error al conectar con el asistente");
      });

      // Limpiar estado y salir
      this.status = undefined;
      stack.count = 0;
      return;
    }

    // Si no hay palabras desconocidas, código original (no debería llegar aquí)
    if (ciclos > 0) {
      this.status = 100;
      this.cont = num;
      var r = Math.floor(Math.random() * 3 + 1);
      this.word.json[num].palabra = preparar.capital(
        this.word.json[num].palabra
      );
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

      console.log('Mostrando mensaje de palabra desconocida');
      output.messageIA(this.msg, "code");
    } else {
      try {
        for (let i in duda.palabra) {
          stack.pop();
        }
      } catch (error) {}
      stack.count = 0;
      respuestas.count=0;
      respuestas.opciones(); //respuesta
    }
    return true;
  }

  static significado(status, cadena) {
    this.word.json[this.cont].status = "true";
    this.cont++;
    cadena = preparar.capital(cadena);
    output.messageIA("Entonces; " + cadena);
    let respuesta = "Entiendo, pero aun no un tengo respuesta";
    respuestas.respuestasAlmacenada(duda.original, respuesta);

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
