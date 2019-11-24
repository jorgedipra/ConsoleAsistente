class tab {
  constructor() {
    tab.click();
  }
  static click() {  
    document.getElementById("wComandos").onclick = comando;
    document.getElementById("wAsistente").onclick = asistent;
    function comando() {
        document.getElementById('container').style.display = 'block';
        document.getElementById('section2').style.display = 'none';
        window.scrollTo(0, 0);
    }
    function asistent() {
        document.getElementById('section2').style.display = 'grid';
        document.getElementById('container').style.display = 'none';
        window.scrollTo(0, window.innerHeight);
      }
    
  }
}
new tab();
