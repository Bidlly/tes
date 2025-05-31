<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Checkout MarketplaceKu</h1>
    <nav>
      <a href="index.html">Home</a>
      <a href="produk.html">Produk</a>
      <a href="cart.html">Keranjang</a>
    </nav>
  </header>

  <section class="checkout">
    <h2>Checkout</h2>
    <div id="checkout-container"></div>
    <button id="confirm-checkout">Konfirmasi Pembelian</button>
  </section>

  <footer>
    <p>&copy; 2025 MarketplaceKu. All rights reserved.</p>
  </footer>

  <script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const container = document.getElementById('checkout-container');
    let total = 0;

    if (cart.length === 0) {
      container.innerHTML = '<p>Keranjang kosong!</p>';
    } else {
      cart.forEach(item => {
        const div = document.createElement('div');
        div.className = 'produk-item';
        div.innerHTML = `
          <img src="${item.gambar}" alt="${item.nama}">
          <h3>${item.nama}</h3>
          <p>${item.harga}</p>
        `;
        container.appendChild(div);

        const harga = parseInt(item.harga.replace(/[^\d]/g, ''));
        total += harga;
      });

      const totalDiv = document.createElement('div');
      totalDiv.innerHTML = `<h3>Total Bayar: Rp ${total.toLocaleString()}</h3>`;
      container.appendChild(totalDiv);
    }

    document.getElementById('confirm-checkout').addEventListener('click', function() {
      if (cart.length === 0) {
        alert('Keranjang kosong!');
        return;
      }

      alert('Pembayaran berhasil! Terima kasih!');
      localStorage.removeItem('cart');
      window.location.href = 'index.html';
    });
  </script>
</body>
</html>
