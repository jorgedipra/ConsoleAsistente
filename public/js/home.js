const app = new Vue({
  el: "#app",
  a: false,
  data: {
    mensaje: [],
    actividad: "",
    actividades: [],
    consola: [],
    messages: [],
    estado: "Estoy escuchando Comandos",
    classMicro: "micro-in",
    classMicroIco: "fas fa-microphone",
    classEnviar: "enviar-on",
    classComanON: "ComanOFF",
    classComanOFF: "ComanON",
    hora: "",
    fecha: ""
  },
  mounted() {
    dataconsolaInicio = {
      consola: ":: Console Asisitent ::"
    };
    this.mensaje.push(dataconsolaInicio);
    this.montajeInicial();
    this.extra();
  },
  updated() {
    var messageDisplay = app.$refs.messageDisplay;
    messageDisplay.scrollTop = messageDisplay.scrollHeight;
  },
  methods: {
    ComanVoz: function(estado) {
      //comomando por voz
      if (estado == 1) {
        this.classComanON = "ComanON";
        this.classComanOFF = "ComanOFF";
      } else {
        this.classComanON = "ComanOFF";
        this.classComanOFF = "ComanON";
      }
    },
    micro: function() {
      Escuchar();
    },
    keymonitor: function() {
      //microfono se alterna con enviar por teclado segun lo elija el usuario
      setTimeout(() => {
        if (this.actividad == "" || this.actividad == null) {
          this.classMicro = "micro-in";
          this.classEnviar = "enviar-on";
        } else {
          this.classMicro = "micro-on";
          this.classEnviar = "enviar-in";
        }
      }, 100);
    },
    actualizarChat: function() {
      User = "Us";
      let cadena;

      //validación para que no entre en blanco
      if (localStorage.getItem("user")) {
        User = localStorage.getItem("user");
        User = User.substr(-20, 2).toUpperCase();
      }

      cadena = this.actividad;

      if (this.actividad == "" || this.actividad == null) {
        cadena = $("#actividad").value;
        if (cadena == "" || cadena == null) return false;
      }

      data = {
        user: User,
        message: cadena,
        rol: "User"
      };

      data = preparar.Nlenguaje(cadena, data); // depura y separa la frase && guarda palabras desconoccidas
      respuestas.cadena = data.limpia;
      consola('grupo','data')
      consola('tabla',data)
      consola('end')


      if (duda.status === undefined) {
        duda.palabra = data.palabras;
        duda.ciclos = data.palabras.length - 1;
        duda.palabras(duda.palabra, duda.ciclos);
        output.messageUser(data);
        app.actividad = null;
        stack.count = 0;
      } else {
        stack.count = 0;
        switch (duda.status) {
          case 100:
            output.messageUser(data);
            duda.significado(100, data.limpia);
            break;
          case 200:
            respuestas.nombre(data);
            break;
          default:
            output.messageUser(data);
            output.messageIA("ok");
            break;
        }
      }
      stack.count = 0;
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
    },
    montajeInicial: function() {
      msg = "voz por comandos No soportada";
      if (annyang) msg = "Comandos por voz soportada";
      this.estado = msg;
    },
    extra: function() {
      include("home/time");
      include("home/tab");
      include("home/dataStack");
      include("home/N.clasificar");
      include("home/N.memoria");
      include("home/N.duda");
      include("home/N.respuestas");
    }
  }
});

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

function prueba_notificacion() {
  if (Notification) {
    if (Notification.permission !== "granted") {
      Notification.requestPermission();
    }
    var title = "Xitrus";
    var extra = {
      icon: "http://xitrus.es/imgs/logo_claro.png",
      body: "Notificación de prueba en Xitrus"
    };
    var noti = new Notification(title, extra);
    noti.onclick = {
      // Al hacer click
    };
    noti.onclose = {
      // Al cerrar
    };
    setTimeout(function() {
      noti.close();
    }, 10000);
  }
}
