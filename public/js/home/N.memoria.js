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
      dataFull[i] = Memoria.buscarPalabra(data[i], i);
    }

    return dataFull;
  }
  static buscarPalabra(data, i) {
    axios
    .post("palabras", {
      palabra: data
    })
    .then(function(response) {
        console.log(response.data);//temp
        
    })
    .catch(function(error) {
      console.log("Busca palabra error [ "+error+" ]");
    });


    let dataFull = {
      id: i,
      palabra: data,
      tipo: "palabra"
    };

    return dataFull;
  }
}
new Memoria();
