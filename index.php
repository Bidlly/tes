<!DOCTYPE html>
<html lang="id">
  
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marketplace Abid - Produk</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-white text-gray-800">
  <!-- Sidebar Cart -->
  <div id="cart-sidebar" class="fixed top-0 right-0 w-80 h-full bg-white shadow-lg p-6 transform translate-x-full transition-transform duration-300 z-50">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-blue-400">Keranjang</h2>
    <button onclick="toggleCart()" class="text-gray-600 text-2xl">&times;</button>
  </div>
  <div id="cart-items" class="space-y-4">

    <!-- Produk dalam keranjang akan muncul di sini -->
  </div>
  <div class="mt-6 border-t pt-4">
    <p class="font-bold text-lg">Total: <span id="cart-total" class="text-blue-400">Rp 0</span></p>
    <button onclick="checkout()" class="mt-4 bg-green-400 text-white w-full py-3 rounded-full hover:bg-green-500 transition">Checkout</button>
  </div>
</div>

<!-- Tombol Floating -->
<button onclick="toggleCart()" class="fixed bottom-5 right-5 bg-blue-400 hover:bg-blue-500 text-white px-6 py-3 rounded-full shadow-lg text-lg z-40">🛒 Lihat Keranjang</button>

  <!-- Navbar -->
  <?php
session_start();
?>

<nav class="flex justify-between items-center p-4 shadow-md">
    <div class="text-2xl font-bold text-blue-400">Marketplace</div>
    <ul class="flex gap-6 text-gray-700 font-semibold">
        <li><a href="index.php" class="hover:text-blue-400">Home</a></li>
        <li><a href="#produk" class="hover:text-blue-400">Produk</a></li>
        <li><a href="javascript:void(0)" onclick="openWishlist()" class="hover:text-red-400">❤️ Wishlist</a></li>

        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="#" class="hover:text-blue-400">Hi, <?= $_SESSION['username']; ?></a></li>
            <li><a href="logout.php" class="hover:text-red-400">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php" class="hover:text-blue-400">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>

  <!-- Filter Kategori -->
  <section class="p-6">
    <h2 class="text-2xl font-bold mb-4">Filter Kategori</h2>
    <div class="flex gap-4 flex-wrap">
      <button class="filter-btn bg-blue-400 text-white px-4 py-2 rounded-full" data-kategori="Semua">Semua</button>
      <button class="filter-btn bg-gray-200 px-4 py-2 rounded-full" data-kategori="Makanan">Makanan</button>
      <button class="filter-btn bg-gray-200 px-4 py-2 rounded-full" data-kategori="Minuman">Minuman</button>
      <button class="filter-btn bg-gray-200 px-4 py-2 rounded-full" data-kategori="Snack">Snack</button>
    </div>
    <div class="mt-6">
      <div class="relative w-full md:w-1/2">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
          🔍
        </span>
        <input id="search-input" type="text" placeholder="Cari produk..." 
          class="pl-10 w-full p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition" 
          oninput="searchProduk()">
    </div>
  </section>

  <section id="produk" class="p-8">
    <h2 class="text-3xl font-bold text-center mb-10">Produk</h2>
    <div id="search-status" class="text-center text-gray-400 mb-4 hidden"></div>
    <div id="produk-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 transition-all duration-500">
    </div>
  </section>

  <div id="toast" class="fixed top-6 right-6 bg-green-400 text-white px-4 py-2 rounded shadow-lg hidden z-50"></div>

  <div id="checkout-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden opacity-0 items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white p-8 rounded-lg shadow-xl text-center transform transition-transform duration-300 scale-90">
      <h2 class="text-2xl font-bold mb-4 text-green-500">Checkout Berhasil!</h2>
      <p class="text-gray-700 mb-6">Produk berhasil ditambahkan ke keranjang!</p>
      <button onclick="closeModal()" class="bg-blue-400 text-white px-6 py-2 rounded-full hover:bg-blue-500 transition">OK</button>
    </div>
  </div>
  

  <footer class="bg-gray-100 p-6 text-center mt-16">
    <p class="text-gray-500">&copy; 2025 Marketplace Abid. All rights reserved.</p>
  </footer>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();

    const produkData = [
      { nama: "Dimsum Spesial", harga: "Rp 25.000", gambar: "dimsum.jpg", kategori: "Makanan", rating: 5 },
      { nama: "Pizza Cheese", harga: "Rp 45.000", gambar: "pizza.jpg", kategori: "Makanan", rating: 4 },
      { nama: "Croissant", harga: "Rp 30.000", gambar: "crossaint.jpg", kategori: "Snack", rating: 4 },
      { nama: "Dimsum Ayam", harga: "Rp 28.000", gambar: "dimsum1.jpg", kategori: "Makanan", rating: 5 },
      { nama: "Es Teh Manis", harga: "Rp 8.000", gambar: "esteh.jpg", kategori: "Minuman", rating: 3 },
      { nama: "Coklat Bar", harga: "Rp 15.000", gambar: "coklat.jpg", kategori: "Snack", rating: 4 },
    ];

    const produkGrid = document.getElementById('produk-grid');

    function renderProduk(filterKategori = "Semua") {
      produkGrid.innerHTML = '';
      const filtered = produkData.filter(p => filterKategori === "Semua" || p.kategori === filterKategori);
      filtered.forEach((produk, index) => {
        produkGrid.innerHTML += `
          <div class="border rounded-xl shadow-md p-4 text-center transform transition-transform duration-300 hover:scale-105 hover:-translate-y-2 hover:shadow-2xl" data-aos="zoom-in" data-aos-delay="${index * 100}" data-aos-duration="600">>
            <img src="${produk.gambar}" alt="Produk" class="w-full h-48 object-cover rounded-md mb-4">
            <h3 class="text-xl font-semibold mb-2">${produk.nama}</h3>
            <p class="text-blue-400 font-bold mb-2">${produk.harga}</p>
            <div class="flex justify-center mb-4">
              ${'⭐'.repeat(produk.rating)}${'☆'.repeat(5 - produk.rating)}
            </div>
            <button onclick="toggleWishlist('${produk.nama}', this)" class="text-red-400 text-2xl mb-2">&#9829;</button><br>
            <button onclick='tambahKeKeranjang(this, ${JSON.stringify(produk)})' class="bg-blue-400 text-white px-4 py-2 rounded-full hover:bg-blue-500 transition">Tambah ke Keranjang</button>
          </div>
        `;
      });
    }

  </script>

<div id="wishlist-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden opacity-0 items-center justify-center z-50 transition-opacity duration-300">
  <div class="bg-white p-8 rounded-lg shadow-xl w-96 text-center transform transition-transform duration-300 scale-90">
    <h2 class="text-2xl font-bold mb-6 text-red-400">Wishlist Saya</h2>
    <div id="wishlist-items" class="space-y-4 mb-6">
      <!-- Produk Wishlist akan muncul di sini -->
    </div>
    <button onclick="closeWishlist()" class="bg-blue-400 text-white px-6 py-2 rounded-full hover:bg-blue-500 transition">Tutup</button>
  </div>
</div>
<script src="script.js"></script>

</body>
</html>
