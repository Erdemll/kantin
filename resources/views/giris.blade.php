<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Çamlık Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class="d-flex justify-content-center align-items-center bg-light">
    <div class="col-8 col-md-6 col-lg-4 bg-white shadow-lg p-3 mb-5 bg-body-tertiary rounded-5 mt-5 p-5">
        <h1 class="mb-5">Çamlık Kantin</h1>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('giris_yap') }}" method="post">
          @csrf
          <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
          <input type="text" id="kullanici_adi" name="kullanici_adi" class="form-control">

          <label for="sifre" class="form-label mt-3">Şifre</label>
          <input type="password" id="sifre" name="sifre" class="form-control" aria-describedby="passwordHelpBlock">
          <div id="passwordHelpBlock" class="form-text">
              Şifrenizi hatırlamıyorsanız proje yöneticisi ile görüşünüz.
          </div>

          <input class="btn btn-success mt-5" type="submit" value="Giriş Yap">
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/giris.js') }}"></script>
  </body>
</html>