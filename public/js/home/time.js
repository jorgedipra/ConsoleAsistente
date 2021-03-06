class Time {
  constructor() {
    Time.view();
  }
  static view(){
    let data = '';
    let hora = Time.hora();
    let fecha = Time.fechaDescriptiva_min();
    setInterval(function() {
      hora = Time.hora();
      data = hora+"<br>"+fecha;
      document.getElementById("hora").innerHTML = data;
    }, 500);
  }

  static hora() {
    let today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();
    let part = h > 12 ? 'pm' : 'am';
    m = checkTime(m);
    s = checkTime(s);
    h = checkAMPM(h);
    var horaDate = h+":"+m+":"+s+" "+part;
    return horaDate;
    function checkTime(i) {
      if (i < 10) {
        i = "0" + i;
      }
      return i;
    }
    function checkAMPM(hour){
      hour = hour > 12 ? hour - 12 : hour;
      hour = (hour+'').length == 1 ? `0${hour}` : hour;
      return hour;
    }
  }
  static horaSimple(){
    let today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    let part = h > 12 ? 'pm' : 'am';
    m = checkTime(m);
    h = checkAMPM(h);
    var horaDate = h+":"+m+" "+part;
    return horaDate;
    function checkTime(i) {
      if (i < 10) {
        i = "0" + i;
      }
      return i;
    }
    function checkAMPM(hour){
      hour = hour > 12 ? hour - 12 : hour;
      hour = (hour+'').length == 1 ? `0${hour}` : hour;
      return hour;
    }
  }

  static fecha() {
    var date = new Date();
    var d = date.getDate();
    var day = d < 10 ? "0" + d : d;
    var m = date.getMonth() + 1;
    var month = m < 10 ? "0" + m : m;
    var yy = date.getYear();
    var year = yy < 1000 ? yy + 1900 : yy;
    var resultado = day + "/" + month + "/" + year;
    // console.log(resultado);
    return resultado;
  }
  static diaSemana() {
    var d = new Date();
    var dia = new Array(7);
    dia[0] = "Domingo";
    dia[1] = "Lunes";
    dia[2] = "Martes";
    dia[3] = "Miercoles";
    dia[4] = "Jueves";
    dia[5] = "Viernes";
    dia[6] = "Sabado";
    var resultado = "Hoy es: " + dia[d.getDay()];
    // console.log(resultado);
    return resultado;
  }
  static fechaDescriptiva() {
    var mm = new Date();
    var m2 = mm.getMonth() + 1;
    var mesok = m2 < 10 ? "0" + m2 : m2;
    var mesok = new Array(12);
    mesok[0] = "Enero";
    mesok[1] = "Febrero";
    mesok[2] = "Marzo";
    mesok[3] = "Abril";
    mesok[4] = "Mayo";
    mesok[5] = "Junio";
    mesok[6] = "Julio";
    mesok[7] = "Agosto";
    mesok[8] = "Septiembre";
    mesok[9] = "Octubre";
    mesok[10] = "Noviembre";
    mesok[11] = "Diciembre";
    var yy = mm.getYear();
    var year = yy < 1000 ? yy + 1900 : yy;
    var resultado =
      mm.getDate() + " de " + mesok[mm.getMonth()] + " del " + year;
    // console.log(resultado);
    return resultado;
  }
  static fechaDescriptiva_min() {
    var mm = new Date();
    var m2 = mm.getMonth() + 1;
    var mesok = m2 < 10 ? "0" + m2 : m2;
    var mesok = new Array(12);
    mesok[0] = "Ene";
    mesok[1] = "Feb";
    mesok[2] = "Mar";
    mesok[3] = "Abr";
    mesok[4] = "May";
    mesok[5] = "Jun";
    mesok[6] = "Jul";
    mesok[7] = "Ago";
    mesok[8] = "Sep";
    mesok[9] = "Oct";
    mesok[10] = "Nov";
    mesok[11] = "Dic";
    var resultado = mm.getDate() + " de " + mesok[mm.getMonth()];
    // console.log(resultado);
    return resultado;
  }
} //::END=>Time
new Time();
