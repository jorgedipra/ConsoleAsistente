class preparar {
  constructor(original, data, estado) {
    this.original = original;
    this.data = data;
    this.estado = estado;
  }
  static Nlenguaje(original, data) {
    let limpia = preparar.limpia(original);
    let palabras = preparar.Npalabras(original);

    data.limpia = limpia;
    data.palabras = palabras;

    data = Memoria.buscar(data);

    return data;
  }

  static limpia(original) {
    original = preparar.normalizar(original); //quitan tildes
    original = original.split(" "); //se crea un array de cada palabra
    original = original.filter(e => e !== ""); //se elimina los espacios excesivos
    original = original.join(" "); // se une el array con solo un espacio
    original = original.replace(/[-"',.;*+¿?¡!^${}=()|[\]\\]/g, " "); //quitar simbolos
    original = original.trim();//elimina los espacios en blanco en ambos extremos del string.
    let limpia = original.toUpperCase(); //mayusculas;

    //quitar tildes
    function a(str) {}

    return limpia;
  }

  static Npalabras(original) {
    original = original.replace(/[-"',.;*+¿?¡!^${}=()|[\]\\]/g, " "); //se quitan los signos
    original = original.split(" "); //se crea un array de cada palabra
    original = original.filter(e => e !== ""); //se elimina los espacios excesivos

    let palabras = JSON.stringify(original);

    return palabras;
  } //::END=Npalabras

  static normalizar(str) {
    const from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
      to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuuNnCc",
      mapping = {};

    for (let i = 0, j = from.length; i < j; i++)
      mapping[from.charAt(i)] = to.charAt(i);

    let ret = [];
    for (let i = 0, j = str.length; i < j; i++) {
      let c = str.charAt(i);
      if (mapping.hasOwnProperty(str.charAt(i))) ret.push(mapping[c]);
      else ret.push(c);
    }
    return ret.join("");
  }
}
new preparar();
