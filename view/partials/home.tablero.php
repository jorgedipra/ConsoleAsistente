<div id="container" class="container">

    <div class="container bordertable card-style font-robot top2">

       <div id="tablero" class="row" > 

            <div class="col-sm">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">comando / Tipo</li>
                    <li class="list-group-item">hola = voz/comando</li>
                    <li class="list-group-item">pedir la edad = voz/comando</li>
                    <li class="list-group-item">escuchar = voz/comando</li>
                    <li class="list-group-item">adiós = voz/comando</li>
                    <li class="list-group-item">-aprender = comando</li>
                    <li class="list-group-item">-salir = comando</li>
                    <li class="list-group-item">-terminar = comando</li>
                </ul>
            </div>

            <div class="col-sm">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-danger">Directos</li>
                    <li class="list-group-item">
                        <button class="button1 font-robot color-black" onclick="Escuchar();">Escuchar</button>
                        <button class="button1 font-robot" onclick="NoEscuchar();">dejar de escuchat</button> <br>
                        <button class="button1 font-robot color-black" onclick="comandosOn()">comandos por voz</button>
                        <button class="button1 font-robot" onclick="comandosOff()">apagar comandos por voz</button>
                    </li>
                </ul>
            </div>
                
        </div>
        
    </div>
</div>