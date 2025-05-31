<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keranjang Belanja</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>MarketplaceKu</h1>
    <nav>
      <a href="index.html">Home</a>
      <a href="produk.html">Produk</a>
      <a href="cart.html">Keranjang</a>
    </nav>
  </header>

  <section class="cart">
    <h2>Keranjang Belanja</h2>
    <div id="cart-container"></div>
  </section>

  <footer>
    <p>&copy; 2025 MarketplaceKu. All rights reserved.</p>
  </footer>

  <script>
    function loadCart() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const container = document.getElementById('cart-container');
      container.innerHTML = '';

      if (cart.length === 0) {
        container.innerHTML = '<p>Keranjang kosong!</p>';
        return;
      }

      cart.forEach(item => {
        const div = document.createElement('div');
        div.className = 'produk-item';
        div.innerHTML = `
          <img src="${item.gambar}" alt="${item.nama}">
          <h3>${item.nama}</h3>
          <p>${item.harga}</p>
        `;
        container.appendChild(div);
      });
    }

    document.addEventListener('DOMContentLoaded', loadCart);
  </script>
</body>
</html>
