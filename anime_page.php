<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <link rel="stylesheet" href="/Public/css/style.css" />
    <title></title>
</head>
<style>
    body{
        margin: 0;
        padding: 0;
        font-family: Montserrat;
        background: #1c1a1a;
    }
    .center{
        display: flex;
        text-align: center;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .ring{
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        animation: ring 2s linear infinite;
    }
    @keyframes ring {
        0%{
            transform: rotate(0deg);
            box-shadow: 1px 5px 2px #e65c00;
        }
        50%{
            transform: rotate(180deg);
            box-shadow: 1px 5px 2px #18b201;
        }
        100%{
            transform: rotate(360deg);
            box-shadow: 1px 5px 2px #0456c8;
        }

    }
    .ring:before{
        position: absolute;
        content: '';
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(255,255,255,.3);
    }
    span{
        color: #ffffff;
        font-size: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
        line-height: 200px;
        animation: text 3s ease-in-out infinite;
    }
    @keyframes text {
        50%{
            color: black;
        }

    }
</style>
<script>
    setTimeout(function(){
        window.location.href = './index.php';
    }, 5000);
</script>
<body>
<div class="center">
    <div class="ring">
        <span>Entrepise 75..</span>
    </div>
</div>
</body>
</html>