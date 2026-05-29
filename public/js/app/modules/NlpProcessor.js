/**
 * NlpProcessor - Procesamiento de lenguaje natural
 * Consolida: N.clasificar.js + N.memoria.js + neuronas.js
 */
class NlpProcessor {
  constructor() {
    this.palabras = [];
    this.limpia = '';
    this.original = '';
  }

  /**
   * Procesa el input del usuario
   * @param {string} original - Texto original del usuario
   * @returns {Object} - { limpia, palabras }
   */
  static procesar(original) {
    const limpia = NlpProcessor.limpiar(original);
    const palabras = NlpProcessor.tokenizar(original);

    return {
      limpia,
      palabras,
      original
    };
  }

  /**
   * Limpia el texto: elimina acentos, símbolos, espacios múltiples
   */
  static limpiar(texto) {
    texto = NlpProcessor.normalizar(texto);
    texto = texto.replace(/[-"',.;*+¿?¡!^${}=()|[\]\\]/g, ' ');
    texto = texto.split(' ').filter(e => e !== '').join(' ');
    texto = texto.trim().toUpperCase();
    return texto;
  }

  /**
   * Tokeniza: separa en array de palabras
   */
  static tokenizar(texto) {
    texto = texto.replace(/[-"',.;*+¿?¡!^${}=()|[\]\\]/g, ' ');
    const palabras = texto.split(' ').filter(e => e !== '');
    return JSON.stringify(palabras);
  }

  /**
   * Elimina acentos/diacríticos
   */
  static normalizar(str) {
    const from = 'ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç',
      to = 'AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuuNnCc',
      mapping = {};

    for (let i = 0, j = from.length; i < j; i++) {
      mapping[from.charAt(i)] = to.charAt(i);
    }

    let ret = [];
    for (let i = 0, j = str.length; i < j; i++) {
      let c = str.charAt(i);
      if (mapping.hasOwnProperty(str.charAt(i))) {
        ret.push(mapping[c]);
      } else {
        ret.push(c);
      }
    }
    return ret.join('');
  }

  /**
   * Clasifica el tipo de input
   */
  static clasificar(input) {
    const limpia = NlpProcessor.limpiar(input);

    // Detectar operaciones matemáticas
    const numeros = /[1-9]/;
    const operadores = /[*+\-/]/;
    const signosTexto = /(POR|DIVIDIDO)/;

    if (numeros.test(limpia) && (operadores.test(limpia) || signosTexto.test(limpia))) {
      return 'operacion';
    }

    // Detectar preguntas
    const preguntas = /(QUE|QUIEN|COMO|CUANDO|CUANTO|CUANTA|DONDE|POR QUE)/;
    if (preguntas.test(limpia) || input.indexOf('?') > 0) {
      return 'pregunta';
    }

    return 'otro';
  }

  /**
   * Capitaliza primera letra
   */
  static capitalizar(input) {
    if (!input) return '';
    return input.charAt(0).toUpperCase() + input.substr(1).toLowerCase();
  }
}