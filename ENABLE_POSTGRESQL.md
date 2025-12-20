# 🔧 Enable PostgreSQL Extension di PHP

## Status: PHP PostgreSQL Extension Belum Enabled

File `php.ini` sudah dibuka di Notepad.

---

## ✅ Langkah-langkah:

### 1. Di Notepad yang sudah terbuka (php.ini):
   
   **Cari baris ini** (gunakan Ctrl+F di Notepad):
   ```
   ;extension=pdo_pgsql
   ```
   
   **Hapus titik koma (;) di depannya, menjadi:**
   ```
   extension=pdo_pgsql
   ```

### 2. Cari baris kedua:
   ```
   ;extension=pgsql
   ```
   
   **Hapus titik koma (;) di depannya, menjadi:**
   ```
   extension=pgsql
   ```

### 3. Save file (Ctrl+S) dan tutup Notepad

### 4. Restart PHP/Apache (jika menggunakan XAMPP):
   - Buka XAMPP Control Panel
   - Stop Apache
   - Start Apache lagi

---

## 🔄 Alternative: Edit via PowerShell (Automated)

Jika ingin otomatis, copy-paste command ini di PowerShell:

```powershell
# Backup php.ini
Copy-Item C:\xampp\php\php.ini C:\xampp\php\php.ini.backup

# Enable PostgreSQL extensions
$phpIni = Get-Content C:\xampp\php\php.ini
$phpIni = $phpIni -replace ';extension=pdo_pgsql', 'extension=pdo_pgsql'
$phpIni = $phpIni -replace ';extension=pgsql', 'extension=pgsql'
$phpIni | Set-Content C:\xampp\php\php.ini

Write-Host "PostgreSQL extensions enabled!" -ForegroundColor Green
Write-Host "Please restart Apache/PHP-FPM if running" -ForegroundColor Yellow
```

---

## ✅ Verify After Enabling

Setelah enable dan restart, jalankan:

```bash
cd c:\Project\bimasada-webapp\bimasada-invoice-system
php -m | Select-String -Pattern "pgsql"
```

**Expected output:**
```
pdo_pgsql
pgsql
```

---

## 🚀 Then Continue Phase 2

Setelah PostgreSQL extension enabled:

```bash
php artisan db:show
# Should connect to Supabase successfully!

# Then run migrations
php artisan migrate
```

---

**Notepad sudah terbuka. Edit php.ini sekarang!** 📝
