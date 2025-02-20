<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('frontend/style.css') }}" />
  <title>VietNam{{ config('app.name') }} - Đi đu đưa đi</title>
  <link rel="icon" type="image/png" href="{{ asset('frontend/assets/Lotus.png') }}">
</head>

<body>
  <div class="conatiner">
    <section class="front-page">
      <img class="hero" src="{{ asset('frontend/assets/hero.png') }}" alt="meditation" autoplay />
      <video muted autoplay loop class="hero" src="{{ asset('frontend/assets/video.mp4') }}"></video>
      <nav>
        <div class="logo">
          <img src="{{ asset('frontend/assets/logo.webp') }}" alt="mind & body" style="width: 10rem" />
          {{-- <h1>SULAYMANIYAH INTERNATIONAL AIRPORT</h1> --}}
        </div>
        <div class="links">
          @auth
            @if (Auth::user()->is_admin)
              <a href="{{ route('root') }}">Admin</a>
            @else
              <a href="{{ route('root') }}">Thông tin</a>
              <a href="{{ route('tickets.flights') }}">Đặt vé</a>
              <a href="{{ route('tickets.userTickets') }}">Vé của tôi</a>
            @endif
            <a href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 me-1 text-danger align-middle"></i> @lang('translation.Logout')</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          @else
            <a href="{{ route('login') }}">Đăng Nhập</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}">Đăng ký</a>
            @endif
          @endauth
        </div>
        <svg width="44" height="18" viewBox="0 0 44 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <line class="line" y1="1" x2="44" y2="1" stroke="white" stroke-width="2" />
          <line class="line" y1="9" x2="27" y2="9" stroke="white" stroke-width="2" />
          <line class="line" y1="17" x2="11" y2="17" stroke="white" stroke-width="2" />
        </svg>

      </nav>
      <div class="primary-overlay">
        <div class="selling-point">
          <h2>Đi là nhớ</h2>
          <h3>
            Hãy cùng nhau trải nghiệm chuyến đi nào
          </h3>
          <div class="ctas">
            @auth
              <button class="cta-main">
                @if (Auth::user()->is_admin)
                  <a href="{{ route('root') }}">Admin</a>
                @else
                  <a href="{{ route('tickets.flights') }}">Đặt vé ngay</a>
                @endif
              </button>
            @else
              <button class="cta-main">
                <a href="{{ route('tickets.flights') }}">Đặt vé ngay</a>
              </button>
              <button class="cta-sec">
                <a href="{{ route('register') }}">Đăng ký</a>
              </button>
            @endauth
          </div>
        </div>
      </div>
    </section>


    <section class="classes">
      <div class="classes-description">
        <h2>Những nơi đang chờ bạn</h2>
        <h3>Nơi chữa lành và thư giãn dành cho bạn</h3>
      </div>
      <div class="videos">
        <div class="pilates">
          <h3>Pilates</h3>
          <video muted loop class="video" src="{{ asset('frontend/assets/travel-4.mp4') }}"></video>
        </div>
        <div class="yoga">
          <h3>Yoga</h3>
          <video muted loop class="video" src="{{ asset('frontend/assets/travel-2.mp4') }}"></video>
        </div>
        <div class="meditation">
          <h3>Meditation</h3>
          <video muted loop class="video" src="{{ asset('frontend/assets/travel-3.mp4') }}"></video>
        </div>
      </div>
    </section>
    <section class="about">
      <div class="our-story">
        <h2>Về chúng tôi</h2>
        <p>
          Chúng tôi mang đến trải nghiệm bay an toàn, tiện lợi và thoải mái cho mọi hành khách. 
          Với đội ngũ chuyên nghiệp và dịch vụ tận tâm, chúng tôi không ngừng nâng cao chất lượng 
          để mỗi chuyến đi không chỉ là di chuyển, mà còn là hành trình trọn vẹn với những khoảnh khắc đáng nhớ.
        </p>
      </div>
      <img src="{{ asset('frontend/assets/our-story.jpg') }}" alt="our-story" />
    </section>

  </div>

  <footer>
    <div>
      <p>©
        <script>
          document.write(new Date().getFullYear())
        </script> {{ config('app.name') }}. Crafted with ❤️
      </p>
    </div>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/ScrollTrigger.min.js"></script>
  <script src="{{ asset('frontend/script.js') }}"></script>
</body>

</html>
