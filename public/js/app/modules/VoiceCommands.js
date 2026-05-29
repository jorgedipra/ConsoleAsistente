/**
 * VoiceCommands - Comandos de voz del asistente
 * Consolida: N.comandos.js + N.funcionesComandos.js
 */
class VoiceCommands {
  constructor() {
    this.command = {};
    this.activo = false;
    this.cargado = false;
  }

  /**
   * Carga los comandos disponibles
   */
  static async cargar() {
    return new Promise((resolve, reject) => {
      try {
        // Verificar si ya está cargado
        if (typeof comandos !== 'undefined' && comandos.command) {
          VoiceCommands.instance = comandos;
          resolve(comandos);
          return;
        }

        // Intentar cargar dinámicamente
        if (typeof include === 'function') {
          include('home/N.comandos');
        }

        // Esperar a que cargue
        let intentos = 0;
        const verificar = setInterval(() => {
          intentos++;
          if (typeof comandos !== 'undefined' && comandos.command) {
            clearInterval(verificar);
            VoiceCommands.instance = comandos;
            resolve(comandos);
          } else if (intentos >= 20) {
            clearInterval(verificar);
            reject('No se pudieron cargar los comandos');
          }
        }, 100);
      } catch (error) {
        reject(error);
      }
    });
  }

  /**
   * Activa comandos de voz
   */
  static activar() {
    if (typeof annyang !== 'undefined') {
      // Configurar comandos con Annyang
      if (typeof comandos !== 'undefined' && comandos.command) {
        const comandosObj = {};
        for (const key in comandos.command) {
          comandosObj[key] = () => VoiceCommands.ejecutar(key);
        }
        annyang.addCommands(comandosObj);
        annyang.start();
        VoiceCommands.activo = true;
        return true;
      }
    }
    return false;
  }

  /**
   * Desactiva comandos de voz
   */
  static desactivar() {
    if (typeof annyang !== 'undefined') {
      annyang.abort();
      VoiceCommands.activo = false;
      return true;
    }
    return false;
  }

  /**
   * Ejecuta un comando por nombre
   */
  static ejecutar(nombre) {
    try {
      if (typeof funcionesComandos !== 'undefined') {
        const funcion = comandos.command[nombre];
        if (funcion && typeof funcionesComandos[funcion] === 'function') {
          funcionesComandos[funcion]();
          return true;
        }
      }
    } catch (error) {
      consola('error', 'VoiceCommands.ejecutar', error);
    }
    return false;
  }

  /**
   * Lista todos los comandos disponibles
   */
  static listar() {
    if (typeof comandos !== 'undefined' && comandos.command) {
      return Object.keys(comandos.command);
    }
    return [];
  }

  /**
   * Verifica si un texto es un comando
   */
  static esComando(texto) {
    const limpio = texto.toUpperCase().trim();
    if (typeof comandos !== 'undefined' && comandos.command[limpio]) {
      return true;
    }
    return false;
  }
}