
<section class="numbered-cols" style="position: relative;">
<div class="container py-5">
    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card p-4">
          <div class="card-number">1</div>
          <p class="card-text">Do you feel your current ways of working are <span class="highlight">DELIVERING CHANGE</span> fast and effectively?</p>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card p-4">
          <div class="card-number">2</div>
          <p class="card-text">Does your working environment <span class="highlight">EMPOWER YOU</span> or <span class="highlight">CONSTRAIN YOU</span>?</p>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="card p-4">
          <div class="card-number">3</div>
          <p class="card-text">How quickly can you <span class="highlight">RESPOND</span> to <span class="highlight">OPPORTUNITIES</span>?</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
<style>
    .card {
      background: linear-gradient(135deg, #663399, #cc33cc);
      color: white;
      text-align: center;
      border: none;
      border-radius: 20px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    .card-number {
      font-size: 5rem;
      font-weight: bold;
      background: white;
      color: #663399;
      border-radius: 50%;
      width: 100px;
      height: 100px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto 20px;
    }
    .card-text {
      font-size: 1.2rem;
    }
    .highlight {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card p-4">
          <div class="card-number">1</div>
          <p class="card-text">Do you feel your current ways of working are <span class="highlight">DELIVERING CHANGE</span> fast and effectively?</p>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card p-4">
          <div class="card-number">2</div>
          <p class="card-text">Does your working environment <span class="highlight">EMPOWER YOU</span> or <span class="highlight">CONSTRAIN YOU</span>?</p>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="card p-4">
          <div class="card-number">3</div>
          <p class="card-text">How quickly can you <span class="highlight">RESPOND</span> to <span class="highlight">OPPORTUNITIES</span>?</p>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Slick Slider Initialization -->
<?php
add_action('wp_footer', function () {
?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.feat-slider__wrapper').forEach(function (slickWrapper) {
            var slickPrev = slickWrapper.closest('.feat-slider').querySelector('.slick-prev');
            var slickNext = slickWrapper.closest('.feat-slider').querySelector('.slick-next');

            if (slickPrev && slickNext) {
                $(slickWrapper).slick({
                    dots: true,
                    arrows: true,
                    prevArrow: slickPrev,
                    nextArrow: slickNext,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    fade: true,
                    cssEase: 'linear'
                });
            }
        });
    });
</script>

<?php
}, 9999);