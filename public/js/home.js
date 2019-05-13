const app = new Vue({
    el: '#app',
    a: false,
    data: {
        mensaje: [],
        actividad: '',
        actividades: [],
        consola: [],
        messages: [],
        estado: "Estoy escuchando Comandos"
    },
    mounted() {
        dataconsolaInicio = {
            consola: "- Console Asisitent"
        }
        this.mensaje.push(dataconsolaInicio);
        this.montajeInicial();
    },
    updated() {
        var messageDisplay = app.$refs.messageDisplay;
        messageDisplay.scrollTop = messageDisplay.scrollHeight;
    },
    methods: {
        actualizarChat: function () {
            User = "Us"
            let cadena;
            //validación par auq no entre en blanco
            if (localStorage.getItem("user"))
                User = localStorage.getItem("user");
            cadena = this.actividad
            if(this.actividad=="" || this.actividad==null){
                cadena = document.getElementById("actividad").value;
                if(cadena=="" || cadena==null)
                 return false;
            }
            data = {
                user: User,
                message: cadena,
                rol: "User"
            };

            Nlenguaje(cadena,data);
        },
        montajeInicial: function(){
            msg="voz por comandos No soportada";
            if (annyang) 
                msg="Comandos por voz soportada";         
            this.estado=msg;
        }
    }
})

const metodostatico =(cadena,data)=>{
    if(app.actividad=="" || app.actividad==null){
        cadena = document.getElementById("actividad").value.toUpperCase();
   }else{
        cadena = app.actividad.toUpperCase();
   }
   var saludar = RegExp("(QUE TAL|CÓMO VA|COMO VA|CÓMO VAS|COMO VAS)");

   var tener = RegExp("(TIENE|TIENES|TENGO|TENÉS|TENES|CUANDO|CUAL)");
   var edad = RegExp("(AÑOS|EDAD|NACISTE)");
   
   know = {
       "HOLA"       : "hola",
       "ADIÓS"      : "exit",
       "ADIOS"      : "exit",
       "QUE HACES"  : "Aprender",
       "SALIR"      : "adios!"
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
   } else if(saludar.test(cadena)){
       message("Bien, aprendiendo");
   }else if(tener.test(cadena)==true && edad.test(cadena)==true){
       var r = Math.floor((Math.random() * 3) + 1);
       switch (r) {
           case 1:
               mensaje = "Aun no tengo años";
           break
           case 2:
               mensaje = "No se contar, para saber mi edad";
           break
           case 3:
               mensaje = "¿por que quieres saber mi edad?";
           break
       }
       message(mensaje);                         
   }else {
       message("No te entiendo ó estas Jugando?");
   }
   setTimeout(() => {
       app.actividades.push(data);
   }, 500);
   app.actividad = null;
}
const hola = () => {
    if (localStorage.getItem("user")) {
        setTimeout(() => {
            message("Dime " + localStorage.getItem("user") + ", en que te puedo ayudar?")
        }, 1000);
        return false;
    }
    dataconsola = {
        consola: "XD"
    }
    app.mensaje.push(dataconsola);
    msg="hola, como te llamas?";
    hablar(msg);
    newuser = window.prompt(msg)
    localStorage.setItem("user", newuser);
    setTimeout(() => {
        message("hola," + newuser)
        setTimeout(() => {
            message("En que te puedo ayudar")
        }, 500);
    }, 1000);

}
const adios = () => {
    msg="Adiós," + localStorage.getItem("user");
    localStorage.removeItem("user");
    localStorage.clear();
    setTimeout(() => {
        message(msg);
        setTimeout(() => {
            NoEscuchar()
            setTimeout(() => {
                comandosOff()
            }, 1000);
        }, 1000);
    }, 1000);

}
