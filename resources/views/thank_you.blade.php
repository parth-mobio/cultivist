<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Cultivist</title>

    <link rel="stylesheet" href="{{ asset('/') }}css/jquery-ui.css">
    <script src="{{ asset('/') }}js/futura-pt.js"></script>
    <script src="{{ asset('/') }}js/futura-pt-bold.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}js/HvGL0enBCARnu58YIXYOQ_iyoLHUDOO5dCyItrHhg7tfeCSIfFHN4UJLFRbh5.js"></script>
    <style type="text/css">@font-face{font-family:futura-pt-bold;src:url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt-bold;src:url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/l?subset_id=2&fvd=n3&v=3) format("woff2"),url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/d?subset_id=2&fvd=n3&v=3) format("woff"),url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/a?subset_id=2&fvd=n3&v=3) format("opentype");font-weight:300;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/l?subset_id=2&fvd=n4&v=3) format("woff2"),url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/d?subset_id=2&fvd=n4&v=3) format("woff"),url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/a?subset_id=2&fvd=n4&v=3) format("opentype");font-weight:400;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/l?subset_id=2&fvd=n5&v=3) format("woff2"),url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/d?subset_id=2&fvd=n5&v=3) format("woff"),url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/a?subset_id=2&fvd=n5&v=3) format("opentype");font-weight:500;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/l?subset_id=2&fvd=n6&v=3) format("woff2"),url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/d?subset_id=2&fvd=n6&v=3) format("woff"),url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/a?subset_id=2&fvd=n6&v=3) format("opentype");font-weight:600;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/849347/000000000000000000010093/27/l?subset_id=2&fvd=i3&v=3) format("woff2"),url(https://use.typekit.net/af/849347/000000000000000000010093/27/d?subset_id=2&fvd=i3&v=3) format("woff"),url(https://use.typekit.net/af/849347/000000000000000000010093/27/a?subset_id=2&fvd=i3&v=3) format("opentype");font-weight:300;font-style:italic;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/l?subset_id=2&fvd=i4&v=3) format("woff2"),url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/d?subset_id=2&fvd=i4&v=3) format("woff"),url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/a?subset_id=2&fvd=i4&v=3) format("opentype");font-weight:400;font-style:italic;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}</style><script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <script type="text/javascript" src="{{ asset('/') }}js/uA6bzwO1_HAQbuVv3YB_KFd_CdC7i2s3RExXVUfS1uJfeTCIf4e6pUJ6wRMU5.js"></script>
    <style type="text/css">@font-face{font-family:futura-pt-bold;src:url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/l?subset_id=2&fvd=n3&v=3) format("woff2"),url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/d?subset_id=2&fvd=n3&v=3) format("woff"),url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/a?subset_id=2&fvd=n3&v=3) format("opentype");font-weight:300;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/l?subset_id=2&fvd=n4&v=3) format("woff2"),url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/d?subset_id=2&fvd=n4&v=3) format("woff"),url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/a?subset_id=2&fvd=n4&v=3) format("opentype");font-weight:400;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/l?subset_id=2&fvd=i4&v=3) format("woff2"),url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/d?subset_id=2&fvd=i4&v=3) format("woff"),url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/a?subset_id=2&fvd=i4&v=3) format("opentype");font-weight:400;font-style:italic;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}</style><script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/style.css">
  </head>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-71079941-22"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-71079941-22');
  </script>
 <body>
    <nav class="navbar navbar-expand-md navbar-light bg-white">
      <div class="container-fluid">
        <a class="navbar-brand" href="https://ww2.thecultivist.com/"><img src="{{ asset('/') }}images/logo.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="https://ww2.thecultivist.com/memberships-options">Join Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://members.thecultivist.com/login">Sign In</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <main>
      <section class="section-thankyou">
        <div class="ty-wrap">
          <div class="item-icon"><img src="{{ asset('/') }}images/check-mark.svg" alt="" width="44" height="38"></div>
          <div class="item-title">THANK YOU</div>
          <div class="item-text">Welcome to the Cultivist community!<br>Check your email for your membership confirmation.</div>
          <div class="item-btn"><a href="https://ww2.thecultivist.com/" class="btn btn-dark w-210">BACK TO HOMEPAGE</a></div>
        </div>
      </section>
    </main>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('/') }}js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

  </body>
</html>