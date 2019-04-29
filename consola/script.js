const app = new Vue({
    el: '#app',
    a: false,
    data:{ 
      mensaje: [],
      actividad: '',
      actividades: [],
      consola: [],
      messages: []
    },
    mounted(){
        dataconsolaInicio ={
            consola: "- Console Asisitent"
        }
        this.mensaje.push(dataconsolaInicio);
    },
    updated(){             
        var messageDisplay = app.$refs.messageDisplay;
        messageDisplay.scrollTop = messageDisplay.scrollHeight;
    },
    methods: {
      actualizarLista: function() {
        User="User"
        if(localStorage.getItem("user"))
            User= localStorage.getItem("user");
        
        data = {
            user: User, 
            message: this.actividad,
            rol: "User"
        };
        
        switch (this.actividad) {
            case "hola":
                hola();
                break;
            case "adios":
                adios();
                break;
            default:
                break;
        }
        setTimeout(() => {
            this.actividades.push(data);
        }, 500);
        this.actividad = null;
      }
    }
})


const hola =()=>{
    if(localStorage.getItem("user")){
        console.log("ok");
        
        data2 = {
            user:"Alis", 
            message: "Dime "+localStorage.getItem("user")+", en que te puedo ayudar?",
            rol: "Alis"
        };
        setTimeout(() => {
            app.actividades.push(data2);
        }, 1000);
        return false;
    }
    dataconsola ={
        consola: "XD"
    }
    app.mensaje.push(dataconsola);
    newuser = window.prompt('hola, como te llamas?')
    localStorage.setItem("user", newuser);
    data2 = {
        user:"Alis", 
        message: "hola,"+newuser,
        rol: "Alis"
    };
    setTimeout(() => {
        app.actividades.push(data2);
        data2 = {
            user:"Alis", 
            message: "En que te puedo ayudar",
            rol: "Alis"
        };
        setTimeout(() => {
            app.actividades.push(data2);
        }, 500);
    }, 1000);
    
}
const adios =()=>{

    data2 = {
        user    :"Alis",
        message : "Adios,"+localStorage.getItem("user"),
        rol     : "Alis"
    };
    localStorage.removeItem("user");
    localStorage.clear();
    setTimeout(() => {
        app.actividades.push(data2);
    }, 1000);
    
}