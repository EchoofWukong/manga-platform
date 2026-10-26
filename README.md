# 📖 Manga Platformu (Geliştirme Aşamasında 🚧)

Laravel kullanılarak hobi amaçlı kişisel bir proje olarak geliştirilen manga ve webtoon içerik platformudur. Proje henüz tamamlanmamıştır, aktif kullanımda değildir ve yeni özellikler eklenerek geliştirilmeye devam edilmektedir.

## 🌟 Planlanan / Mevcut Özellikler

- Dinamik manga ve bölüm (chapter) ekleme/yönetme.
- Okuyucular için sade ve göz yormayan okuma ekranı.
- Temel admin paneli üzerinden içerik kontrolü.
- Kategori ve tür filtreleme altyapısı (Geliştirme aşamasında).

## 🛠️ Kullanılan Teknolojiler

- **Backend:** Laravel (PHP 8.x)
- **Frontend:** Laravel Blade, CSS, JavaScript
- **Veritabanı:** PostgreSQL / MySQL

## ⚙️ Kurulum ve Çalıştırma (Yerel Ortam)

Projeyi bilgisayarınızda incelemek veya geliştirmeye devam etmek için aşağıdaki komutları tek seferde kopyalayıp sırayla terminalinizde çalıştırın:

```bash
git clone [https://github.com/EchoofWukong/manga-platform.git](https://github.com/EchoofWukong/manga-platform.git)
cd manga-platform
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
