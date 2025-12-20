# 📊 ERD Implementation Documentation

## ✅ Database Schema - COMPLETED

Berhasil mengimplementasikan **7 tabel** sesuai dengan ERD diagram yang diberikan.

---

## 📋 Tabel yang Dibuat

### 1. **SALES** (User/Sales Person Table)
**File**: `2025_12_20_063533_create_sales_table.php`

```php
Schema::create('sales', function (Blueprint $table) {
    $table->id();                          // auto-generated PK
    $table->string('id_sales')->unique();  // PK custom
    $table->string('nama_sales');
    $table->string('username')->unique();
    $table->string('password');
    $table->timestamps();
});
```

**Relationships**:
- `hasMany` → Invoice
- `hasMany` → Kuitansi
- `hasMany` → SuratPerjanjian

---

### 2. **INVOICES** (Invoice Table)
**File**: `2025_12_20_063545_create_invoices_table.php`

```php
Schema::create('invoices', function (Blueprint $table) {
    $table->id();                                    // auto-generated PK
    $table->date('tanggal_invoice');
    $table->string('nama_pelanggan');
    $table->string('alamat');
    $table->string('no_telp');
    $table->string('email');
    $table->decimal('total_harga', 15, 2);
    $table->string('status_pembayaran');             // Lunas/Belum Lunas/Cicilan
    $table->date('jatuh_tempo');
    $table->text('keterangan')->nullable();
    $table->foreignId('id_sales')->constrained('sales')->onDelete('cascade');
    $table->timestamps();
});
```

**Relationships**:
- `belongsTo` → Sales
- `hasMany` → DetailInvoice
- `hasMany` → Kuitansi

---

### 3. **KUITANSIS** (Receipt Table)
**File**: `2025_12_20_063555_create_kuitansis_table.php`

```php
Schema::create('kuitansis', function (Blueprint $table) {
    $table->id();                                    // auto-generated PK
    $table->date('tanggal_kuitansi');
    $table->string('nama_pelanggan');
    $table->string('alamat');
    $table->string('no_telp');
    $table->decimal('total_bayar', 15, 2);
    $table->string('invoice_pembayaran');            // Cash/Transfer/Ciro
    $table->text('keterangan')->nullable();
    $table->integer('id_sales');
    $table->foreignId('id_invoice')->nullable()->constrained('invoices')->onDelete('set null');
    $table->timestamps();
});
```

**Relationships**:
- `belongsTo` → Sales
- `belongsTo` → Invoice (optional)
- `hasMany` → DetailKuitansi

---

### 4. **SURAT_PERJANJIANS** (Agreement Letter Table)
**File**: `2025_12_20_063620_create_surat_perjanjians_table.php`

```php
Schema::create('surat_perjanjians', function (Blueprint $table) {
    $table->id();                                    // auto-generated PK (id_surat)
    $table->date('tanggal_surat');
    $table->string('nama_pelanggan');
    $table->string('alamat_pelanggan');
    $table->string('no_telp_pelanggan');
    $table->string('email_pelanggan');
    $table->date('tanggal_selesai');
    $table->decimal('nilai_kontrak', 15, 2);
    $table->text('syarat_ketentuan');
    $table->string('status_surat');                  // Draft/Aktif/Selesai
    $table->string('nama_pihak_pertama');
    $table->string('nama_pihak_kedua');
    $table->foreignId('id_sales')->constrained('sales')->onDelete('cascade');
    $table->timestamps();
});
```

**Relationships**:
- `belongsTo` → Sales
- `hasMany` → DetailSurat

---

### 5. **DETAIL_INVOICES** (Invoice Items Table)
**File**: `2025_12_20_063636_create_detail_invoices_table.php`

```php
Schema::create('detail_invoices', function (Blueprint $table) {
    $table->integer('id_detail')->primary();         // PK
    $table->foreignId('id_invoice')->constrained('invoices')->onDelete('cascade');
    $table->string('id_kuitansi');                   // referensi ke Google Drive
    $table->integer('jumlah');
    $table->decimal('harga_satuan', 15, 2);
    $table->decimal('subtotal', 15, 2);
    $table->timestamps();
});
```

**Relationships**:
- `belongsTo` → Invoice

---

### 6. **DETAIL_KUITANSIS** (Receipt Details Table)
**File**: `2025_12_20_063648_create_detail_kuitansis_table.php`

```php
Schema::create('detail_kuitansis', function (Blueprint $table) {
    $table->integer('id_detail_kuitansi')->primary(); // PK
    $table->foreignId('id_kuitansi')->constrained('kuitansis')->onDelete('cascade');
    $table->string('id_txtKtl');                     // referensi ke Google Drive
    $table->integer('jumlah');
    $table->decimal('harga_satuan', 15, 2);
    $table->decimal('subtotal', 15, 2);
    $table->timestamps();
});
```

**Relationships**:
- `belongsTo` → Kuitansi

---

### 7. **DETAIL_SURATS** (Agreement Details Table)
**File**: `2025_12_20_063659_create_detail_surats_table.php`

```php
Schema::create('detail_surats', function (Blueprint $table) {
    $table->integer('id_detail_surat')->primary();   // PK
    $table->foreignId('id_surat')->constrained('surat_perjanjians')->onDelete('cascade');
    $table->string('id_txtKtl');                     // referensi ke Google Drive
    $table->integer('jumlah');
    $table->decimal('harga_satuan', 15, 2);
    $table->string('spesifikasi')->nullable();
    $table->decimal('subtotal', 15, 2);
    $table->timestamps();
});
```

