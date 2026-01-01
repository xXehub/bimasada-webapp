{{-- Session Notification Handler --}}
{{-- Include this in layout or page to automatically show notifications from Laravel session --}}
{{-- Can also be placed in @push('scripts') section --}}

<script>
    // Set session data for global handler
    window.sessionNotifications = {
        @if(session('success'))
            success: '{{ session('success') }}',
        @endif
        @if(session('error'))
            error: '{{ session('error') }}',
        @endif
        @if(session('warning'))
            warning: '{{ session('warning') }}',
        @endif
        @if(session('info'))
            info: '{{ session('info') }}',
        @endif
        @if(session('status'))
            status: '{{ session('status') }}',
        @endif
    };
</script>
