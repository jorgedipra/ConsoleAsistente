//load js
function include(archivo) {
  const oHead = document.getElementsByTagName("head")[0];
  const oScript = document.createElement("script");
  const extention = ".js";
  const origen = "public/js/";
  oScript.type = "text/javascript";
  oScript.charset = "utf-8";
  oScript.src = origen + archivo + extention;
  oHead.appendChild(oScript);
}

function $(selector) {
  return document.querySelector(selector);
}

function consola(type, cadena = "prueba", argumento) {
  //console.log("%cEspaña","background: red; color: yellow"); 
  var colors = {
    green:
      "color: #19d264;font-size: 16px;font-family: Roboto, Avant Garde,Avantgarde,Century Gothic,CenturyGothic,AppleGothic,sans-serif",
    blue:
      "color: #6699CC;font-size: 16px;font-family: Roboto, Avant Garde,Avantgarde,Century Gothic,CenturyGothic,AppleGothic,sans-serif",
    orange:
      "color: #ff8000;font-size: 16px;font-family: Roboto, Avant Garde,Avantgarde,Century Gothic,CenturyGothic,AppleGothic,sans-serif"
  };
  try {
    if (type) {
      switch (type) {
        case "log":
          console.log("%c" + cadena, colors.green);
          break;
        case "info":
          console.info("%c" + cadena, colors.blue);
          break;
        case "error":
          if (argumento === undefined) {
            console.error(cadena);
          } else {
            console.error(cadena + ":" + argumento);
          }
          break;
        case "cont":
        case "contar":
        case "count":
          console.count(cadena);
          break;
        case "clear":
          console.clear();
          break;
        case "grupo":
        case "group":
          if (argumento === undefined) {
            console.groupCollapsed(cadena);
          } else {
            console.groupCollapsed();
          }
          break;
        case "end":
          console.groupEnd();
          break;
        case "tabla":
        case "table":
          console.table(cadena);
          break;

        default:
          console.log(type);
          break;
      }
    } else {
      return console.trace("consola");
    }
  } catch (error) {
    return console.error(error);
  }
}

function loadScript(url, callback) {
  var head = document.getElementsByTagName("head")[0];
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = url;
  script.onreadystatechange = callback;
  script.onload = callback;
  head.appendChild(script);
} //::END->loadScript
loadScript("public/js/consola.js", load_img);

function load_img() {}
// I wrote about this here: https://medium.com/@erikwoods/i-made-a-discovery-svg-and-svg-animations-in-the-js-console-are-doable-6c367c95726a