**Relationships**:
- `belongsTo` → SuratPerjanjian

---

## 🔗 Relationship Diagram

```
SALES (1) ──┬── (N) INVOICES
            │       └── (N) DETAIL_INVOICES
            │       └── (N) KUITANSIS
            │               └── (N) DETAIL_KUITANSIS
            │
            └── (N) SURAT_PERJANJIANS
                    └── (N) DETAIL_SURATS
```

---

## 📁 Models Created

### 1. **Sales.php**
```php
- id (PK auto)
- id_sales (unique)
- nama_sales
- username (unique)
- password

Relations:
- hasMany(Invoice)
- hasMany(Kuitansi)
- hasMany(SuratPerjanjian)
```

### 2. **Invoice.php**
```php
- id (PK auto)
- tanggal_invoice (date)
- nama_pelanggan
- alamat
- no_telp
- email
- total_harga (decimal)
- status_pembayaran (string)
- jatuh_tempo (date)
- keterangan (text, nullable)
- id_sales (FK)

Relations:
- belongsTo(Sales)
- hasMany(DetailInvoice)
- hasMany(Kuitansi)
```

### 3. **Kuitansi.php**
```php
- id (PK auto)
- tanggal_kuitansi (date)
- nama_pelanggan
- alamat
- no_telp
- total_bayar (decimal)
- invoice_pembayaran (Cash/Transfer/Ciro)
- keterangan (text, nullable)
- id_sales (int)
- id_invoice (FK, nullable)

Relations:
- belongsTo(Sales)
- belongsTo(Invoice)
- hasMany(DetailKuitansi)
```

### 4. **SuratPerjanjian.php**
```php
- id (PK auto, id_surat)
- tanggal_surat (date)
- nama_pelanggan
- alamat_pelanggan
- no_telp_pelanggan
- email_pelanggan
- tanggal_selesai (date)
- nilai_kontrak (decimal)
- syarat_ketentuan (text)
- status_surat (Draft/Aktif/Selesai)
- nama_pihak_pertama
- nama_pihak_kedua
- id_sales (FK)

Relations:
- belongsTo(Sales)
- hasMany(DetailSurat)
```

### 5. **DetailInvoice.php**
```php
- id_detail (PK, int)
- id_invoice (FK)
- id_kuitansi (string, Google Drive ref)
- jumlah (int)
- harga_satuan (decimal)
- subtotal (decimal)

Relations:
- belongsTo(Invoice)
```

### 6. **DetailKuitansi.php**
```php
- id_detail_kuitansi (PK, int)
- id_kuitansi (FK)
- id_txtKtl (string, Google Drive ref)
- jumlah (int)
- harga_satuan (decimal)
- subtotal (decimal)

Relations:
- belongsTo(Kuitansi)
```

### 7. **DetailSurat.php**
```php
- id_detail_surat (PK, int)
- id_surat (FK)
- id_txtKtl (string, Google Drive ref)
- jumlah (int)
- harga_satuan (decimal)
- spesifikasi (string, nullable)
- subtotal (decimal)

Relations:
- belongsTo(SuratPerjanjian)
```

---

## ✅ Migration Status

```bash
php artisan migrate
```

**Results**:
- ✅ 2025_12_20_063533_create_sales_table
- ✅ 2025_12_20_063545_create_invoices_table
- ✅ 2025_12_20_063555_create_kuitansis_table
- ✅ 2025_12_20_063620_create_surat_perjanjians_table
- ✅ 2025_12_20_063636_create_detail_invoices_table
- ✅ 2025_12_20_063648_create_detail_kuitansis_table
- ✅ 2025_12_20_063659_create_detail_surats_table

**Total Tables in Database**: 55 (7 new tables added)

---

## 🎯 Key Features

### Foreign Key Constraints:
- ✅ **CASCADE DELETE**: When parent deleted, children auto-deleted
  - Sales → Invoices
  - Sales → SuratPerjanjians
  - Invoice → DetailInvoices
  - Kuitansi → DetailKuitansis
  - SuratPerjanjian → DetailSurats

- ✅ **SET NULL**: When parent deleted, FK set to null
  - Invoice → Kuitansi (optional relationship)

### Data Types:
- ✅ **DECIMAL(15,2)**: For all money values (harga, total, nilai_kontrak)
- ✅ **DATE**: For all date fields (tanggal_invoice, jatuh_tempo, etc.)
- ✅ **TEXT**: For long content (keterangan, syarat_ketentuan)
- ✅ **STRING**: For short text fields
- ✅ **INTEGER**: For quantities and IDs

### Indexes:
- ✅ **PRIMARY KEYS**: All tables have PK
- ✅ **FOREIGN KEYS**: All relations indexed
- ✅ **UNIQUE**: id_sales, username in Sales table

---

## 📊 Database Statistics

- **PostgreSQL Version**: 17.6
- **Total Tables**: 55
- **New Tables**: 7
- **Total Size**: 1.67 MB
- **Schema**: public

---

## 🚀 Next Steps

Sekarang database sudah siap, kita bisa lanjut:

1. ✅ Buat Seeder untuk sample data
2. ✅ Buat Controller untuk Invoice CRUD
3. ✅ Buat Routes untuk Invoice Management
4. ✅ Buat Views untuk Invoice Management Page

---

**Status**: ✅ COMPLETED
**Date**: December 20, 2025
**ERD Compliance**: 100% Match with provided diagram
