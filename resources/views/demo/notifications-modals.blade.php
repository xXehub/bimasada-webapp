<x-layout.app title="Notification & Modal Demo">
    <div class="space-y-8">
        <!-- Page Header -->
        <x-ui.page-header 
            title="Notification & Modal System" 
            description="Demonstrasi komponen reusable notification dan modal"
        />

        <!-- Notifications Demo -->
        <x-ui.card>
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Notifications</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Klik tombol di bawah untuk melihat berbagai jenis notifikasi:</p>
                
                <div class="flex flex-wrap gap-3">
                    <x-ui.button 
                        variant="success"
                        onclick="Notification.success('Berhasil!', 'Data berhasil disimpan ke database')"
                    >
                        Success Notification
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="danger"
                        onclick="Notification.error('Error!', 'Terjadi kesalahan saat memproses data')"
                    >
                        Error Notification
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="warning"
                        onclick="Notification.warning('Peringatan!', 'Pastikan data sudah benar sebelum melanjutkan')"
                    >
                        Warning Notification
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="primary"
                        onclick="Notification.info('Informasi', 'Sistem akan maintenance besok pukul 02:00')"
                    >
                        Info Notification
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="secondary"
                        onclick="Notification.success('Custom Duration!', 'Notifikasi ini akan hilang dalam 10 detik', 10000)"
                    >
                        Custom Duration (10s)
                    </x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <!-- Modals Demo -->
        <x-ui.card>
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Modals</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Klik tombol di bawah untuk melihat berbagai jenis modal:</p>
                
                <div class="flex flex-wrap gap-3">
                    <x-ui.button 
                        variant="danger"
                        onclick="demoDeleteConfirm()"
                    >
                        Delete Confirmation
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="primary"
                        onclick="demoConfirm()"
                    >
                        Confirm Modal
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="success"
                        onclick="demoAlertSuccess()"
                    >
                        Success Alert
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="danger"
                        onclick="demoAlertError()"
                    >
                        Error Alert
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="warning"
                        onclick="demoAlertWarning()"
                    >
                        Warning Alert
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="secondary"
                        onclick="demoAlertInfo()"
                    >
                        Info Alert
                    </x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <!-- Integration Example -->
        <x-ui.card>
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Integration Example</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Contoh penggunaan dengan AJAX delete:</p>
                
                <div class="flex flex-wrap gap-3">
                    <x-ui.button 
                        variant="danger"
                        onclick="demoAjaxDelete()"
                    >
                        Demo AJAX Delete
                    </x-ui.button>
                    
                    <x-ui.button 
                        variant="primary"
                        onclick="demoValidationError()"
                    >
                        Demo Validation Error
                    </x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <!-- Code Examples -->
        <x-ui.card>
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Usage Examples</h2>
                
                <div class="space-y-6">
                    <!-- Notification Example -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Notification</h3>
                        <pre class="bg-gray-100 dark:bg-dark-hover p-4 rounded-lg overflow-x-auto text-sm"><code class="language-javascript">// Basic usage
Notification.success('Title', 'Message');
Notification.error('Title', 'Message');
Notification.warning('Title', 'Message');
Notification.info('Title', 'Message');

// With custom duration (in milliseconds)
Notification.success('Title', 'Message', 10000);

// Session notification (in Blade)
@@if(session('success'))
    Notification.success('Berhasil!', '{{ session('success') }}');
@@endif</code></pre>
                    </div>
                    
                    <!-- Modal Example -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Modal</h3>
                        <pre class="bg-gray-100 dark:bg-dark-hover p-4 rounded-lg overflow-x-auto text-sm"><code class="language-javascript">// Delete confirmation
Modal.confirmDelete({
    itemName: 'User: John Doe',
    onConfirm: () => {
        // Delete action here
    }
});

// Confirm modal
Modal.confirm({
    title: 'Konfirmasi',
    message: 'Apakah Anda yakin?',
    onConfirm: () => { /* action */ },
    onCancel: () => { /* action */ }
});

// Alert modal
Modal.alert({
    type: 'success', // success, error, warning, info
    title: 'Berhasil',
    message: 'Data berhasil disimpan',
    onConfirm: () => { /* action */ }
});</code></pre>
                    </div>
                    
                    <!-- Helper Function Example -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Helper Functions</h3>
                        <pre class="bg-gray-100 dark:bg-dark-hover p-4 rounded-lg overflow-x-auto text-sm"><code class="language-javascript">// Quick AJAX delete with confirm
deleteWithConfirm('/users/1', 'John Doe', 
    (data) => {
        // Success callback
        dataTable.ajax.reload();
    },
    (error) => {
        // Error callback
    }
);

// Show validation errors
showValidationErrors({
    name: ['Name is required'],
    email: ['Email is invalid']
});</code></pre>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </div>

    @push('scripts')
    <script>
        // Demo Functions
        function demoDeleteConfirm() {
            Modal.confirmDelete({
                itemName: 'Invoice INV-2024-001',
                onConfirm: () => {
                    Notification.success('Deleted!', 'Invoice berhasil dihapus');
                },
                onCancel: () => {
                    Notification.info('Cancelled', 'Penghapusan dibatalkan');
                }
            });
        }
        
        function demoConfirm() {
            Modal.confirm({
                title: 'Konfirmasi Publish',
                message: 'Apakah Anda yakin ingin mempublikasikan artikel ini?',
                onConfirm: () => {
                    Notification.success('Published!', 'Artikel berhasil dipublikasikan');
                }
            });
        }
        
        function demoAlertSuccess() {
            Modal.alert({
                type: 'success',
                title: 'Berhasil!',
                message: 'Data telah berhasil disimpan ke database',
                onConfirm: () => {
                    console.log('Alert closed');
                }
            });
        }
        
        function demoAlertError() {
            Modal.alert({
                type: 'error',
                title: 'Error!',
                message: 'Terjadi kesalahan saat memproses permintaan Anda',
            });
        }
        
        function demoAlertWarning() {
            Modal.alert({
                type: 'warning',
                title: 'Peringatan!',
                message: 'Data Anda akan dihapus secara permanen dalam 30 hari',
            });
        }
        
        function demoAlertInfo() {
            Modal.alert({
                type: 'info',
                title: 'Informasi',
                message: 'Sistem akan melakukan pemeliharaan rutin besok pukul 02:00 WIB',
            });
        }
        
        function demoAjaxDelete() {
            Modal.confirmDelete({
                itemName: 'User: John Doe',
                onConfirm: () => {
                    // Simulate AJAX request
                    Notification.info('Menghapus...', 'Sedang menghapus user', 0);
                    
                    setTimeout(() => {
                        Notification.success('Berhasil!', 'User berhasil dihapus dari sistem');
                    }, 1500);
                }
            });
        }
        
        function demoValidationError() {
            showValidationErrors({
                name: ['Nama harus diisi'],
                email: ['Format email tidak valid', 'Email sudah terdaftar'],
                password: ['Password minimal 8 karakter']
            });
        }
    </script>
    @endpush
</x-layout.app>
