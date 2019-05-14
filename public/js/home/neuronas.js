const Memoria = (fragmento, tipo, cadena, data) => {
    if (tipo == "palabra") {
        axios.post('palabras', {
                palabra: fragmento
            })
            .then(function (response) {
                //console.log(response.data);//temp
            })
            .catch(function (error) {
                console.log(error);
            });
        return false
    } else if (tipo == "pregunta") {
        axios.post('pregunta', {
                pregunta: fragmento
            })
            .then(function (response) {
               var json = response.data;
                // console.log(json);//temp
                var r = Math.floor((Math.random() * parseInt(json['Nrespuestas'])) + 1);
                j=0;estatico=true;
                for (var i in json) {
                    if(r==j){// se responde con una respuesta de la BD
                        estatico=false;
                        messageUser(data);//se envia lo que dijo el usuario al historial
                        message(json[i]);//se envia el mensaje respuesta al historial
                    } 
                    j++;
                }
                if(estatico==true){
                    metodostatico(cadena,data); //se llama las respuestas estaticas
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        return true;
    }else{
        metodostatico(cadena,data); 
    }

    var saludo = RegExp("(HOLA|ALO)");
    let eureka = saludo.test(fragmento);

    return eureka ? 'Saludo' : 'falso';
} //::END=Memoria 

const Nlenguaje = (input,data) => {
    cadena=input;
    input = input.toUpperCase(); //mayuscula
    Npalabras(input); //separa las letras 
    respuesta = NClasificaFrase(input,cadena,data); //clasificar la frase

} //::END=Nlenguaje

const Npalabras = (input) => {
    input = input.replace(/[-"',.;*+¿?¡!^${}=()|[\]\\]/g, ' '); //se quitan los signos
    input = input.split(' '); //se crea un array de cada palabra 
    input = input.filter(e => e !== ""); //se elimina los espacios excesivos 
    
    input.forEach(element => {
        Memoria(element, "palabra"); //enviar a la memoria
    });
    return input
} //::END=Npalabras

const NClasificaFrase = (input,cadena,data) => {
    input = normalize(input);
    input = input.split(' '); //se crea un array de cada palabra 
    input = input.filter(e => e !== ""); //se elimina los espacios excesivos
    input = input.join(' ');// se une el array con solo un espacio
    var pregunta = RegExp("(QUE|QUIEN|COMO|CUANDO|CUANTO|CUANTA|DONDE)");
    
    if (pregunta.test(input) == true || input.lastIndexOf("?") > 0){ //es pregunta
        respuesta = Memoria(input.replace(/[¿?]/g, ''), "pregunta",cadena,data);
    }else{
        respuesta = Memoria(input, "otro",cadena,data);
    }
    return respuesta;
} //::END=NClasificaFrase
const NtransPalabras = () => {
    know = {
        "HOLAA": "HOLA",
        "OLA": "HOLA",
        "OLA": "HOLA",
    }
} //::END=NtransPalabras


//quitar tildes
var normalize = (function () {
    var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
        to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuuNnCc",
        mapping = {};

    for (var i = 0, j = from.length; i < j; i++)
        mapping[from.charAt(i)] = to.charAt(i);

    return function (str) {
        var ret = [];
        for (var i = 0, j = str.length; i < j; i++) {
            var c = str.charAt(i);
            if (mapping.hasOwnProperty(str.charAt(i)))
                ret.push(mapping[c]);
            else
                ret.push(c);
        }
        return ret.join('');
    }

})();