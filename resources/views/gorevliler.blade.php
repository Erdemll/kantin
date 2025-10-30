<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Öğrenciler</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background: #ececec;">

  {{-- Navbar --}}
  @include('components.navbar')

  {{-- Öğrenciler --}}
  <div class="col-12 d-flex justify-content-center align-items-center mb-4" style="margin-top: 100px;">
    <div class="col-11">
      <h1>Görevliler</h1>
    </div>
  </div>
  <div class="col-12 d-flex justify-content-center align-items-center mb-4">
    <div class="col-11 bg-white rounded-5 p-4">
      <div class="col-12">
        @if(session()->has('create') && session('create') != 'ok')
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Aynı numara değerine sahip öğrenci ekleyemezsiniz, lütfen kontrol ediniz.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @elseif(session()->has('create') && session('create') == 'ok')
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            Öğrenci başarıyla eklendi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        @if(session()->has('update') && session('update') == true)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            Öğrenci başarıyla güncellendi.
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
            Öğrenci başarıyla silindi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @elseif(session()->has('delete') && session('delete') == false)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <div class="col-12 d-flex justify-content-end">
          <button type="button" data-bs-toggle="modal" data-bs-target="#ogrenci_ekleme_modal"
            class="btn btn-primary">Öğrenci Ekle</button>
          <button type="button" data-bs-toggle="modal" data-bs-target="#exel_ekleme_modal"
            class="btn btn-success ms-2">Exel'den Aktar</button>
        </div>
        <div style="overflow: auto;" class="col-12">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Kullanıcı Adı</th>
                <th scope="col">İşlemler</th>
              </tr>
            </thead>
            <tbody>
              @foreach($gorevliler as $gorevli)
                <tr>
                  <th scope="row">{{ $gorevli->id }}</th>
                  <td>{{ $gorevli->kullanici_adi }}</td>
                  <td><button type="button" data-bs-toggle="modal" data-bs-target="#ogrenci_duzenleme_modal"
                      class="btn btn-warning"
                      onclick="duzenleme_modal('{{ $ogrenci->id }}', '{{ $ogrenci->adsoyad }}')">Düzenle</button>
                    <a href="/sifre_sifirla/{{ $gorevli->id }}"></a>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#ogrenci_silme_modal"
                      class="btn btn-danger" onclick="silme_modal('{{ $ogrenci->id }}')">Sil</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ogrenci_ekleme_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalLabel">Öğrenci Ekle</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/ogrenci_ekle" method="post">
          @csrf
          <div class="modal-body">
            <label for="id">Öğrenci Numarası</label>
            <input class="form-control mb-3 mt-2" type="text" name="id" id="id">
            <label for="adsoyad">Ad Soyad</label>
            <input class="form-control mt-2" type="text" name="adsoyad" id="adsoyad">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            <input type="submit" class="btn btn-success" value="Kaydet">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="exel_ekleme_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalLabel">Exel Dosyası Seç</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/exel_exle" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="excel_file" class="form-label">Exel dosyasını seçiniz.</label>
              <input class="form-control" type="file" id="excel_file" name="excel_file"
                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            <input type="submit" class="btn btn-success" value="Kaydet">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ogrenci_silme_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalLabel">Öğrenci Sil</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/ogrenci_sil" method="post">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="id" id="silme_id">
            Öğrenciyi silmek istediğinize emin misiniz?<br>"Bu işlem geri alınamaz."
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">İptal</button>
            <input type="submit" class="btn btn-danger" value="Sil">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--  <div class="modal fade" id="exel_ekleme_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="ModalLabel">Exel'den Öğrenci Ekle</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="/exel_ogrenci_ekle" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="formFile" class="form-label">Exel dosyasını seçiniz.</label>
                <input class="form-control" type="file" id="formFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="exel">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
              <input type="submit" class="btn btn-success" value="Kaydet">
            </div>
          </form>
        </div>
      </div>
    </div> -->


  <div class="modal fade" id="ogrenci_duzenleme_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalLabel">Öğrenci Düzenle</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/ogrenci_duzenle" method="post">
          @csrf
          <div class="modal-body">
            <div>
              <input type="hidden" name="id" id="duzenleme_id">
              <label for="duzenlemeadsoyad">Ad Soyad</label>
              <input class="form-control mt-2" type="text" name="adsoyad" id="duzenleme_adsoyad">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            <input type="submit" class="btn btn-success" value="Kaydet">
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    var duzenleme_id = document.getElementById('duzenleme_id');
    var duzenleme_adsoyad = document.getElementById('duzenleme_adsoyad');

    var silme_id = document.getElementById('silme_id');

    function duzenleme_modal(id, adsoyad) {
      console.log(duzenleme_id);
      console.log(duzenleme_adsoyad);
      duzenleme_id.value = id;
      duzenleme_adsoyad.value = adsoyad;
    }

    function silme_modal(id) {
      silme_id.value = id;
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script src="{{ asset('assets/js/giris.js') }}"></script>
</body>

</html>