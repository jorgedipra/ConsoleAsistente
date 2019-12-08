class Memoria {
  /**
   * constructor
   * @param {la frase tratada} fragmento
   * @param {destino del fragmento} tipo
   * @param {la frase original} cadena
   * @param {datos del publicante} data
   */

  constructor(fragmento, tipo, cadena, data) {
    this.fragmento = fragmento;
    this.tipo = tipo;
    this.cadena = cadena;
    this.data = data;
  }

  // Getter
  get remember() {
    // console.log("Tipo:["+this.tipo+"]");
    
    switch (this.tipo) {
      case "palabra":
        return this.palabra();
        break;
      case "pregunta":
        return this.pregunta();
        break;
      case "aprender":
        return this.aprender();
        break;
      default:
        metodostatico(this.cadena, this.data);
        break;
    }
  }
  palabra() {//guarda las palabras  nuevas
    axios
      .post("palabras", {
        palabra: this.fragmento
      })
      .then(function(response) {
          // console.log(response.data);//temp
      })
      .catch(function(error) {
        console.log(error);
      });
    return this.fragmento;
  }

  pregunta() {
    // console.log("pregunta>> "+this.fragmento);
    
    let cadena = this.cadena;
    let data = this.data;
    axios
      .post("pregunta", {
        pregunta: this.fragmento,
        original: cadena.replace(/[¿?]/g, "")
      })
      .then(function(response) {
        var json = response.data;
        // console.log("respuesta:"+json);//temp
        var r = Math.floor(Math.random() * parseInt(json["Nrespuestas"]) + 1);
        let j = 0;
        let estatico = true;
        for (var i in json) {
          if (r == j) {
            // se responde con una respuesta de la BD
            estatico = false;
            messageUser(data); //se envia lo que dijo el usuario al historial
            message(json[i]); //se envia el mensaje respuesta al historial
          }
          j++;
        }
        if (estatico == true) {
          metodostatico(cadena, data); //se llama las respuestas estaticas
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  }

  aprender() {
    let fragmento = this.fragmento;
    let data = this.data;
    let id = 0;
    let Nrespuestas = 0;
    //solo una entrada
    if (localStorage.getItem("respuestaId")) {
      id = localStorage.getItem("respuestaId");
      Nrespuestas = localStorage.getItem("Nrespuestas");
    }
    axios
      .post("respuesta", {
        id: id,
        pregunta: fragmento,
        Nrespuestas: Nrespuestas
      })
      .then(function(response) {
        messageUser(data); //se envia lo que dijo el usuario al historial
        message(response.data["pregunta"]);
        localStorage.setItem("respuestaId", response.data["id"]); //id de pregunta
        localStorage.setItem("Nrespuestas", response.data["Nrespuestas"]); //No de respuestas
      })
      .catch(function(error) {
        console.log(error);
      });
  }
}
// data = {
//     user: "Us",
//     message: "cadena",
//     rol: "User"
//   };
// let NMemoria = new Memoria(
//     "COMO TE LLAMAS",
//     "aprenders",
//     "Como te llamas",
//     data
//   );
//   NMemoria.remember

// return eureka ? "Saludo" : "falso";

const metodostatico = (cadena, data) => {
  if (app.actividad == "" || app.actividad == null) {
    cadena = document.getElementById("actividad").value.toUpperCase();
  } else {
    cadena = app.actividad.toUpperCase();
  }
  var saludar = RegExp("(QUE TAL|CÓMO VA|COMO VA|CÓMO VAS|COMO VAS)");

  var tener = RegExp("(TIENE|TIENES|TENGO|TENÉS|TENES|CUANDO|CUAL|CUANTOS)");
  var edad = RegExp("(AÑOS|EDAD|NACISTE)");

  know = {
    HOLA: "hola",
    ADIÓS: "exit",
    ADIOS: "exit",
    "QUE HACES": "Aprender",
    SALIR: "adios!"
  };
  if (cadena in know) {
    switch (cadena) {
      case "HOLA":
        hola();
        break;
      case "ADIÓS":
        adios();
        break;
      case "ADIOS":
        adios();
        break;
      default:
        message(know[cadena]);
        break;
    }
  } else if (saludar.test(cadena)) {
    message("Bien, aprendiendo");
  } else if (tener.test(cadena) == true && edad.test(cadena) == true) {
    var r = Math.floor(Math.random() * 3 + 1);
    switch (r) {
      case 1:
        mensaje = "Aun no tengo años";
        break;
      case 2:
        mensaje = "No se contar, para saber mi edad";
        break;
      case 3:
        mensaje = "¿por que quieres saber mi edad?";
        break;
    }
    message(mensaje);
  } else {
    message("No te entiendo ó estas Jugando?");
  }

  messageUser(data);

  app.actividad = null;
};

const hola = () => {
  if (localStorage.getItem("user")) {
    setTimeout(() => {
      message(
        "Dime " + localStorage.getItem("user") + ", en que te puedo ayudar?"
      );
    }, 1000);
    return false;
  }
  dataconsola = {
    consola: "XD"
  };
  app.mensaje.push(dataconsola);
  msg = "hola, como te llamas?";
  hablar(msg);
  newuser = window.prompt(msg);
  localStorage.setItem("user", newuser);
  setTimeout(() => {
    message("hola," + newuser);
    setTimeout(() => {
      message("En que te puedo ayudar");
    }, 500);
  }, 1000);
};

const adios = () => {
  msg = "Adiós," + localStorage.getItem("user");
  localStorage.removeItem("user");
  localStorage.clear();
  setTimeout(() => {
    message(msg);
    setTimeout(() => {
      NoEscuchar();
      setTimeout(() => {
        comandosOff();
      }, 1000);
    }, 1000);
  }, 1000);
};



//////////////////////////////////////////////////
      // const aprender = RegExp(
      //   "(-aprender|-APRENDER|que te han preguntado|que te preguntaron)"
      // );
      // const aprenderturno1 = RegExp(
      //   "(que te han preguntado|que te preguntaron)"
      // );
      // const aprenderSalir = RegExp("(-salir|-terminar|-SALIR|-TERMINAR)");

      // console.log(data);
      // console.log(">>"+aprenderSalir.test(cadena));

      // if (aprenderSalir.test(cadena)) {
      //   messageUser(data); //se envia lo que dijo el usuario al historial
      //   var r = Math.floor(Math.random() * 3 + 1);
      //   switch (r) {
      //     case 1:
      //       mensaje = "Gracias por enseñarme";
      //       localStorage.setItem("aprender", "normal");
      //       localStorage.removeItem("respuestaId");
      //       break;
      //     case 2:
      //       mensaje = "Hoy estuvo aburrido, espero aprender mas mañana";
      //       localStorage.setItem("aprender", "normal");
      //       localStorage.removeItem("respuestaId");
      //       break;
      //     case 3:
      //       mensaje = "Quiero saber más, por favor";
      //       break;
      //   }
      //   message(mensaje);
      // } else if (
      // aprender.test(cadena) == true ||
      //   localStorage.getItem("aprender") == "aprender"
      // ) {
      //   localStorage.setItem("aprender", "aprender");
      //   if (aprenderturno1.test(cadena)) {
      //     localStorage.setItem("aprender", "normal");
      //     localStorage.removeItem("respuestaId");
      //   }
      //   Nlenguaje(cadena, data, "aprender");
      // } else {
      // Nlenguaje(cadena, data);
      // }