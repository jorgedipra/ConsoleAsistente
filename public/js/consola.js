// Script para sustituir imágenes rotas
function Imagencheck(img) {
	if (!img.complete) return false;
	if (typeof img.naturalWidth != "undefined" && img.naturalWidth == 0) return false;
	return true;
}//::END->Imagencheck
function RevisarImagenesRotas() {
	var replacementImg = "/storage/web/404/no-imagen.png";
	for(var i = 0; i < document.images.length; i++) {
		if(!Imagencheck(document.images[i])) {
			console.error("Imagen: [ "+document.images[i].src+"], Error(404)")
			document.images[i].src = replacementImg;
		}
	}
}//END->RevisarImagenesRotas
window.addEventListener("load", RevisarImagenesRotas);
// $('script').each(function(){
//         	   console.log('XD'+$(this).attr('src'));
//  });