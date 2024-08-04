
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/css/glide.core.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/glide.min.js"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Public/css/style.css" />
    <title></title>
</head>
<body>
<header>
    <div class="header-logo">
        <img src="/Public/images/log75.jpeg" alt="">
    </div>
    <nav class="nav">
        <ul class="nav-items">
            <li class="nav-item">
                <a href="/index.php">
                    <i class="fa fa-home" style="font-size:30px;color:#33383b;"></i>
                    Accueil
                </a>
            </li>
            <li class="nav-item">
                <a href="/Vue/Pages/contactez-nous/contact.php">
                    <i class="fa fa-phone" style="font-size:30px;color:#92ef98;"></i>
                    Contactez-nous
                </a>
            </li>
            <li class="nav-item">
                <a href="/Vue/Pages/prise-de-rdv/payement_stripe.php">
                    <i class="fa fa-calendar" style="font-size:30px;color:#e3b28d;"></i>
                    Prendre un rendez-vous
                </a>
            </li>
            <li class="nav-item">
                <a href="/Vue/Pages/trouve-artisans/artisans.php">
                    <i class="fa fa-phone" style="font-size:30px;color:#daed34;"></i>
                    Contactez un artisans
                </a>
            </li>
            <?php if (!isset($_SESSION['pseudo'])): ?>
                <li class="nav-item">
                    <a href="/Vue/Pages/login/login.php">
                        <i class="fa fa-sign-in" style="font-size:30px;color:green;"></i>
                        Connexion
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item-icon">
                <?php if (isset($_SESSION['pseudo'])): ?>
                    <div class="user-icon">
                        <img src="/Public/images/laptop-user.png" alt="Icône Utilisateur">
                        <div class="popup">
                            <div class="popup-content">
                                <div class="user-name"><?php echo htmlspecialchars($_SESSION['pseudo']); ?></div>
                                <div class="menu-options">
                                    <a href="/Vue/Pages/user/users.php">Profil</a>
                                    <a href="/Vue/Pages/deconnection/deconnection.php">Déconnexion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
    <section class="slider-container">
        <div class="glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <li class="glide__slide">
                        <img src="/Public/images/artisans-garagiste.jpg" alt="slide1"/>
                        <h4>Mécanicien</h4>
                    </li>
                    <li class="glide__slide">
                        <img src="/Public/images/artisans-couture.jpg" alt="slide1"/>
                        <h4>Couturier</h4>
                    </li>
                    <li class="glide__slide">
                        <img src="/Public/images/artisans-coiffure.jpg" alt="slide1"/>
                        <h4>Coiffure</h4>
                    </li>
                    <li class="glide__slide">
                        <img src="/Public/images/artisans-plombier-1.jpg" alt="slide1"/>
                        <h4>Plomberie</h4>
                    </li>
                    <li class="glide__slide">
                        <img src="/Public/images/artisans-vitrerie.jpg" alt="slide1"/>
                        <h4>Vitrerie</h4>
                    </li>
                    <li class="glide__slide">
                        <img src="/Public/images/menuisier-3.jpg" alt="slide1"/>
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
    document.addEventListener('DOMContentLoaded', function() {
        const userIcon = document.querySelector('.user-icon');
        const popup = document.querySelector('.popup');

        userIcon.addEventListener('click', function() {
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        });

        // Close the popup if clicked outside
        document.addEventListener('click', function(event) {
            if (!userIcon.contains(event.target) && !popup.contains(event.target)) {
                popup.style.display = 'none';
            }
        });
    });

</script>
</body>
</html>
