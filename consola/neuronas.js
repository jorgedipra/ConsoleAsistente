const Memoria = (fragmento)=>{
    var saludo = RegExp("(HOLA|ALO)");
    let eureka = saludo.test(fragmento); 
    
 return eureka ? 'Saludo' : 'falso';
}

const Nlenguaje = (input)=>{ 
   input = input.toUpperCase();
            Npalabras(input);
   Nmemoria= Memoria(Npalabras(input));

    return "mesaje >>"+input+">>"+Nmemoria;
}

const Npalabras =(input)=>{//Se separa y se elimina los espacios excesivos 
    input = input.split(' ') 
    input = input.filter( e => e !== "" );
console.log(input);

    return input
}

const NtransPalabras =()=>{
    know = {
        "HOLAA"       : "HOLA",
        "OLA"          : "HOLA",
        "OLA"          : "HOLA",
    }
}
