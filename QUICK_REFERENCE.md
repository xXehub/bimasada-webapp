# 🚀 Quick Reference - Notification & Modal System

## ⚡ Quick Start

### 1. Notification (Toast)

```javascript
// Success
Notification.success('Berhasil!', 'Data telah disimpan');

// Error
Notification.error('Gagal!', 'Terjadi kesalahan');

// Warning
Notification.warning('Peringatan!', 'Perhatikan ini');

// Info
Notification.info('Info', 'Ada update baru');

// Custom duration (default 5000ms)
Notification.success('Title', 'Message', 10000);
```

### 2. Modal - Delete Confirmation

```javascript
Modal.confirmDelete({
    itemName: 'Invoice INV-2024-001',
    onConfirm: () => {
        // Your delete logic here
        fetch('/invoices/1', { method: 'DELETE', ... })
            .then(() => Notification.success('Deleted!', 'Invoice berhasil dihapus'));
    }
});
```

### 3. Modal - General Confirm

```javascript
Modal.confirm({
    title: 'Konfirmasi Publish',
    message: 'Publish artikel ini?',
    onConfirm: () => { /* action */ },
    onCancel: () => { /* optional */ }
});
```

### 4. Modal - Alert

```javascript
Modal.alert({
    type: 'success', // success, error, warning, info
    title: 'Success!',
    message: 'Operation completed',
    onConfirm: () => { /* optional */ }
});
```

## 📝 Laravel Integration

### Controller

```php
// Redirect with session
return redirect()->route('users.index')
    ->with('success', 'User created successfully!');

// JSON response (for AJAX)
return response()->json([
    'success' => true,
    'message' => 'User deleted successfully!'
]);
```

### Blade View

```blade
{{-- In @push('scripts') --}}
@push('scripts')
    <x-session-notification />
    
    <script>
        function deleteItem(id, name) {
            Modal.confirmDelete({
                itemName: name,
                onConfirm: () => {
                    fetch(`/items/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            Notification.success('Deleted!', data.message);
                            // Reload your table/list
                        } else {
                            Notification.error('Failed!', data.message);
                        }
                    });
                }
            });
        }
    </script>
@endpush
```

### DataTables Action Column

```php
// In Controller
->addColumn('action', function ($item) {
    $itemName = htmlspecialchars($item->name);
    return '
        <button onclick="deleteItem('.$item->id.', \''.$itemName.'\')" 
                class="btn-delete">
            Delete
        </button>
    ';
})
```

## 🔥 Helper Functions

### Quick AJAX Delete

```javascript
deleteWithConfirm(
    '/users/123',        // URL
    'John Doe',         // Item name
    (data) => {         // Success callback
        table.ajax.reload();
    },
    (error) => {}      // Error callback (optional)
);
```

### Validation Errors

```javascript
// From Laravel validation response
showValidationErrors({
    name: ['Name is required'],
    email: ['Invalid email', 'Email exists']
});
```

## 🎨 Customization

### Custom Modal

```blade
{{-- Create custom modal --}}
<x-modals.confirm 
    id="my-custom-modal"
    title="Custom Title"
    message="Custom message"
    confirmText="Do It"
    cancelText="No Way"
    confirmColor="green"
/>

{{-- Trigger from JS --}}
<script>
    Modal.show('my-custom-modal');
</script>
```

### Custom Notification Duration

```javascript
// Show for 10 seconds
Notification.success('Title', 'Message', 10000);

// Show indefinitely (until manually closed)
const notif = Notification.info('Loading...', 'Please wait', 0);

// Remove manually later
setTimeout(() => {
    notif.remove();
}, 5000);
```

## 🐛 Common Patterns

### Form Submit with Validation

```javascript
form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    fetch('/api/submit', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            Notification.success('Success!', data.message);
            form.reset();
        } else if(data.errors) {
            showValidationErrors(data.errors);
        } else {
            Notification.error('Failed!', data.message);
        }
    })
    .catch(() => {
        Notification.error('Error!', 'Network error');
    });
});
```

### Bulk Delete

```javascript
function deleteBulk(selectedIds) {
    Modal.confirm({
        title: 'Konfirmasi Bulk Delete',
        message: `Delete ${selectedIds.length} items?`,
        onConfirm: () => {
            Notification.info('Deleting...', 'Processing', 0);
            
            fetch('/api/bulk-delete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ids: selectedIds })
            })
            .then(res => res.json())
            .then(data => {
                Notification.success('Done!', `${data.count} items deleted`);
                table.ajax.reload();
            });
        }
    });
}
```

### Async Operation with Progress

```javascript
async function processData() {
    const notif = Notification.info('Processing...', 'Please wait', 0);
    
    try {
        await fetch('/api/process', { method: 'POST' });
        notif.remove();
        Notification.success('Complete!', 'Data processed');
    } catch(error) {
        notif.remove();
        Notification.error('Failed!', error.message);
    }
}
```

## 📋 Checklist untuk Implementasi Baru

Saat menambahkan ke menu/page baru:

- [ ] Include `<x-session-notification />` di scripts
- [ ] Update Controller untuk return session messages
- [ ] Ganti `confirm()` dengan `Modal.confirmDelete()`
- [ ] Ganti `alert()` dengan `Notification`
- [ ] Pass item name ke delete function
- [ ] Escape special characters di onclick
- [ ] Test dengan dark mode
- [ ] Test responsive design
- [ ] Test keyboard navigation (ESC)

## 🎯 Tips & Best Practices

1. **Always escape** HTML di onclick attributes
2. **Use session messages** untuk redirects
3. **Use JSON responses** untuk AJAX
4. **Show loading notification** untuk long operations
5. **Remove loading notification** setelah selesai
6. **Validate before** showing confirmation
7. **Reload data** setelah successful operation
8. **Handle errors gracefully** dengan notification
9. **Test dark mode** appearance
10. **Keep messages** concise dan jelas

## 🔗 Links

- 📖 Full Documentation: `NOTIFICATION_MODAL_README.md`
- 📊 Implementation Summary: `IMPLEMENTATION_SUMMARY.md`
- 🎮 Live Demo: `/demo/notifications-modals`

---

**Happy Coding! 🚀**
