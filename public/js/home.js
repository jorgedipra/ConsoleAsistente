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
      consola: ":: Asistente ::"
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
      //::=>comomando por voz
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
      //::START=>setTimeout[Microfono se alterna con enviar por teclado segun lo elija el usuario]
      setTimeout(() => {
        if (this.actividad == "" || this.actividad == null) {
          this.classMicro = "micro-in";
          this.classEnviar = "enviar-on";
        } else {
          this.classMicro = "micro-on";
          this.classEnviar = "enviar-in";
        }
      }, 100);
      //::END=>setTimeout
    },
    actualizarChat: function() { 
      User = "Us";
      let cadena;

      //::=>validación para que no entre en blanco
      if (localStorage.getItem("user")) {
        User = localStorage.getItem("user");
        User = User.substr(-20, 2).toUpperCase();
      }

      //::=>se asigana a "cadena" lo que escribio el User
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
      //::START=>Consola 
      /*
      consola("grupo", "data");
      consola("tabla", data);
      consola("end");
      */
      //::END=>Consola 
      
      if (duda.status === undefined) { 
        //::=>Palabras "Desconocidas" se guardan, se piede definición, si es mas de una palabra; 
        //    guarda en pila y espera a ser definida. 
        //    Y si no hay palabras desconocidad, envia "respuestas.opciones()"
        duda.palabra = data.palabras;
        duda.ciclos = data.palabras.length - 1;
        duda.palabras(duda.palabra, duda.ciclos);
        output.messageUser(data);
        app.actividad = null;
        duda.original=data.limpia;
      } else {

        stack.count = 0;//Contador de Stack se reinicia a 0 por no contener palabras "Desconocidas"
        switch (duda.status) {
          /**
           * 100:El User entra significado de palabra
           * 200:El User entra su nombre, el sistema lo guarda en un localStorage
           * default: muestra el mensaje y una respuesta "ok"
           */
          case 100:
            output.messageUser(data);
            consola(duda.status);
            duda.significado(100, data.limpia);
            break;
          case 200:
            respuestas.nombre(data);
            break;
          default:
            output.messageUser(data);
            output.messageIA("ok");
            break;
        }//::END=>switch
        
      }//::END=>if-Status

      stack.count = 0;//Contador de Stack se reinicia a 0
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
      include("home/notification");
      include("home/N.clasificar");
      include("home/N.memoria");
      include("home/N.duda");
      include("home/N.respuestas");
    }
  }
});