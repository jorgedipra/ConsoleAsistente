class respuestas {
  constructor() {
    this.cadena;
    this.user;
    this.count = 0;
    this.count2 = 0;
    this.status;
  }
  static opciones() {
    try {
      //carga de comenado por primera vez
      if (!comandos.on()) include("home/N.comandos");
    } catch (error) {
      include("home/N.comandos");
    }

    let promesa = new Promise((resolver, reject) => {
      let NComn = setInterval(() => {
        try {
          comandos.on();
          resolver(200);
          clearInterval(NComn);
        } catch (error) {
          reject("error");
        }
      }, 100);
    });

    promesa
      .then(response => {
        if (this.cadena in comandos.command) {
          respuestas.comandos(this.cadena);
        } else {
          respuestas.respuestasAlmacenada(this.cadena);
        }
        return true;
      })
      .catch(error => {
        consola("error", error);
        respuestas.count++;
        if (respuestas.count == 20) {
          return false;
        }
        respuestas.opciones();
      });
  } //END=>Opciones

  static comandos(cadena) {
    try {
      if (!funcionesComandos.on()) include("home/N.funcionesComandos");
    } catch (error) {
      include("home/N.funcionesComandos");
    }

    let promesa = new Promise((resolver, reject) => {
      let NComn = setInterval(() => {
        try {
          funcionesComandos.on();
          resolver(200);
          clearInterval(NComn);
        } catch (error) {
          reject("error");
        }
      }, 100);
    });

    promesa
      .then(response => {
        switch (cadena) {
          case "HOLA":
            const span = document.createElement("span");
            span.id = "fn_hola";
            span.setAttribute(
              "onclick",
              "funcionesComandos." + comandos.command[cadena] + "()"
            );
            $("#temp").appendChild(span);
            $("#fn_" + comandos.command[cadena]).click();
            break;
          case "VER COMANDOS":
            funcionesComandos.vercomandos();
            break;
          default:
            console.log("comando:" + cadena);
            break;
        }

        return true;
      })
      .catch(error => {
        consola("error", error);
        respuestas.count2++;
        if (respuestas.count2 == 20) {
          return false;
        }
        respuestas.opciones();
      });

    return true;
  }

  static respuestasAlmacenada(cadena, respuesta) {
    if (respuesta) {
      cadena = duda.original;
    }
    let promesa = new Promise((resolver, reject) => {
      respuestas.pregunta(cadena, data.message);
      let NRes = setInterval(() => {
        try {
          if (this.status === undefined) {
          } else {
            if (this.status == "true") {
              resolver(200);
            } else {
              resolver(100);
            }
            clearInterval(NRes);
          }
        } catch (error) {
          reject("error");
        }
      }, 100);
    });
    promesa
      .then(response => {
        console.log('=== DEBUG respuestasAlmacenada ===');
        console.log('response:', response);
        console.log('duda.original:', duda.original);
        console.log('data.message:', data.message);

        if (response == 100) {
          if (respuesta) {
            output.messageIA("" + respuesta);
          } else {
            // Consultar al LLM en lugar de mostrar error
            const mensajeOriginal = duda.original || data.message;
            console.log('Consultando LLM con:', mensajeOriginal);

            fetch('/api/llm/chat', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ mensaje: mensajeOriginal, historial: [] })
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
              consola("error", "Error consultando LLM: " + err);
              output.messageIA("Error al conectar con el asistente");
            });
          }
        }
        consola("log", response);
      })
      .catch(error => {
        consola("error", error);
      });
  } //::END=>respuestasAlmacenada

  static pregunta(cadena, original) {
    let arregloDeSubCadenas;
    axios
      .post("pregunta", {
        pregunta: cadena,
        original: original.replace(/[¿?]/g, "")
      })
      .then(function(response) {
        var json = response.data;

        try {
          if (json.indexOf("<script") > 0) {
            arregloDeSubCadenas = json.split("<script");
            json = arregloDeSubCadenas[0];
          }
        } catch (e) {}
        try {
          json = JSON.parse(json);
        } catch (e) {}

        let status = "false";
        let nRespuestas = parseInt(json["Nrespuestas"]) || 0;

        if (nRespuestas > 0) {
          var r = Math.floor(Math.random() * nRespuestas + 1);
          let j = 0;
          for (var i in json) {
            if (r == j) {
              // se responde con una respuesta de la BD
              status = "true";
              output.messageIA(json[i]); //se envia el mensaje respuesta al historial
            }
            j++;
          }
        }
        // Si Nrespuestas es 0 o no hay respuestas, status permanece "false"
        respuestas.status = status;
      })
      .catch(function(error) {
        consola("error", error);
        // En caso de error, también establecer status para que el flujo continúe
        respuestas.status = "false";
      });

    // Timeout de seguridad: si no se resuelve en 5 segundos, asumir que no hay respuesta
    setTimeout(() => {
      if (respuestas.status === undefined || respuestas.status === null) {
        respuestas.status = "false";
      }
    }, 5000);
  } //::END=>pregunta

  ////////////////////////////////////

  static nombre(data) {
    output.messageUser(data);
    localStorage.setItem("user", data.message);
    this.user = localStorage.getItem("user");
    this.user = preparar.capital(this.user);
    output.messageIA("hola " + this.user);
    output.messageIA("¿en que te puedo ayudar?");
    duda.status = undefined;
    return true;
  }
}
new respuestas();
