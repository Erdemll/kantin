<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Alışveriş</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background: #ececec;">

  {{-- Navbar --}}
  @include('components.navbar')

  {{-- Öğrenci Arama --}}
  <div class="col-12 d-flex justify-content-center align-items-center mb-4" style="margin-top: 100px;">
    <div class="col-11">
      <h1>Alışveriş</h1>
    </div>
  </div>
  <div class="col-12 d-flex justify-content-center align-items-center mb-4">
    <div class="col-11 bg-white rounded-5 p-4">
      <div class="col-12 d-flex justify-content-between">
        <div class="col-6 col-md-4">
          <div class="input-group">
            <input type="number" class="form-control" id="ogrenci_id" placeholder="Numara"
              aria-label="Öğrenci numarasını giriniz." aria-describedby="button-addon2">
            <button class="btn btn-outline-primary" type="button" id="button-addon2"
              onclick="ogrenci_getir()">Ara</button>
          </div>
        </div>
        <div class="col-4 d-flex justify-content-end">
          <div class="input-group">
            <input type="number" class="form-control" id="bakiye" placeholder="Yükleme Tutarı"
              aria-describedby="yukleme_button">
            <button class="btn btn-outline-success" type="button" id="yukleme_button" onclick="bakiye_yukle()"
              disabled>Yükle</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Bilgi --}}
  <div class="col-12 d-flex justify-content-center align-items-center">
    <div class="col-11 d-flex flex-wrap justify-content-between bg-white rounded-5 p-4 mb-5">

      <div class="col-12 d-flex flex-wrap justify-content-between">
        <div class="col-12">
          <h2>Öğrenci Bilgileri</h2>
        </div>
        <div class="col-12 col-md-8 fs-4 mt-3">
          Ad Soyad: <span id="ogrenci_adsoyad"></span>
        </div>
        <div class="col-12 col-md-4 fs-4 mt-3">
          Bakiye: <span id="ogrenci_bakiye"></span>TL
        </div>
      </div>

      <div class="col-12 col-md-7 mt-5">
        <h2>Ürünler</h2>
        @foreach ($kategoriler as $kategori)
          <div class="mt-4">
            <h3>{{ $kategori->ad }}</h3>
          </div>
          <div id="{{ strtolower($kategori->isim) }}" class="col-12 d-flex flex-wrap">
            @foreach ($kategori->urunler as $urun)
             @if($urun->mevcut == 1)
              <button onclick="urun_ekle('{{ json_encode($urun) }}')" class="btn btn-primary m-2">
                <p>{{ $urun->ad }}</p> <span>{{ $urun->fiyat }}TL</span>
              </button>
             @endif
            @endforeach
          </div>
        @endforeach
      </div>

      <div style="position: relative;" class="col-12 col-md-4 mt-5">
        <div style="position: sticky; top: 80px;">
          <div class="col">
            <h2>Sepet</h2>
          </div>
          <div class="col d-flex justify-content-end mb-3"><button onclick="sepet_temizle()"
              class="btn btn-danger">Sepeti Temizle</button></div>
          <div id="sepet" class="col-12 bg-secondary shadow-sm p-3 mb-5 bg-body-tertiary rounded"></div>
          <div class="col-12 fs-3">Total: <span id="sepet_tutari">0</span>TL</div>
          <div class="col-12 d-flex justify-content-between align-items-end mt-3">
            <div class="col-5">
              <label class="fs-5" for="vekalet_id">Vekalet No</label>
              <input class="form-control" type="text" name="" id="vekalet_id">
            </div>
            <div class="col-5"><button onclick="satis_yap()" class="btn btn-success">Satış Yap</button></div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{ asset('assets/js/giris.js') }}"></script>

  <script>
    var urunler = [];
    var sepet = document.getElementById("sepet");
    var sepet_satir = 0;
    var sepet_tutari = 0;

    function ogrenci_getir() {
      let id = document.getElementById("ogrenci_id").value;
      if (id === "" || isNaN(id)) {
        alert("Lütfen öğrenci numarasını giriniz.");
        return;
      }
      $.ajax({
        url: '/ogrenci_getir',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: {
          numara: id,
        },
        dataType: 'json',
        success: function (data) {
          if (data.success) {
            $('#ogrenci_adsoyad').text(data.ad_soyad);
            $('#ogrenci_bakiye').text(data.bakiye);
            document.getElementById("yukleme_button").disabled = false;
          }
          else {
            alert(data.message);
            return;
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Hatası:', status, error);
        }
      });
    }

    function bakiye_yukle() {
      let id = document.getElementById("ogrenci_id").value;
      if (id === "") {
        alert("Lütfen öğrenci numarasını giriniz.");
        return;
      }
      let bakiye = document.getElementById("bakiye").value;
      if (bakiye === "" || isNaN(bakiye) || bakiye <= 0) {
        alert("Lütfen geçerli bir bakiye tutarı giriniz.");
        return;
      }
      $.ajax({
        url: '/bakiye_yukle',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: {
          ogrenci_id: id,
          bakiye: bakiye,
        },
        dataType: 'json',
        success: function (data) {
          if (data.bakiye_yukleme) {
            $('#ogrenci_bakiye').text(data.yeni_bakiye);
            document.getElementById("bakiye").value = "";
            alert("Bakiye başarıyla yüklendi.");
            return;
          }
          else {
            alert(data.error);
            return;
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Hatası:', status, error);
        }
      });
    }

    function urun_ekle(urun) {
      urun = JSON.parse(urun);
      urunler.push(urun.id);
      sepet_tutari += urun.fiyat;
      document.getElementById("sepet_tutari").innerText = sepet_tutari;
      let div = document.createElement("div");
      let div_id = "satir_" + (sepet_satir++);
      div.id = div_id;
      div.className = "col-12 d-flex justify-content-between align-items_center my-3";
      div.innerHTML = `<div>${urun.ad}</div> <div>${urun.fiyat}TL <button class="btn btn-danger ms-2" onclick="urun_sil(${urun.id}, ${div_id}, ${urun.fiyat});">İptal</button></div>`;
      sepet.appendChild(div);
    }

    function urun_sil(id, urunDiv, fiyat) {
      const index = urunler.indexOf(id);
      if (index !== -1) {
        urunler.splice(index, 1);
      }
      sepet_tutari -= fiyat;
      document.getElementById("sepet_tutari").innerText = sepet_tutari;
      if (urunDiv) {
        urunDiv.remove();
      }
    }

    function sepet_temizle() {
      urunler = [];
      sepet.innerHTML = "";
      sepet_tutari = 0;
      document.getElementById("sepet_tutari").innerText = sepet_tutari;
    }

    function satis_yap() {
      let ogrenci_id = document.getElementById("ogrenci_id").value;
      let vekalet_id = document.getElementById("vekalet_id").value;

      if (urunler.length === 0) {
        alert("Lütfen sepete ürün ekleyiniz.");
        return;
      }

      $.ajax({
        url: '/satis_yap',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: {
          ogrenci_id: ogrenci_id,
          vekalet_id: vekalet_id,
          urunler: urunler,
        },
        dataType: 'json',
        success: function (data) {
          if (data.satis) {
            alert("Satış başarıyla gerçekleştirildi.");
            sepet_temizle();
            $('#ogrenci_bakiye').text(data.yeni_bakiye);
            return;
          }
          else {
            alert(data.error);
            return;
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Hatası:', status, error);
        }
      });
    }
  </script>
</body>

</html>