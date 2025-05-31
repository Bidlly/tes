let cart = []; // Keranjang disini

// --- Fungsi Tambahkan ke Keranjang ---
function addToCart(nama, harga, gambar) {
  const produk = { nama, harga, gambar, qty: 1 };

  // Ambil cart dari LocalStorage kalau ada
  cart = JSON.parse(localStorage.getItem('cart')) || [];

  // Cek apakah produk sudah ada di cart
  const index = cart.findIndex(item => item.nama === produk.nama);
  if (index !== -1) {
    cart[index].qty += 1; // Kalau sudah ada, tambah qty
  } else {
    cart.push(produk); // Kalau belum, tambahkan produk baru
  }

  // Simpan kembali ke LocalStorage
  localStorage.setItem('cart', JSON.stringify(cart));

  renderCart(); // Panggil renderCart untuk memperbarui tampilan keranjang
  showToast(`${nama} berhasil ditambahkan ke keranjang! 🛒`);
}

function tambahKeKeranjang(button, produk) {
  button.innerHTML = "Loading...";
  button.disabled = true;
  setTimeout(() => {
    addToCart(produk.nama, produk.harga, produk.gambar); // Panggil fungsi addToCart
    button.innerHTML = "Tambah ke Keranjang";
    button.disabled = false;
  }, 1000);
}

// --- Fungsi Render Cart ---
function renderCart() {
  const cartItems = document.getElementById('cart-items');
  const cartTotal = document.getElementById('cart-total');

  // Ambil cart dari LocalStorage
  cart = JSON.parse(localStorage.getItem('cart')) || [];

  cartItems.innerHTML = '';

  let total = 0;

  cart.forEach((item, index) => {
    const hargaAngka = parseInt(item.harga.replace(/[^\d]/g, ''));
    total += hargaAngka * item.qty;

    cartItems.innerHTML += `
      <div class="flex justify-between items-center bg-gray-50 p-3 rounded-md">
        <div>
          <p class="font-semibold">${item.nama}</p>
          <p class="text-sm text-gray-600">Qty: ${item.qty}</p>
        </div>
        <div class="text-right">
          <p class="text-blue-400 font-bold">Rp ${hargaAngka.toLocaleString()}</p>
          <button onclick="hapusDariCart(${index})" class="text-red-400 text-sm mt-1 hover:text-red-600">Hapus</button>
        </div>
      </div>
    `;
  });

  cartTotal.innerText = `Rp ${total.toLocaleString()}`;
}

// --- Fungsi Hapus Produk dari Cart ---
function hapusDariCart(index) {
  cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  renderCart();
}

// --- Fungsi Checkout ---
function checkout() {
  if (cart.length === 0) {
    showToast('Keranjang masih kosong!');
    return;
  }
  
  const checkoutButton = document.querySelector('#cart-sidebar button');
  checkoutButton.innerText = "Processing...";
  checkoutButton.disabled = true;

  setTimeout(() => {
    showModal(); // Tampilkan modal checkout

    checkoutButton.innerText = "Checkout";
    checkoutButton.disabled = false;
  }, 1000);
}

// --- Fungsi Tampilkan Modal Checkout ---
function showModal() {
  const modal = document.getElementById('checkout-modal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  
  setTimeout(() => {
    modal.classList.remove('opacity-0');
    modal.classList.add('opacity-100');
  }, 10);
}

// --- Fungsi Tutup Modal Checkout dan Kosongkan Cart ---
function closeModal() {
  const modal = document.getElementById('checkout-modal');

  modal.classList.remove('opacity-100');
  modal.classList.add('opacity-0');

  setTimeout(() => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');

    cart = [];
    localStorage.removeItem('cart');
    renderCart();
    toggleCart();
  }, 300);
}

// --- Fungsi Toggle Cart Sidebar ---
function toggleCart() {
  const cartSidebar = document.getElementById('cart-sidebar');
  if (cartSidebar.classList.contains('translate-x-0')) {
    cartSidebar.classList.remove('translate-x-0');
    cartSidebar.classList.add('translate-x-full');
  } else {
    cartSidebar.classList.remove('translate-x-full');
    cartSidebar.classList.add('translate-x-0');
  }
}

// --- Fungsi Toast Notification ---
function showToast(message) {
  let toast = document.createElement('div');
  toast.className = 'toast';
  toast.innerText = message;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.classList.add('show');
  }, 100);

  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => {
      toast.remove();
    }, 500);
  }, 3000);
}

   // Render awal
   renderProduk();

   // Event listener filter
   document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('bg-blue-400', 'text-white'));
      this.classList.add('bg-blue-400', 'text-white');
      renderProduk(this.dataset.kategori);
    });
  });

  let loadingInterval;

