<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/css/glide.core.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/glide.min.js"></script>
    <link
      rel="stylesheet"
      href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"
    />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/style.css" />
    <title>Document</title>
  </head>
  <body>
    <header>
      <div class="header-logo">
        <a href="">Nos Artisans</a>
      </div>
      <nav class="nav">
        <ul class="nav-items">
          <li class="nav-item"><i class="fa fa-home" style='font-size:30px;color:#33383b'><a href="#accueil">Accueil</a></i></li>
          <li class="nav-item"><i class="fa fa-wrench" style='font-size:30px;color:red'><a href="#services">Nos services</a></i></li>
          <li class="nav-item"><i class="fa fa-sign-in" style='font-size:30px;color:green'><a href="/login/login.php">Connexion</a></i></li>
        </ul>
      </nav>
      <section class="slider-container">
        <div class="glide">
          <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
              <li class="glide__slide">
                <img
                  src="/images/artisans-garagiste.jpg"
                  alt="slide1"
                />
                <h4>Mécanicien</h4>
              </li>
              <li class="glide__slide">
                <img src="/images/artisans-couture.jpg"
                     alt="slide1"
                />
                <h4>Couturier</h4>
              </li>
              <li class="glide__slide">
                <img
                  src="/images/artisans-coiffure.jpg"
                  alt="slide1"
                />
                <h4>Coiffure</h4>
              </li>
              <li class="glide__slide">
                <img
                  src="/images/artisans-plombier-1.jpg"
                  alt="slide1"
                />
                <h4>Plomberie</h4>
              </li>
              <li class="glide__slide">
                <img
                  src="/images/artisans-vitrerie.jpg"
                  alt="slide1"
                />
                <h4>Vitrerie</h4>
              </li>
              <li class="glide__slide">
                <img
                  src="/images/menuisier-3.jpg"
                  alt="slide1"
                />
                <h4>Menuiserie</h4>
              </li>
            </ul>
          </div>

          <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
              <i class="las la-arrow-left"></i>
            </button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
              <i class="las la-arrow-right"></i>
            </button>
          </div>
        </div>
      </section>
    </header>

    <script>
      new Glide('.glide', {
        type: 'carousel',
        perView: 5,
        focusAt: 'center',
        autoplay: 3000,
        arrows: {
          prev: '.glide__arrow--left',
          next: '.glide__arrow--right',
        },
      }).mount();
    </script>

    <!--// refaire si possible-->