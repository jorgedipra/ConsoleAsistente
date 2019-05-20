const Memoria = (fragmento, tipo, cadena, data) => {
 let id = 0; 
 let Nrespuestas = 0;   
  switch (tipo) {
    case "palabra":
      axios
        .post("palabras", {
          palabra: fragmento
        })
        .then(function(response) {
          //console.log(response.data);//temp
        })
        .catch(function(error) {
          console.log(error);
        });
      return false;
      break;
    case "pregunta":
      axios
        .post("pregunta", {
          pregunta: fragmento,
          original: cadena.replace(/[¿?]/g, "")
        })
        .then(function(response) {
          var json = response.data;
          // console.log(json);//temp
          var r = Math.floor(Math.random() * parseInt(json["Nrespuestas"]) + 1);
          j = 0;
          estatico = true;
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
      return true;
      break;
    case "aprender": 
        if(localStorage.getItem("respuestaId")){
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
            var json = response.data;
            messageUser(data); //se envia lo que dijo el usuario al historial
            message(response.data['pregunta']);
            localStorage.setItem("respuestaId",response.data['id']);//id de pregunta
            localStorage.setItem("Nrespuestas",response.data['Nrespuestas']);//No de respuestas
        })
        .catch(function(error) {
          console.log(error);
        });
      return true;
      break;
    default:
      metodostatico(cadena, data);
      break;
  } //::switch

  var saludo = RegExp("(HOLA|ALO)");
  let eureka = saludo.test(fragmento);

  return eureka ? "Saludo" : "falso";
}; //::END=Memoria

const Nlenguaje = (input, data, estado) => {
  cadena = input;
  input = input.toUpperCase(); //mayuscula

  if (estado == "aprender"){
    Memoria(input, "aprender", cadena, data); //se envia la petición a la memoria de enviar las respuestas
    return false;
  }

  Npalabras(input); //separa las letras
  respuesta = NClasificaFrase(input, cadena, data); //clasificar la frase
}; //::END=Nlenguaje

const Npalabras = input => {
  input = input.replace(/[-"',.;*+¿?¡!^${}=()|[\]\\]/g, " "); //se quitan los signos
  input = input.split(" "); //se crea un array de cada palabra
  input = input.filter(e => e !== ""); //se elimina los espacios excesivos

  input.forEach(element => {
    Memoria(element, "palabra"); //enviar a la memoria
  });
  return input;
}; //::END=Npalabras

const NClasificaFrase = (input, cadena, data) => {
  input = normalize(input);
  input = input.split(" "); //se crea un array de cada palabra
  input = input.filter(e => e !== ""); //se elimina los espacios excesivos
  input = input.join(" "); // se une el array con solo un espacio
  var pregunta = RegExp(
    "(QUE|QUIEN|COMO|CUANDO|CUANTO|CUANTA|DONDE|POR QUE|DONDE)"
  );
  var numeros = RegExp("(1|2|3|4|5|6|7|8|9|0)");
  var signosp = RegExp("(POR|DIVIDIDO)");
  var signos = /[*+-/]/g;
  if (
    numeros.test(input) == true &&
    (input.search(signos) >= 0 || signosp.test(input))
  ) {
    Noperaciones(input, data);
    return false;
  }

  if (pregunta.test(input) == true || input.lastIndexOf("?") > 0) {
    //es pregunta
    respuesta = Memoria(input.replace(/[¿?]/g, ""), "pregunta", cadena, data);
  } else {
    //frase o palabras
    respuesta = Memoria(input, "otro", cadena, data);
  }
  return respuesta;
}; //::END=NClasificaFrase

const Noperaciones = (input, data) => {
  //falta  jerarquía de signo () *o/ +o-
  input = input.replace("POR", "*");
  input = input.replace("DIVIDIDO", "/");
  var signo = /[*+-/]/g;
  var regex = /(\d+)/g;
  var signos = input.match(signo);
  var numeros = input.match(regex);
  var i = 0;
  var num = 0;
  var sig = 0;
  resultado = 0;
  numeros.forEach(function(element) {
    if (i == 0) {
      num = parseInt(element);
      sig = signos[i];
    } else {
      if (sig == "+") resultado = num + parseInt(element);
      if (sig == "-") resultado = num - parseInt(element);
      if (sig == "*") resultado = num * parseInt(element);
      if (sig == "/") resultado = num / parseInt(element);

      num = resultado;
      sig = signos[i];
    }
    i++;
  });

  messageUser(data); //se envia lo que dijo el usuario al historial
  message(resultado); //se envia el mensaje respuesta al historial
};
const NtransPalabras = () => {
  know = {
    HOLAA: "HOLA",
    OLA: "HOLA",
    OLA: "HOLA"
  };
}; //::END=NtransPalabras

//quitar tildes
var normalize = (function() {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
    to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuuNnCc",
    mapping = {};

  for (var i = 0, j = from.length; i < j; i++)
    mapping[from.charAt(i)] = to.charAt(i);

  return function(str) {
    var ret = [];
    for (var i = 0, j = str.length; i < j; i++) {
      var c = str.charAt(i);
      if (mapping.hasOwnProperty(str.charAt(i))) ret.push(mapping[c]);
      else ret.push(c);
    }
    return ret.join("");
  };
})();
