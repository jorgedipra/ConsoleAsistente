class Memoria {
  constructor(fragmento, tipo, cadena, data) {
    this.fragmento = fragmento;
    this.tipo = tipo;
    this.cadena = cadena;
    this.data = data;
  }
  static buscar(data) {
    data.palabras = Memoria.palabras(data.palabras);
    
    return data;
  }
  static palabras(data) {
    let dataFull = [];
    data = JSON.parse(data);
    
    for (let i in data) {
      dataFull[i] = Memoria.buscarPalabra(data[i]);
    }

    return dataFull;
  }

  static buscarPalabra(data) {
    data = preparar.limpia(data);
    axios
    .post("palabras", {
      palabra: data
    })
    .then(function(response) {
      if(response.status==200){ 
        let cadena = response.data;
        let arregloDeSubCadenas;
        let status;
        try {
          if(cadena.indexOf("<") > 0){
            arregloDeSubCadenas = cadena.split("<");
            status = arregloDeSubCadenas[0];
          }else{
            status = cadena;
          }
        } catch (e) {
          status = cadena;
        } 

        try {
          status=JSON.parse(status);
        }catch (e) {}        
         
        stack.push(status.status);
      }else{
        console.error("Error :["+response.status+"]");
      }      
    })
    .catch(function(error) {
      console.log("Busca palabra error [ "+error+" ]");  
    });

    return data;
  }//::END=>buscarPalabra
  
}
new Memoria();
