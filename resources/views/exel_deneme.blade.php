<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>JSON Tablo</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #f5f5f5;
    }
    textarea {
      width: 100%;
      height: 120px;
    }
    button {
      margin-top: 10px;
      padding: 8px 16px;
    }
  </style>
</head>
<body>
  <h3>JSON Veriyi Gir</h3>
  <textarea id="jsonInput" placeholder="JSON verinizi buraya yapıştırın"></textarea>
  <br>
  <button id="loadJson">Tabloya Dönüştür</button>

  <div id="tableContainer"></div>

  <script>
    document.getElementById("loadJson").addEventListener("click", function() {
      const jsonText = document.getElementById("jsonInput").value.trim();
      if (!jsonText) {
        alert("Lütfen JSON verisini girin!");
        return;
      }

      let data;
      try {
        data = JSON.parse(jsonText);
      } catch (e) {
        alert("Geçersiz JSON formatı!");
        return;
      }

      renderTable(data);
    });

    function renderTable(data) {
      const container = document.getElementById("tableContainer");
      container.innerHTML = "";

      const table = document.createElement("table");
      const thead = document.createElement("thead");
      const tbody = document.createElement("tbody");

      // sütun başlıkları
      const headers = Object.keys(data[0]);

      let headerRow = "<tr><th><input type='checkbox' id='selectAll'></th>";
      headers.forEach(h => {
        headerRow += `<th>${h}</th>`;
      });
      headerRow += "</tr>";
      thead.innerHTML = headerRow;

      // satırları oluştur
      data.forEach((row, index) => {
        let rowHtml = `<tr>
          <td><input type='checkbox' class='rowCheck' data-index='${index}'></td>`;
        headers.forEach(h => {
          rowHtml += `<td>${row[h] ?? ""}</td>`;
        });
        rowHtml += "</tr>";
        tbody.innerHTML += rowHtml;
      });

      table.appendChild(thead);
      table.appendChild(tbody);
      container.appendChild(table);

      // "Hepsini Seç" özelliği
      document.getElementById("selectAll").addEventListener("change", function() {
        document.querySelectorAll(".rowCheck").forEach(cb => cb.checked = this.checked);
      });

      // Gönder butonu
      const sendButton = document.createElement("button");
      sendButton.textContent = "Seçilenleri Gönder";
      sendButton.addEventListener("click", () => sendSelected(data));
      container.appendChild(sendButton);
    }

    function sendSelected(data) {
      const selectedIndexes = Array.from(document.querySelectorAll(".rowCheck:checked"))
        .map(cb => parseInt(cb.getAttribute("data-index")));
        console.log(selectedIndexes);
      if (selectedIndexes.length === 0) {
        alert("Hiç satır seçilmedi!");
        return;
      }

      const selectedData = selectedIndexes.map(i => data[i]);
      console.log(selectedData);

      fetch("/exel_ekle", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({ ogrenciler: selectedData })
      })
      .then(res => res.json())
      .then(resp => alert("Gönderildi: " + JSON.stringify(resp)))
      .catch(err => alert("Hata: " + err));
    }
  </script>
</body>
</html>
