# 🎮 Gamify - Platform Top Up Game Digital Terlengkap

<div align="center">

![Gamify Logo](https://img.shields.io/badge/Gamify-Top%20Up%20Platform-blue?style=for-the-badge&logo=gamepad)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

**Platform Digital Toko Game Online, Top Up Game, Voucher & Penjualan ID Gamer**

</div>

---

## 📋 Tentang Gamify

**Gamify** adalah platform digital lengkap yang memungkinkan gamer untuk membeli top up game, voucher, dan kartu virtual menggunakan mata uang lokal. Platform ini dirancang khusus untuk gamer profesional yang tidak memiliki kartu internasional namun tetap ingin menikmati berbagai layanan gaming digital.

### 🎯 Solusi untuk Gamer Indonesia
- 💳 **Tanpa Kartu Internasional** - Bayar dengan mata uang lokal
- 🚀 **Proses Cepat** - Top up instan dan otomatis
- 🛡️ **Aman & Terpercaya** - Transaksi terenkripsi
- 📱 **Mobile Friendly** - Akses mudah dari smartphone

---

## 🛍️ Kategori Produk

### 🎮 **KODE DIGITAL**
- 🎲 **Game Top Up** - Diamond Mobile Legends, UC PUBG, Robux, dll
- 🔑 **CD-Key Game** - Steam, Epic Games, Origin
- 💳 **Game Card** - PlayStation, Xbox, Nintendo
- 💰 **Payment Card** - PayPal, Perfect Money
- 📺 **VOD Gift Card** - Netflix, Disney+, Prime Video
- 🎵 **Music Platform** - Spotify, Apple Music, YouTube Premium
- 📱 **Mobile Prepaid** - Pulsa, Paket Data
- 🛒 **Shopping Gift Card** - Amazon, Google Play, iTunes

### ⚡ **TOP UP LANGSUNG**
- 🎮 **Game Top-Up Service** - Auto top up ke akun game
- 📱 **Mobile Game Direct** - Top up langsung ke ID game
- 📺 **Video on Demand** - Netflix, Viu, HOOQ
- 🎭 **Entertainment App** - TikTok Coin, Bigo Live
- 📹 **Livestreaming App** - YouTube Super Chat, Twitch

### 📶 **MOBILE RELOAD**
- 📱 **Prepaid Mobile Internet** - Paket data semua operator

### 🏪 **MARKETPLACE & ID GAMER**
- 🆔 **Jual Beli ID Game** - Akun game dengan level tinggi
- 💬 **Live Chat** - Negosiasi real-time dengan pembeli
- ⭐ **Rating & Review** - Sistem kepercayaan antar user

---

## ✨ Fitur Utama Platform

### 🎨 **Fitur Teknis**
- ✅ **Responsive Design** - Tampilan optimal di semua perangkat
- ✅ **Game Top-Up Service** - Layanan top up otomatis
- ✅ **Mobile Game Top-Up** - Top up game mobile populer
- ✅ **VOD App Top-Up** - Top up aplikasi streaming video
- ✅ **Entertainment App Top-Up** - Top up aplikasi hiburan
- ✅ **Game Voucher Management** - Manajemen voucher game
- ✅ **Gift Card Management** - PlayStation, iTunes, Google Play, Apple Card
- ✅ **GAMER ID Selling** - Platform jual beli ID game

### 👥 **Fitur Pengguna**
- ✅ **Posting ID Gamer** - Jual ID game dengan mudah
- ✅ **Live Chat Real-time** - Diskusi langsung dengan pembeli
- ✅ **Order Game Top up** - Beli top up dengan cepat
- ✅ **Order Gift Card** - Pesan gift card favorit
- ✅ **Order Voucher Code** - Dapatkan kode voucher instan

---

## 🛠️ Kebutuhan Server

### 🖥️ **Spesifikasi Minimum**

| Komponen | Versi Minimum | Status |
|----------|---------------|--------|
| 🐘 **PHP** | 8.2+ | ✅ Wajib |
| 🗄️ **MySQL** | 5.7+ | ✅ Wajib |
| 🗄️ **MariaDB** | 10.2+ | ✅ Alternatif |

### 📦 **PHP Extensions Required**

| Extension | Fungsi | Status |
|-----------|--------|--------|
| ✅ **BCMath** | Perhitungan matematika presisi tinggi | 🔴 Wajib |
| ✅ **Ctype** | Validasi karakter | 🔴 Wajib |
| ✅ **Fileinfo** | Deteksi tipe file | 🔴 Wajib |
| ✅ **JSON** | Parsing data JSON | 🔴 Wajib |
| ✅ **Mbstring** | Manipulasi string multibyte | 🔴 Wajib |
| ✅ **OpenSSL** | Enkripsi dan keamanan | 🔴 Wajib |
| ✅ **PDO** | Database abstraction | 🔴 Wajib |
| ✅ **PDO_MYSQL** | MySQL database driver | 🔴 Wajib |
| ✅ **Tokenizer** | Parsing token PHP | 🔴 Wajib |
| ✅ **XML** | XML processing | 🔴 Wajib |
| ✅ **CURL** | HTTP requests | 🔴 Wajib |
| ✅ **GD** | Image processing | 🔴 Wajib |
| ✅ **GMP** | GNU Multiple Precision | 🔴 Wajib |

---

## 🚀 Instalasi Cepat

### 1️⃣ **Clone Repository**
```bash
git clone https://github.com/JonathanZefanya/TopUp.git
cd TopUp
```

### 2️⃣ **Install Dependencies**
```bash
composer install
npm install
```

### 3️⃣ **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ **Database Setup**
```bash
# Import database
mysql -u username -p database_name < client_sanitized.sql

# Run migrations
php artisan migrate
```

### 5️⃣ **Configure API Keys**
Edit file `.env` dan masukkan API keys Anda:
```env
FLUTTERWAVE_PUBLIC_KEY=your_public_key
FLUTTERWAVE_SECRET_KEY=your_secret_key
FLUTTERWAVE_ENCRYPTION_KEY=your_encryption_key
```

### 6️⃣ **Start Development Server**
```bash
php artisan serve
```

---

## 🔐 Keamanan

⚠️ **PENTING**: Repository ini menggunakan file database yang telah di-sanitasi (`client_sanitized.sql`) untuk keamanan. Semua API keys telah diganti dengan placeholder.

### 🛡️ **Praktik Keamanan Terbaik**
- 🔒 Gunakan environment variables untuk API keys
- 🚫 Jangan commit file `.env` ke repository
- 🔄 Regenerate API keys secara berkala
- 📋 Gunakan sistem config Laravel untuk data sensitif

---

## 📸 Screenshot

### 🏠 **Halaman Utama**
![Homepage](https://via.placeholder.com/800x400/4f46e5/ffffff?text=Gamify+Homepage)

### 🎮 **Halaman Top Up Game**
![Game Top Up](https://via.placeholder.com/800x400/10b981/ffffff?text=Game+Top+Up+Page)

### 🛒 **Halaman Marketplace**
![Marketplace](https://via.placeholder.com/800x400/f59e0b/ffffff?text=Gamer+ID+Marketplace)

---

## 🤝 Kontribusi

Kami menyambut kontribusi dari developer Indonesia! 

### 📝 **Cara Berkontribusi**
1. Fork repository ini
2. Buat branch fitur (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -m 'Tambah fitur baru'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buat Pull Request

---

## 📞 Dukungan

Butuh bantuan? Hubungi kami!

- 📧 **Email**: support@gamify.com
- 💬 **Discord**: [Join Server](https://discord.gg/gamify)
- 📱 **WhatsApp**: +62 xxx-xxxx-xxxx
- 🐦 **Twitter**: [@GamifyID](https://twitter.com/gamifyid)

---

## 🌟 Roadmap

### 🎯 **Q4 2025**
- [ ] 🎮 Integrasi dengan 50+ game populer
- [ ] 💳 Payment gateway lokal (OVO, DANA, GoPay)
- [ ] 📱 Mobile app untuk Android & iOS

### 🎯 **Q1 2026**
- [ ] 🤖 AI-powered recommendation system
- [ ] 🏆 Sistem loyalty dan rewards
- [ ] 🌐 Multi-language support

---

## 📊 Statistik Project

![GitHub repo size](https://img.shields.io/github/repo-size/JonathanZefanya/TopUp)
![GitHub contributors](https://img.shields.io/github/contributors/JonathanZefanya/TopUp)
![GitHub last commit](https://img.shields.io/github/last-commit/JonathanZefanya/TopUp)
![GitHub issues](https://img.shields.io/github/issues/JonathanZefanya/TopUp)

---

## 📄 Lisensi

Project ini dilisensikan under MIT License - lihat file [LICENSE](LICENSE) untuk detail.

---

<div align="center">

**🎮 Dibuat dengan ❤️ untuk Gamer Indonesia 🇮🇩**

[![GitHub Stars](https://img.shields.io/github/stars/JonathanZefanya/TopUp?style=social)](https://github.com/JonathanZefanya/TopUp/stargazers)
[![GitHub Forks](https://img.shields.io/github/forks/JonathanZefanya/TopUp?style=social)](https://github.com/JonathanZefanya/TopUp/network/members)

**⭐ Jika project ini bermanfaat, jangan lupa kasih star ya! ⭐**

</div>