var svgbiz = `PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgICAgIHZpZXdCb3g9IjAgMCAxMjAgMTIwIiA
gICAgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gIDxyZWN0IHg9IjEwIiA9Ij
EwIiAgICAgICAgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiICAgICAgICByeD0iMTUiIHJ5PSIxN
SIvPjwvc3ZnPg==`;
var datsvg =
  '<svg xmlns="http://www.w3.org/2000/svg" width="320" height="320" fill="none" stroke="#fff" stroke-linecap="round" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path id="b"><animate id="a" attributeName="d" values="m160,160l0,0 0,0;m130,110l30,-17 30,17;m130,60l30,-17 30,17;m160,20l0,0 0,0" dur="6s" repeatCount="indefinite"/><animate attributeName="stroke-width" values="0;4;4;4;0" dur="6s" repeatCount="indefinite" begin="a.begin"/></path><path id="c"><animate attributeName="d" values="m160,160l0,0 0,0;m130,110l30,-17 30,17;m130,60l30,-17 30,17;m160,20l0,0 0,0" dur="6s" repeatCount="indefinite" begin="a.begin+1s"/><animate attributeName="stroke-width" values="0;4;4;4;0" dur="6s" repeatCount="indefinite" begin="a.begin+1s"/></path><path id="d"><animate attributeName="d" values="m160,160l0,0 0,0;m130,110l30,-17 30,17;m130,60l30,-17 30,17;m160,20l0,0 0,0" dur="6s" repeatCount="indefinite" begin="a.begin+2s"/><animate attributeName="stroke-width" values="0;4;4;4;0" dur="6s" repeatCount="indefinite" begin="a.begin+2s"/></path><path id="e"><animate attributeName="d" values="m160,160l0,0 0,0;m130,110l30,-17 30,17;m130,60l30,-17 30,17;m160,20l0,0 0,0" dur="6s" repeatCount="indefinite" begin="a.begin+3s"/><animate attributeName="stroke-width" values="0;4;4;4;0" dur="6s" repeatCount="indefinite" begin="a.begin+3s"/></path><path id="f"><animate attributeName="d" values="m160,160l0,0 0,0;m130,110l30,-17 30,17;m130,60l30,-17 30,17;m160,20l0,0 0,0" dur="6s" repeatCount="indefinite" begin="a.begin+4s"/><animate attributeName="stroke-width" values="0;4;4;4;0" dur="6s" repeatCount="indefinite" begin="a.begin+4s"/></path><path id="g"><animate attributeName="d" values="m160,160l0,0 0,0;m130,110l30,-17 30,17;m130,60l30,-17 30,17;m160,20l0,0 0,0" dur="6s" repeatCount="indefinite" begin="a.begin+5s"/><animate attributeName="stroke-width" values="0;4;4;4;0" dur="6s" repeatCount="indefinite" begin="a.begin+5s"/></path></defs><use xlink:href="#b"/><use xlink:href="#b" transform="rotate(60 160 160)"/><use xlink:href="#b" transform="rotate(120 160 160)"/><use xlink:href="#b" transform="rotate(180 160 160)"/><use xlink:href="#b" transform="rotate(240 160 160)"/><use xlink:href="#b" transform="rotate(300 160 160)"/><use xlink:href="#c" transform="rotate(30 160 160)"/><use xlink:href="#c" transform="rotate(90 160 160)"/><use xlink:href="#c" transform="rotate(150 160 160)"/><use xlink:href="#c" transform="rotate(210 160 160)"/><use xlink:href="#c" transform="rotate(270 160 160)"/><use xlink:href="#c" transform="rotate(330 160 160)"/><use xlink:href="#d"/><use xlink:href="#d" transform="rotate(60 160 160)"/><use xlink:href="#d" transform="rotate(120 160 160)"/><use xlink:href="#d" transform="rotate(180 160 160)"/><use xlink:href="#d" transform="rotate(240 160 160)"/><use xlink:href="#d" transform="rotate(300 160 160)"/><use xlink:href="#e" transform="rotate(30 160 160)"/><use xlink:href="#e" transform="rotate(90 160 160)"/><use xlink:href="#e" transform="rotate(150 160 160)"/><use xlink:href="#e" transform="rotate(210 160 160)"/><use xlink:href="#e" transform="rotate(270 160 160)"/><use xlink:href="#e" transform="rotate(330 160 160)"/><use xlink:href="#f"/><use xlink:href="#f" transform="rotate(60 160 160)"/><use xlink:href="#f" transform="rotate(120 160 160)"/><use xlink:href="#f" transform="rotate(180 160 160)"/><use xlink:href="#f" transform="rotate(240 160 160)"/><use xlink:href="#f" transform="rotate(300 160 160)"/><use xlink:href="#g" transform="rotate(30 160 160)"/><use xlink:href="#g" transform="rotate(90 160 160)"/><use xlink:href="#g" transform="rotate(150 160 160)"/><use xlink:href="#g" transform="rotate(210 160 160)"/><use xlink:href="#g" transform="rotate(270 160 160)"/><use xlink:href="#g" transform="rotate(330 160 160)"/></svg>';
svgbiz = window.btoa(datsvg);
var cssbiz =
  "background: url('data:image/svg+xml;base64," +
  svgbiz +
  "') left top no-repeat; font-size: 260px;";
console.log("%c  ", cssbiz);
