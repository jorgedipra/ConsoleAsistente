class duda {
  constructor() {
    let palabra = this.palabra;
    let ciclos = this.ciclos;
    this.word = {};
    this.status;
  }

  static palabras(palabra, ciclos) {
    let i = 0;
    let cont = 0;
    var text = '{ "json" : [{ "id":"" , "palabra":"" , "status":"true" } ]}';
    var obj = JSON.parse(text);

    var h = setInterval(() => {
      i++;
      if (i == 20) {
        clearInterval(h);
      }
      if(stack.count==palabra.length){
        for (let i in palabra) {
          if (stack.one(i).status != "true") {
            cont++;
            this.word = obj;
            this.word.json[cont] = { id: cont, palabra: stack.one(i).palabra, status: 'false' };
            this.word = obj;
          }
          if(i==ciclos){
            duda.palabraDesconocida(cont);
          }
        } //::END=>for
         for (let i in palabra) {
          stack.pop();
        }
        clearInterval(h); //rompe el ciclo
      }//::END=>if
    }, 100);
    
    return true;
  } //::END=>palabras

  static palabraDesconocida(ciclos) {
    if(ciclos>0){      
      this.status = 100;
      output.messageIA("¿No entiendo, que significa:<br>"+this.word.json[1].palabra+' ?','code');
    }else{
      output.messageIA("ok -respuesta");//respuesta
    }
  }

  static significado(significado, cont) {

    if (significado != "") {
      duda.palabraDesconocida("duda");
      localStorage.setItem("status", "200");
    }
  }
}
new duda();