function searchProduk() {
  const query = document.getElementById('search-input').value.toLowerCase();
  const produkGrid = document.getElementById('produk-grid');
  const searchStatus = document.getElementById('search-status');

  produkGrid.innerHTML = '';
  searchStatus.classList.remove('hidden');
  searchStatus.innerText = 'Mencari';
  
  // Mulai animasi titik-titik
  let dotCount = 0;
  clearInterval(loadingInterval); // Hapus animasi sebelumnya biar gak numpuk
  loadingInterval = setInterval(() => {
    dotCount = (dotCount + 1) % 4; // 0, 1, 2, 3 lalu balik ke 0
    searchStatus.innerText = 'Mencari' + '.'.repeat(dotCount);
  }, 400); // Update setiap 400ms

  setTimeout(() => { // Simulasi loading sebentar
    const filtered = produkData.filter(p => 
      p.nama.toLowerCase().includes(query) || 
      p.kategori.toLowerCase().includes(query)
    );

    clearInterval(loadingInterval); // Stop animasi titik-titik

    produkGrid.innerHTML = '';

    if (filtered.length === 0) {
      searchStatus.innerText = 'Produk tidak ditemukan 😢';
    } else {
      searchStatus.classList.add('hidden'); // Kalau ada hasil, sembunyikan teks
      filtered.forEach((produk, index) => {
        produkGrid.innerHTML += `
          <div class="border rounded-xl shadow-md p-4 text-center transform transition-transform duration-300 hover:scale-105 hover:-translate-y-2 hover:shadow-2xl" data-aos="zoom-in" data-aos-delay="${index * 100}" data-aos-duration="600">
            <img src="${produk.gambar}" alt="Produk" class="w-full h-48 object-cover rounded-md mb-4 transition-transform duration-300 hover:scale-105 hover:shadow-lg">
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
      AOS.refresh(); // Refresh animasi
    }
  }, 800); // Delay cari 800ms, sekalian kasih waktu animasi berjalan
}
  
// --- Format Rupiah Helper ---
function formatRupiah(angka) {
  return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// --- Saat Halaman Dibuka, Tampilkan Isi Keranjang ---
document.addEventListener('DOMContentLoaded', () => {
  renderCart();
});

function toggleWishlist(namaProduk, element) {
  element.classList.toggle('text-red-500');
  showToast(`Produk "${namaProduk}" ditambahkan ke Wishlist! ❤️`);
}

AOS.init({
  once: true, // Animasi hanya sekali (tidak ulang-ulang pas scroll bolak-balik)
  easing: 'ease-out-cubic', // Biar animasi lebih smooth
});

let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

function toggleWishlist(namaProduk, button) {
  const index = wishlist.indexOf(namaProduk);
  if (index > -1) {
    wishlist.splice(index, 1);
    button.classList.remove('text-red-500');
    button.classList.add('text-red-400');
  } else {
    wishlist.push(namaProduk);
    button.classList.remove('text-red-400');
    button.classList.add('text-red-500');
  }
  localStorage.setItem('wishlist', JSON.stringify(wishlist));
}

function openWishlist() {
  const modal = document.getElementById('wishlist-modal');
  const wishlistItems = document.getElementById('wishlist-items');
  wishlistItems.innerHTML = '';

  if (wishlist.length === 0) {
    wishlistItems.innerHTML = '<p class="text-gray-400">Wishlist kosong 😢</p>';
  } else {
    wishlist.forEach(nama => {
      wishlistItems.innerHTML += `
        <div class="flex justify-between items-center border-b pb-2">
          <span class="text-left">${nama}</span>
          <button onclick="hapusWishlist('${nama}')" class="text-red-400 hover:text-red-600">&times;</button>
        </div>
      `;
    });
  }

  modal.classList.remove('hidden');
  setTimeout(() => {
    modal.classList.add('opacity-100');
    modal.classList.remove('opacity-0');
  }, 10);
}

function closeWishlist() {
  const modal = document.getElementById('wishlist-modal');
  modal.classList.remove('opacity-100');
  modal.classList.add('opacity-0');
  setTimeout(() => {
    modal.classList.add('hidden');
  }, 300);
}

function hapusWishlist(namaProduk) {
  wishlist = wishlist.filter(nama => nama !== namaProduk);
  localStorage.setItem('wishlist', JSON.stringify(wishlist));
  openWishlist(); // Refresh isi wishlist
}

function openWishlist() {
  const wishlistModal = document.getElementById('wishlist-modal');
  wishlistModal.classList.remove('hidden');
  setTimeout(() => {
    wishlistModal.classList.remove('opacity-0');
    wishlistModal.classList.add('opacity-100');
    wishlistModal.classList.add('flex');
  }, 10);
}

function closeWishlist() {
  const wishlistModal = document.getElementById('wishlist-modal');
  wishlistModal.classList.add('opacity-0');
  wishlistModal.classList.remove('opacity-100');
  setTimeout(() => {
    wishlistModal.classList.add('hidden');
    wishlistModal.classList.remove('flex');
  }, 300);
}