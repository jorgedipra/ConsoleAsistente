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
  palabra() {
    axios
      .post("palabras", {
        palabra: this.fragmento
      })
      .then(function(response) {
        //   console.log(response.data);//temp
      })
      .catch(function(error) {
        console.log(error);
      });
    return this.fragmento;
  }

  pregunta() {
    let cadena = this.cadena;
    let data = this.data;
    axios
      .post("pregunta", {
        pregunta: this.fragmento,
        original: cadena.replace(/[¿?]/g, "")
      })
      .then(function(response) {
        var json = response.data;
        // console.log(json);//temp
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