/**
 * @version 0.1 on 06 Dic 2019
 * @author @jorgedipra
 * @constructor
 *  @ this.title = title;
 *  @ this.message = message;
 *  @ this.data = data;
 *  @ this.cerrar = cerrar;
 *  @ this.cerrarClick = cerrarClick;
 * @Methods:
 *   @ desk  :  notificaciones de escritorio por el navegador
 *   @ web   :  
 *   @ movil :  
 */

class notificacion {
  constructor(title, message, data, cerrar, cerrarClick) {
    this.title = title;
    this.message = message;
    this.data = data;
    this.cerrar = cerrar;
    this.cerrarClick = cerrarClick;
  }
  static desk(clic, clouse) {
    if (!Notification) {
      return false;
    }
    if (Notification.permission !== "granted") {
      Notification.requestPermission();
    }
    this.title = this.title || "Alis Dice:";
    this.message = this.message || "";
    this.data = this.data || "1";
    this.cerrar = this.cerrar || "false";
    let extra = {
      icon: "storage/logo/ico.ico",
      body: this.message,
      requireInteraction: false, //true:cerrar manual||false: cerrar con .close
      badge: "storage/logo/alfa.png", //miniICono
      lang: "es-CO",
      vibrate: [200, 100, 200]
    };
    let noti = new Notification(notificacion.title, extra);

    noti.onclick = function() {
      clic();
      consola('log',notificacion.cerrarClick);
      if (notificacion.cerrarClick == true) {
        noti.close();
      }
    };
    noti.onclose = function() {
      clouse();
    };
    if (this.cerrar != "false") {
      setTimeout(function() {
        noti.close();
      }, this.cerrar);
    }
  }//::END=>desk

  static web() {}
  static movil() {}
}
new notificacion();

/**
  @example #NOTE
 * 
notificacion.title = "titulo"; //titulo de la notificación
notificacion.message = "Esta es una Notificación de prueba  \n abc"; //mensahe de la notifiación
notificacion.cerrar = 30000000; //duracion de la notificación
notificacion.data = 200; //un valor que s epuede dar a la aplicacion
notificacion.cerrarClick = true;//cerrar al precionar la notificación
new notificacion();
notificacion.desk(
  function() {
    onclickVentana();
  },
  function() {
    CloseVentana();
  }
);

function onclickVentana() {
  dataconsola = {
    consola: "ventana"
  };
  app.mensaje.push(dataconsola);
  console.log(notificacion.data);
}

function CloseVentana() {
  dataconsola = {
    consola: ":P"
  };
  app.mensaje.push(dataconsola);
}

*
 */