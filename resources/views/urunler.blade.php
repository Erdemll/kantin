<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Ürünler</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background: #ececec;">

  {{-- Navbar --}}
  @include('components.navbar')

  {{-- Ürünler --}}
  <div class="col-12 d-flex justify-content-center align-items-center mb-4" style="margin-top: 100px;">
    <div class="col-11">
      <h1>Ürünler</h1>
    </div>
  </div>
  <div class="col-12 d-flex justify-content-center align-items-center mb-4">
    <div class="col-11 bg-white rounded-5 p-4">
      @if(session()->has('create') && session('create') != 'ok')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          İşlem şu anda gerçekleştirilemedi, lütfen tekrar deneyiniz.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @elseif(session()->has('create') && session('create') == 'ok')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Ürün başarıyla eklendi.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      @if(session()->has('update') && session('update') == true)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Ürün başarıyla güncellendi.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @elseif(session()->has('update') && session('update') == false)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      @if(session()->has('delete') && session('delete') == true)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Ürün başarıyla silindi.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @elseif(session()->has('delete') && session('delete') == false)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <div style="display: none;" id="mevcut_alert" class="alert alert-success alert-dismissible fade show" role="alert">
        Ürün mevcutluk durumu başarıyla güncellendi.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <div class="col-12 d-flex justify-content-end"><button class="btn btn-success" data-bs-toggle="modal"
          data-bs-target="#ekleme_modal">Ürün Ekle</button></div>
      <div style="overflow: auto;" class="col-12">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Ürün Adı</th>
              <th scope="col">Kategori</th>
              <th scope="col">Fiyat</th>
              <th scope="col">Var Mı?</th>
              <th scope="col">İşlemler</th>
            </tr>
          </thead>
          <tbody>
            @foreach($urunler as $urun)
              <tr>
                <td>{{ $urun->ad }}</td>
                <td>{{ $urun->kategori->ad }}</td>
                <td>{{ $urun->fiyat }}</td>
                @if($urun->mevcut == 1)
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="{{ $urun->id }}"
                        onclick="mevcutluk(this)" checked>
                      <label id="mevcut_label_{{ $urun->id }}" class="form-check-label" for="{{ $urun->id }}">
                        Var
                      </label>
                    </div>
                  </td>
                @else
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="{{ $urun->id }}"
                        onclick="mevcutluk(this)">
                      <label id="mevcut_label_{{ $urun->id }}" class="form-check-label" for="{{ $urun->id }}">
                        Yok
                      </label>
                    </div>
                  </td>
                @endif
                <td><button data-bs-toggle="modal" data-bs-target="#silme_modal" class="btn btn-danger"
                    onclick="silme_modal('{{ $urun->id }}')">Sil</button> <button class="btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#duzenleme_modal"
                    onclick="duzenleme_modal('{{ $urun->id }}','{{ $urun->ad }}','{{ $urun->fiyat }}', '{{ $urun->kategori->id }}', '{{ $urun->kategori->ad }}')">Düzenle</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ekleme_modal" tabindex="-1" aria-labelledby="eklemeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/urun_ekle" method="post">
          @csrf
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="eklemeModalLabel">Ürün Ekle</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label for="urun_ad">Ürün Adı</label>
            <input class="form-control mb-3" type="text" id="urun_ad" name="ad" required>
            <label for="urun_fiyat">Ürün Fiyatı</label>
            <input class="form-control mb-3" min="0" type="number" id="urun_fiyat" name="fiyat" required>
            <label for="kategori_sec">Kategori</label>
            <select id="kategori_sec" name="kategori_id" class="form-select" aria-label="Default select example">
              <option selected value="0">Kategori seçiniz.</option>
              @foreach($kategoriler as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->ad }}</option>
              @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            <button type="submit" class="btn btn-success">Kaydet</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="duzenleme_modal" tabindex="-1" aria-labelledby="duzenlemeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/urun_duzenle" method="post">
          @csrf
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="duzenlemeModalLabel">Ürün Düzenle</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="duzenleme_id">
            <label for="urun_ad">Ürün Adı</label>
            <input class="form-control mb-3" type="text" id="duzenleme_urun_ad" name="ad">
            <label for="urun_fiyat">Ürün Fiyatı</label>
            <input class="form-control mb-3" type="number" min="0" id="duzenleme_urun_fiyat" name="fiyat">
            <label for="kategori_sec">Kategori</label>
            <select id="kategori_sec" name="kategori_id" class="form-select" aria-label="Default select example">
              <option selected id="duzenleme_kategori"></option>
              @foreach($kategoriler as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->ad }}</option>
              @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            <button type="submit" class="btn btn-success">Kaydet</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="silme_modal" tabindex="-1" aria-labelledby="silmeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/urun_sil" method="post">
          @csrf
          <input type="hidden" name="id" id="silme_id">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="silmeModalLabel">Ürün Silme</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Bu ürünü silmek istediğinize emin misiniz?<br>"Bu işlem geri alınamaz."
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">İptal</button>
            <button type="submit" class="btn btn-danger">Sil</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script>
    var duzenleme_id = document.getElementById('duzenleme_id');
    var duzenleme_urun_ad = document.getElementById('duzenleme_urun_ad');
    var duzenleme_urun_fiyat = document.getElementById('duzenleme_urun_fiyat');
    var duzenleme_kategori = document.getElementById('duzenleme_kategori');
    var durum;
    var mevcut_alert = document.getElementById('mevcut_alert');

    var silme_id = document.getElementById('silme_id');

    function duzenleme_modal(id, ad, fiyat, kategori_id, kategori_ad) {
      duzenleme_id.value = id;
      duzenleme_urun_ad.value = ad;
      duzenleme_urun_fiyat.value = fiyat;
      duzenleme_kategori.value = kategori_id;
      duzenleme_kategori.innerHTML = kategori_ad;
    }

    function silme_modal(id) {
      silme_id.value = id;
    }

    function mevcutluk(cb) {
      let mevcut_label = document.getElementById('mevcut_label_' + cb.id);
      if (cb.checked)
        durum = 1;
      else
        durum = 0;
      $.ajax({
        url: '/mevcutluk_guncelle',
        type: 'POST',
        data: {
          id: cb.id,
          durum: durum
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          if (response.mevcut_update) {
            if (durum == 1)
              mevcut_label.innerHTML = 'Var';
            else
              mevcut_label.innerHTML = 'Yok';
          }
          else {
            alert(response.error);
            if (durum == 1) {
              cb.checked = false;
              mevcut_label.innerHTML = 'Yok';
            }
            else {
              cb.checked = true;
              mevcut_label.innerHTML = 'Var';
            }
          }
          mevcut_alert.style.display = 'block';
          setTimeout(() => {
            mevcut_alert.style.display = 'none';
          }, 1500);
        }
      });
    }
  </script>
</body>

</html>