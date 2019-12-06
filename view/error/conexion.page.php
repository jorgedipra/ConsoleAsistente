<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ConsolaAsistent</title>
    <link rel="shortcut icon" href="storage/logo/ico.ico" />
    <link rel="apple-touch-icon" href="storage/logo/ico.ico" />
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="public/files/bootstrap-4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/font/awesome5/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="public/css/error/conexion.css?v=0.2">
</head>

<body>
    <div class="container-fluid">
        <svg width="380px" height="500px" viewBox="0 0 837 1045" version="1.1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                <path d="M353,9 L626.664028,170 L626.664028,487 L353,642 L79.3359724,487 L79.3359724,170 L353,9 Z"
                    id="Polygon-1" stroke="#007FB2" stroke-width="6" sketch:type="MSShapeGroup"></path>
                <path d="M78.5,529 L147,569.186414 L147,648.311216 L78.5,687 L10,648.311216 L10,569.186414 L78.5,529 Z"
                    id="Polygon-2" stroke="#EF4A5B" stroke-width="6" sketch:type="MSShapeGroup"></path>
                <path d="M773,186 L827,217.538705 L827,279.636651 L773,310 L719,279.636651 L719,217.538705 L773,186 Z"
                    id="Polygon-3" stroke="#795D9C" stroke-width="6" sketch:type="MSShapeGroup"></path>
                <path d="M639,529 L773,607.846761 L773,763.091627 L639,839 L505,763.091627 L505,607.846761 L639,529 Z"
                    id="Polygon-4" stroke="#F2773F" stroke-width="6" sketch:type="MSShapeGroup"></path>
                <path d="M281,801 L383,861.025276 L383,979.21169 L281,1037 L179,979.21169 L179,861.025276 L281,801 Z"
                    id="Polygon-5" stroke="#36B455" stroke-width="6" sketch:type="MSShapeGroup"></path>
            </g>
        </svg>
        <div class="message-box">
            <h1>ERROR 2002 (HY000)</h1>
            <p>
                <div class="card border-danger mb-3" style="max-width: 28rem;">
                    <div class="card-header"><?=$this->Error?></div>
                    <div class="card-body text-danger">
                        <h5 class="card-title text-white">Error:</h5>
                        <p class="card-text">
                            <?php printf(" %s\n", mysqli_error($enlace));?>
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-success">

                        Can’t connect to local MySQL server through socket
                    </div>
                </div>
            </p>
            <div class="buttons-con">
                <div class="action-link-wrap text-center">
                    <a onclick="history.back(-1)" class="link-button link-back-button">Go Back</a>
                    <a href="https://github.com/jorgedipra/ConsoleAsistente" class="link-button">Fork me on GitHub</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="public/js/general.js"></script>
<script>
let array = $("body").children;
    for(let i in array){
        $("body").children[i].innerText=""
        if($("body").children[i].getAttribute('charset')==='UTF-8'){
            break;
        }
    }
</script>
</html>