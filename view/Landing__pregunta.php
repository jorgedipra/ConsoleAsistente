{
    "Nrespuestas":"<?=$Landing_pregunta["Nrespuestas"]?>",
    <?php if($Landing_pregunta["nose"]!=1)
        foreach($Landing_pregunta["respuesta"] AS $key =>$respuestas ):?>
		"respuesta<?=$key?>" : "<?=$respuestas["respuesta"]?>"
        <?php if($key<=(count($Landing_pregunta["respuesta"])-2)) echo ",";?>
    <?php endforeach?>
}