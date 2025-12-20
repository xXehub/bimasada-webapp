# 🎨 ITERASI 2 - UI REDESIGN BIMASADA INVOICE SYSTEM

## 📋 Overview
Modern, Professional, Clean UI dengan Dark/Light Theme Support dan Mobile Responsive

## 🎯 Goals
- ✅ Modern & Professional Look
- ✅ Dark/Light Theme Toggle
- ✅ Mobile Responsive (Flexible UI)
- ✅ Reusable Components
- ✅ Consistent Global Colors

---

## 📦 PHASE 1: Design System & Base Components
**Status:** ⏳ Not Started

### Tasks:
- [ ] 1.1 Setup Dark/Light Theme dengan Tailwind CSS
  - Konfigurasi `darkMode: 'class'` di tailwind.config.js
  - Buat CSS variables untuk theming
  - Implementasi theme toggle dengan localStorage persistence

- [ ] 1.2 Typography & Color System
  - Gunakan existing global colors (primary, primary-dark, secondary, accent, danger, success)
  - Tambahkan dark mode variants
  - Setup font hierarchy (Poppins)

- [ ] 1.3 Base UI Components
  - Button variants (primary, secondary, outline, ghost, danger)
  - Input fields dengan dark/light support
  - Card component dengan shadow & border variants
  - Badge/Tag component

---

## 📦 PHASE 2: Login Page UI
**Status:** ⏳ Not Started

### Tasks:
- [ ] 2.1 Redesign Login Layout
  - Modern split-screen design
  - Animated background/pattern
  - Responsive: mobile-first approach

- [ ] 2.2 Login Form Styling
  - Modern input fields dengan icons
  - Password visibility toggle
  - Remember me checkbox styling
  - Submit button dengan loading state

- [ ] 2.3 Theme Toggle
  - Add theme switcher di login page
  - Smooth transition animations
  - Persist theme preference

- [ ] 2.4 Branding & Assets
  - Logo positioning
  - Brand colors integration
  - Professional imagery

---

## 📦 PHASE 3: Dashboard Layout & Sidebar
**Status:** ⏳ Not Started

### Tasks:
- [ ] 3.1 Dashboard Layout Structure
  - Sidebar + Main Content area
  - Header dengan user profile & notifications
  - Footer (optional)

- [ ] 3.2 Sidebar Component
  - Collapsible sidebar
  - Multilevel navigation menu
  - Active state indicators
  - Icons untuk setiap menu item
  - Mobile: hamburger menu + overlay

- [ ] 3.3 Sidebar Menu Items (Dummy)
  - 🏠 Dashboard
  - 📄 Invoice Management
    - 📝 Input Invoice
    - 📋 Daftar Invoice
    - ➕ Tambah Invoice
  - 👥 Customer Management
  - 🚗 Kendaraan
  - ⚙️ Settings
    - 👤 Profile
    - 🔐 Password
  - 🚪 Logout

- [ ] 3.4 Header Component
  - Logo/Brand
  - Search bar (optional)
  - Notifications dropdown
  - User profile dropdown
  - Theme toggle button

---

## 📦 PHASE 4: Reusable Components Library
**Status:** ⏳ Not Started

### Tasks:
- [ ] 4.1 Modal Component
  - Sizes: sm, md, lg, xl, full
  - Header, body, footer sections
  - Close button & backdrop click
  - Animation (fade/slide)
  - Dark/light theme support

- [ ] 4.2 DataTable Component
  - Sortable columns
  - Pagination
  - Search/Filter
  - Row selection
  - Actions column
  - Responsive (horizontal scroll atau card view di mobile)
  - Loading state skeleton

- [ ] 4.3 Notification/Toast Component
  - Types: success, error, warning, info
  - Auto dismiss dengan timer
  - Stack notifications
  - Action buttons (optional)

- [ ] 4.4 Dropdown Menu
  - Trigger button styling
  - Menu items dengan icons
  - Dividers
  - Submenu support

- [ ] 4.5 Loading States
  - Skeleton loaders
  - Spinner variations
  - Progress bar
  - Page loading overlay

---

## 📦 PHASE 5: Invoice Pages UI
**Status:** ⏳ Not Started

### Tasks:
- [ ] 5.1 Invoice Management Page (List)
  - Apply DataTable component
  - Status badges (Draft, Pending, Approved, Rejected)
  - Quick actions (view, edit, delete)
  - Bulk actions
  - Filters & search

- [ ] 5.2 Input Invoice Page
  - Form layout dengan sections
  - Dynamic invoice items
  - Auto-calculate totals
  - Save/Cancel buttons
  - Form validation feedback

- [ ] 5.3 Add Invoice Modal
  - Apply Modal component
  - Auto-generated invoice number
  - Customer & vehicle selection
  - Date pickers
  - Confirmation modal

- [ ] 5.4 Invoice Detail Page
  - Invoice preview layout
  - Print-ready styling
  - Action buttons (edit, approve, delete)
  - Status timeline (optional)

---

## 📦 PHASE 6: Polish & Animations
**Status:** ⏳ Not Started

### Tasks:
- [ ] 6.1 Micro-interactions
  - Button hover/click effects
  - Input focus animations
  - Menu transitions
  - Page transitions

- [ ] 6.2 Loading & Empty States
  - Skeleton screens
  - Empty state illustrations
  - Error state designs

- [ ] 6.3 Responsive Refinements
  - Test all breakpoints
  - Touch-friendly interactions
  - Mobile navigation patterns

- [ ] 6.4 Dark Mode Polish
  - Ensure all components support dark mode
  - Smooth theme switching
  - Proper contrast ratios

---

## 🎨 Global Colors (PRESERVED from tailwind.config.js)
```javascript
colors: {
    primary: '#2387C0',      // Bimasada Blue
    'primary-dark': '#02245B', // Bimasada Navy  
    secondary: '#858788',     // Gray
    accent: '#FFA500',        // Orange
    danger: '#DC3545',        // Red
    success: '#28A745',       // Green
}
```

---

## 📱 Responsive Breakpoints
- **Mobile:** < 640px (sm)
- **Tablet:** 640px - 1024px (md, lg)
- **Desktop:** > 1024px (xl, 2xl)

---

## 🌙 Theme System
- Dark Mode: `class` strategy
- Default: Light Mode
- Toggle: Header button
- Persistence: localStorage

---

## 📁 Component Structure
```
resources/views/components/
├── ui/
│   ├── button.blade.php
│   ├── input.blade.php
│   ├── card.blade.php
│   ├── badge.blade.php
│   └── ...
├── layout/
│   ├── sidebar.blade.php
│   ├── header.blade.php
│   └── app.blade.php
├── modal/
│   └── modal.blade.php
├── table/
│   └── datatable.blade.php
└── notification/
    └── toast.blade.php
```

---

## 🔧 Tech Stack
- **Laravel 12** - Backend
- **Tailwind CSS 3.x** - Styling
- **Alpine.js** - Interactivity
- **Vite** - Build tool

---

## ⚡ Quick Start
```bash
# Start dev server
php artisan serve

# Start Vite
npm run dev

# Login credentials
manager@bimasada.com / manager123
sales@bimasada.com / sales123
```

---

## 📝 Notes
- Fokus ke UI dulu, sistem fungsionalitas nanti
- Login harus bisa berfungsi
- Gunakan dummy data untuk preview
- Semua komponen harus reusable
