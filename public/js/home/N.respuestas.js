class respuestas {
  constructor() {
    this.cadena;
    this.user;
    this.count = 0;
  }
  static opciones() {
    try {//carga de comenado por primera vez
      if (!comandos.on()) include("home/N.comandos");
    } catch (error) {
      include("home/N.comandos");
    }

    let promesa = new Promise((resolver, reject) => {
      let NComn = setInterval(() => {
        try {
          let carga = comandos.on();
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

  static respuestasAlmacenada(cadena, respuesta) {
    respuestas.pregunta(cadena,data.message);
    // if (respuesta) {
    //   output.messageIA("ok " + respuesta);
    // } else {
    //   output.messageIA("ok -respuesta " + cadena);
    // }
  } //::END=>respuestasAlmacenada

  static pregunta(cadena,original) {
    let arregloDeSubCadenas;
    axios
      .post("pregunta", {
        pregunta: cadena,
        original: original.replace(/[¿?]/g, "")
      })
      .then(function(response) {
        var json = response.data;

         try {
          if(json.indexOf("<script") > 0){
            arregloDeSubCadenas = json.split("<script");
            json = arregloDeSubCadenas[0];
          }
        } catch (e) {} 
        try {
          json=JSON.parse(json);
        }catch (e) {}

        var r = Math.floor(Math.random() * parseInt(json["Nrespuestas"]) + 1);
        let j = 0;
        let estatico = true;
        for (var i in json) {
          if (r == j) {
            // se responde con una respuesta de la BD
            estatico = false;
            output.messageIA(json[i]);//se envia el mensaje respuesta al historial
          }
          j++;
        }
        if (estatico == true) {
          console.log('statico');
          //metodostatico(cadena, data); //se llama las respuestas estaticas
        }
        return true;
      })
      .catch(function(error) {
        console.log(error);
      });
    
  }

  ////////////////////////////////////

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
