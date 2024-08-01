<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion d'Articles</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>

</head>
<style>
    .slider {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .slides {
        display: flex;
        transition: transform 1s ease-in-out;
    }

    .slide {
        min-width: 100%;
        box-sizing: border-box;
    }

    .slide img {
        width: 100%;
        /*height: 50%;*/
        object-fit: cover;
    }
    .container2{
        position: relative;
        width: 100%;
        min-height: 450px;
        background-color: #f5f5f5;
    }
    .container2 .contents-wraper{
        width: 70%;
        min-height: inherit;
        margin: 30px auto;
        text-align: center;
    }
 .contents-wraper{
     width: 70%;
     min-height: inherit;
     margin: 30px;
     text-align: center;
 }
 .contents-wraper .header1 h1{
    position: relative;
     font-size: 40px;
     text-transform: uppercase;
     font-weight: 500;
     text-align: center;
     letter-spacing: 1px;
 }
    .contents-wraper .header1 h1::before{
        content: '';
        width: 200px;
        height: 2px;
        background-color: #006994;
        border-radius: 15px;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: -10px;
    }
    .contents-wraper .testRow{
        width: 100%;
        min-height: inherit;
        position: relative;
        overflow: hidden;
    }
    .testRow .testItem{
        width: 100%;
        height: 100%;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .testRow .testItem:not(.active){
        top: 0;
        left: -100%;
    }
    .testRow .testItem img{
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 5px;
        outline:2px solid#006994;
        outline-offset: 2px;
    }
    .testRow .testItem h3{
        font-size:30px;
        font-style: italic;
        padding: 7px;
    }
    .testRow .testItem h4{
        font-style: italic;
    }
    .testRow .testItem p{
        font-size: 18px;
        letter-spacing: 1px;
        line-height: 1;
        padding: 10px;
    }
    .contents-wraper .indicators{
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px;
        cursor: pointer;
    }
    .contents-wraper .indicators .dot{
        width: 15px;
        height: 15px;
        margin: 0 3px;
        border: 3px solid #aaa;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.5s ease;
    }
    .contents-wraper .indicators .active{
        background-color: #006994;
    }
    @keyframes next1 {
        from{
            left: 0;
        }
        to{
            left: -100%;
        }

    }
    @keyframes next2 {
        from{
            left: 100%;
        }
        to{
            left: 0;
        }

    }
    @keyframes prev1 {
        from{
            left: 0;
        }
        to{
            left: 100%;
        }

    }
    @keyframes prev2 {
        from{
            left: -100%;
        }
        to{
            left: 0;
        }

    }
    @media (max-width: 550px) {
        .container2 .contents-wraper{
            width: 90%;
        }
        .contents-wraper .header1 h1{
            font-size: 32px;
        }
        .testRow .testItem h3{
            font-size: 26px;
        }
        .testRow .testItem p{
            font-size: 16px;
            letter-spacing: initial;
            line-height: initial;
        }

    }
</style>
<body>
<section style="background: #f5f6f2;">
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-24 lg:px-6">
        <h1 style="color: green">Pourquoi nous choisir ?</h1>

        <p>
            Nous savons qu'il n'est toujours pas aussi simple de trouver un bon artisan pour vos travaux.
            Partant de ce constat, nous avons mit à votre
            disposition notre service de mise en relation;
            des artisans certifiés près de vous pour vos besoins de dépannage domestiques et/ou vos projets de rénovations.
            Pour ce fait, nous collaborons avec les bons professionnels du bâtiment qui se sont engagés avec nous pour vous offrir un travail de qualité.
        </p>
        <br/>
        <br/>
        <div id="container">
            <div class="icon">
                <i class="fa fa-user" aria-hidden="true"></i>
                <h3>Le Professionnalisme</h3>
                <p>Nous travaillons avec des artisans ayant plusieurs années d’expériences dans leurs domaines, certifiés et évalués par des experts.
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-wrench" aria-hidden="true"></i>
                <h3>Le Savoir Faire</h3>
                <p>Nos artisans doivent mettre en avant la qualité de leur travail. Pour cela, nous veillons à la qualité de nos prestations et mettons en avant une garantie satisfait ou refait selon nos termes et conditions.
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                <h3>Les Meilleurs Prix</h3>
                <p>Nous vous offrons le meilleur rapport qualité du travail/prix de la prestation.
                    Nos prix sont révisés et adaptés aux services.
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <h3>Une Intervention 7j/7</h3>
                <p>
                    Nous nous engageons pour vous offrir nos services en tous temps, en tous lieux et le plus rapidement possible.
                </p>
            </div>
        </div>
    </div>
</section>
<section style="background: #ffffff;">
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-24 lg:px-6">
        <h1 style="color: green">Comment fonctionne le service pour vous ?</h1>
        <p>
            Désormais, plus bésoin de vous déplacer pour trouver un artisan pour vos travaux d'installations, nous avons référencer pour vous, près de vous les bons professionnels pour vous dépanner.
            Obtenez tout le savoir-faire de nos professionnels à des prix bas pour tout type de prestation.
        </p>
        <br/>
        <br/>
        <div id="container" class="col-xs-3 col-sm-2 col-md-12">
            <div class="icon">
                <img src="/Public/images/service-icon2.png"/>
                <h3>Etape 1</h3>
                <p>
                    Décrivez votre besoin, quelle
                    prestation souhaitez vous !
                </p>
            </div>
            <div class="icon">
                <img src="/Public/images/fact2.png"/>
                <h3>Etape 2</h3>
                <p>
                    Sélectionnez votre artisan,<br/>
                    fournissez vos coordonnées, adresse,
                    disponibilité.<br/> Nous transmettons ces
                    informations à l'artisan, vos données
                    restent confidentielles.
                </p>
            </div>
            <div class="icon">
                <img src="/Public/images/fact1.png"/>
                <h3>Etape 3</h3>
                <p>
                    Après validation de la réservation,<br/> l'artisan réalise vos travaux, c'est simple, rapide et sécurisé.
                </p>
            </div>
        </div>
    </div>
</section>
<div class="container2">
    <div class="contents-wraper">
        <section class="header1"><h1>Témoignages</h1></section>
        <section class="testRow">
            <div class="testItem active">
                <img src="/Public/images/loba.png" alt="Image 1"/>
                <h3>Mr. Loba</h3>
                <h4>Abidjan, Côte D'Ivoire</h4>
                <p> La publicité met en avant la modernité et la jeunesse. Ces deux piliers étant porteurs
                    d’avenir, l’agence a mis en valeur certains éléments. Les graphiques, les couleurs et les
                    scénarios sont associés pour montrer l’appartenance de la banque à la société actuelle.
                </p>
            </div>
            <div class="testItem">
                <img src="/Public/images/Esli%20Joed.png" alt="Image 2"/>
                <h3>Esli Joed</h3>
                <h4>Abidjan, Côte D'Ivoire</h4>
                <p> La publicité met en avant la modernité et la jeunesse. Ces deux piliers étant porteurs
                    d’avenir, l’agence a mis en valeur certains éléments. Les graphiques, les couleurs et les
                    scénarios sont associés pour montrer l’appartenance de la banque à la société actuelle.
                </p>
            </div>
            <div class="testItem">
                <img src="/Public/images/Jean%20Martial.png" alt="Image 1"/>
                <h3>Jean Martial</h3>
                <h4>Abidjan, Côte D'Ivoire</h4>
                <p> La publicité met en avant la modernité et la jeunesse. Ces deux piliers étant porteurs
                    d’avenir, l’agence a mis en valeur certains éléments. Les graphiques, les couleurs et les
                    scénarios sont associés pour montrer l’appartenance de la banque à la société actuelle.
                </p>
            </div>
            <div class="testItem">
                <img src="/Public/images/konaté.png" alt="Image 1"/>
                <h3>Md. Konaté</h3>
                <h4>Abidjan, Côte D'Ivoire</h4>
                <p> La publicité met en avant la modernité et la jeunesse. Ces deux piliers étant porteurs
                    d’avenir, l’agence a mis en valeur certains éléments. Les graphiques, les couleurs et les
                    scénarios sont associés pour montrer l’appartenance de la banque à la société actuelle.
                </p>
            </div>
            <div class="testItem">
                <img src="/Public/images/benjamen.png" alt="Image 1"/>
                <h3>Mr. Benjamin kouassi</h3>
                <h4>Abidjan, Côte D'Ivoire</h4>
                <p> La publicité met en avant la modernité et la jeunesse. Ces deux piliers étant porteurs
                    d’avenir, l’agence a mis en valeur certains éléments. Les graphiques, les couleurs et les
                    scénarios sont associés pour montrer l’appartenance de la banque à la société actuelle.
                </p>
            </div>
            <div class="testItem">
                <img src="/Public/images/coulibaly.png" alt="Image 1"/>
                <h3>Mr. coulibaly</h3>
                <h4>Abidjan, Côte D'Ivoire</h4>
                <p> La publicité met en avant la modernité et la jeunesse. Ces deux piliers étant porteurs
                    d’avenir, l’agence a mis en valeur certains éléments. Les graphiques, les couleurs et les
                    scénarios sont associés pour montrer l’appartenance de la banque à la société actuelle.
                </p>
            </div>
        </section>
        <section class="indicators">
            <div class="dot active" attr='0' onclick="switchTest(this)"></div>
            <div class="dot" attr='1' onclick="switchTest(this)"></div>
            <div class="dot" attr='2' onclick="switchTest(this)"></div>
            <div class="dot" attr='3' onclick="switchTest(this)"></div>
            <div class="dot" attr='4' onclick="switchTest(this)"></div>
            <div class="dot" attr='5' onclick="switchTest(this)"></div>
        </section>
    </div>
</div>
<section class="slider-container">
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-24 lg:px-6">
        <figure class="max-w-screen-md mx-auto">
            <h1 class="">Contacter nos différents artisans pour vos besoins</h1>
            <button type="submit"><a href="/Vue/Pages/trouve-artisans/artisans.php">Contactez un artisans</a></button>
        </figure>
    </div>
</section>
<br>
<br>
<section class="slide-section">
    <div class="slider">
        <div class="slides">
            <div class="slide"><img src="/Public/images/E75-3.png" alt="Image 1"/></div>
            <div class="slide"><img src="/Public/images/pub1.1.jpeg" alt="Image 2"/></div>
        </div>
        <button class="prev" onclick="showPrevSlide()">&#10094;</button>
        <button class="next" onclick="showNextSlide()">&#10095;</button>
    </div>
</section>
<script>
    let currentIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;
    const delay = 3000; // 50 secondes

    function showNextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        document.querySelector('.slides').style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    setInterval(showNextSlide, delay);

    function showPrevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateSlidePosition();
    }
    let testSlide = document.querySelectorAll('.testItem');
    let dots = document.querySelectorAll('.dot');
    var counter =0;
    function switchTest(currentTest){
        currentTest.classList.add('active')
        var testId = currentTest.getAttribute('attr');
        if (testId> counter){
            testSlide[counter].style.animation ='next1 0.5s ease-in forwards';
            counter = testId;
            testSlide[counter].style.animation ='next2 0.5s ease-in forwards';
        }else if (testId === counter){return;}
        else {
            testSlide[counter].style.animation ='prev1 0.5s ease-in forwards';
            counter = testId;
            testSlide[counter].style.animation ='prev2 0.5s ease-in forwards';
        }
        indicators();
    }
    function indicators(){
        for (i = 0; i <dots.length; i++){
            dots[i].className = dots[i].className.replace(' active', '');
        }
        dots[counter].className += ' active';

    }
    function slideNext(){
        testSlide[counter].style.animation ='next1 0.5s ease-in forwards';
        if (counter >= testSlide.length -1){
            counter = 0
        }
        else {
            counter++;
        }
        testSlide[counter].style.animation ='next2 0.5s ease-in forwards';
        indicators();
    }
    function autoSliding(){
        deletIntInterval = setInterval(timer, 2000);
        function timer(){
            slideNext();
            indicators();
        }
    }
    autoSliding();
    const container = document.querySelector('.indicators');
    container.addEventListener('mouseover', pause);
    function  pause(){
        clearInterval(deletIntInterval);
    }
    container.addEventListener('mouseout', autoSliding);
    // function updateSlidePosition() {
    //     document.querySelector('.slides').style.transform = `translateX(-${currentIndex * 100}%)`;
    // }
    //
    // setInterval(showNextSlide, 3000); // Change slide every 3 seconds
</script>
</body>
</html>

