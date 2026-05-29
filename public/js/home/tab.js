class tab {
  constructor() {
    tab.click();
  }
  static click() {
    const wComandos = document.getElementById("wComandos");
    const wAsistente = document.getElementById("wAsistente");

    if (wComandos) {
        wComandos.onclick = comando;
    }
    if (wAsistente) {
        wAsistente.onclick = asistent;
    }

    function comando() {
        const container = document.getElementById('container');
        const section2 = document.getElementById('section2');
        if (container) container.style.display = 'block';
        if (section2) section2.style.display = 'none';
        window.scrollTo(0, 0);
    }
    function asistent() {
        const container = document.getElementById('container');
        const section2 = document.getElementById('section2');
        if (section2) section2.style.display = 'grid';
        if (container) container.style.display = 'none';
        window.scrollTo(0, window.innerHeight);
    }
  }
}
new tab();
