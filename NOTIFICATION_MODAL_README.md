# Notification & Modal System

Sistem notifikasi dan modal yang reusable dan konsisten untuk aplikasi Bimasada.

## 📦 Komponen

### 1. Notification Component
Komponen notifikasi toast dengan animasi smooth dan auto-dismiss.

**Jenis Notifikasi:**
- ✅ Success (hijau)
- ❌ Error (merah)
- ⚠️ Warning (kuning)
- ℹ️ Info (biru)

**Penggunaan:**
```javascript
// Basic
Notification.success('Title', 'Message');
Notification.error('Title', 'Message');
Notification.warning('Title', 'Message');
Notification.info('Title', 'Message');

// Custom duration (default 5000ms)
Notification.success('Title', 'Message', 10000);
```

**Dari Laravel Session:**
```blade
@if(session('success'))
    <script>
        Notification.success('Berhasil!', '{{ session('success') }}');
    </script>
@endif
```

### 2. Modal Components

#### a. Confirm Delete Modal
Modal konfirmasi untuk operasi hapus dengan styling merah.

```javascript
Modal.confirmDelete({
    itemName: 'User: John Doe',
    message: 'Custom message (optional)',
    onConfirm: () => {
        // Delete action
    },
    onCancel: () => {
        // Cancel action (optional)
    }
});
```

#### b. Confirm Modal
Modal konfirmasi umum untuk berbagai aksi.

```javascript
Modal.confirm({
    title: 'Konfirmasi',
    message: 'Apakah Anda yakin?',
    onConfirm: () => { /* action */ },
    onCancel: () => { /* action */ }
});
```

#### c. Alert Modal
Modal alert dengan 4 jenis (success, error, warning, info).

```javascript
Modal.alert({
    type: 'success', // success, error, warning, info
    title: 'Berhasil',
    message: 'Data berhasil disimpan',
    onConfirm: () => { /* action */ }
});
```

### 3. Helper Functions

#### deleteWithConfirm()
Helper untuk AJAX delete dengan konfirmasi.

```javascript
deleteWithConfirm(
    '/users/1',           // URL
    'John Doe',           // Item name
    (data) => {          // Success callback
        table.ajax.reload();
    },
    (error) => {}        // Error callback (optional)
);
```

#### showValidationErrors()
Menampilkan Laravel validation errors sebagai notifikasi.

```javascript
showValidationErrors({
    name: ['Name is required'],
    email: ['Email is invalid', 'Email already exists']
});
```

## 🎨 Features

- ✨ Animasi smooth (slide in/out)
- 🎯 Auto-dismiss dengan progress bar
- 🖱️ Pause on hover
- ⌨️ Close on ESC key
- 🎭 Dark mode support
- 📱 Responsive design
- ♿ Accessibility support (ARIA)
- 🔔 Multiple notifications stacking
- 🎨 Consistent design system

## 📝 Implementasi di Controller

```php
// UserController.php
public function store(Request $request)
{
    // ... validation & create user
    
    return redirect()->route('users.index')
        ->with('success', 'User berhasil dibuat!');
}

public function destroy(User $user)
{
    $user->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'User berhasil dihapus!'
    ]);
}
```

## 📋 Implementasi di View

### DataTables dengan Delete Button

```blade
@push('scripts')
<script>
    // Show session notification
    @if(session('success'))
        Notification.success('Berhasil!', '{{ session('success') }}');
    @endif
    
    // Delete function
    function deleteUser(userId, userName) {
        Modal.confirmDelete({
            itemName: userName,
            onConfirm: () => {
                fetch(`/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#users-table').DataTable().ajax.reload();
                        Notification.success('Berhasil!', data.message);
                    } else {
                        Notification.error('Gagal!', data.message);
                    }
                })
                .catch(error => {
                    Notification.error('Error!', 'Terjadi kesalahan');
                });
            }
        });
    }
</script>
@endpush
```

### Button Delete dengan Data

```php
// Controller - DataTables action column
->addColumn('action', function ($user) {
    $userName = htmlspecialchars($user->name);
    return '
        <button onclick="deleteUser('.$user->id.', \''.$userName.'\')" 
                class="...">
            Delete
        </button>
    ';
})
```

## 🚀 Demo

Kunjungi `/demo/notifications-modals` untuk melihat demo interaktif dari semua komponen.

## 📁 File Structure

```
resources/
├── views/
│   └── components/
│       ├── notification.blade.php           # Notification component
│       └── modals/
│           ├── confirm-delete.blade.php     # Delete confirmation modal
│           ├── confirm.blade.php            # General confirm modal
│           └── alert.blade.php              # Alert modal
└── js/
    ├── app.js                               # Import modal-helper
    └── modal-helper.js                      # Modal & notification logic
```

## ✅ Sudah Diterapkan Di:

- ✅ Users Management (index, create, edit, delete)
- ✅ Invoices Management (index, delete)
- ✅ Layout (app.blade.php, layout/app.blade.php)

## 🎯 Todo

Terapkan ke menu-menu lain:
- [ ] Roles Management
- [ ] Permissions Management
- [ ] Profile Management
- [ ] Auth pages (login, register)
- [ ] Other CRUD pages

## 💡 Tips

1. **Selalu include CSRF token** di AJAX request
2. **Gunakan htmlspecialchars()** untuk escape data di onclick attribute
3. **Return JSON response** dari Controller untuk AJAX
4. **Session flash** untuk redirect dengan notification
5. **Pause notification on hover** untuk user baca pesan

## 🐛 Troubleshooting

**Notification tidak muncul:**
- Pastikan `<x-notification />` ada di layout
- Pastikan `modal-helper.js` sudah di-import di `app.js`
- Check console untuk JavaScript errors

**Modal tidak muncul:**
- Pastikan modal component ada di layout
- Pastikan modal ID sesuai dengan parameter
- Check z-index conflicts

**Delete tidak work:**
- Verify CSRF token
- Check route method DELETE
- Verify permissions/authorization
- Check network tab untuk errors

---

Dibuat dengan ❤️ untuk Bimasada Web App
