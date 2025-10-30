<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ana Sayfa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background: #ececec;">

  {{-- Navbar --}}
  @include('components.navbar')

  {{-- Öğrenci Arama --}}
  <div class="col-12 d-flex justify-content-center align-items-center mb-4" style="margin-top: 100px;">
    <div class="col-11">
      <h1>Hoşgeldiniz {{ session('gorevli_ka') }}</h1>
    </div>
  </div>
  <div class="col-12 d-flex justify-content-center align-items-center mb-4">
    <div class="col-11 bg-white rounded-5 p-4">
      <div class="col-12">
        {{ $adet }} adet öğrenci, {{ $toplam_bakiye }} Tl bakiye bulunmaktadır.
      </div>
      <div class="col-12 mt-3 d-flex flex-wrap gap-2">
        <a href="/alisveris" class="btn btn-primary">
          Alışveriş
        </a>
        <a href="/ogrenciler" class="btn btn-success">
          Öğrenciler
        </a>
        <a href="/urunler" class="btn btn-danger">
          Ürünler
        </a>
        <a href="/kategoriler" class="btn btn-warning">
          Kategoriler
        </a>
        <a href="/satis_gecmisi" class="btn btn-info">
          Satış Geçmişi
        </a>
        <a href="/bakiye_gecmisi" class="btn btn-secondary">
          Bakiye Yükleme Geçmişi
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script src="{{ asset('assets/js/giris.js') }}"></script>
</body>

</html>