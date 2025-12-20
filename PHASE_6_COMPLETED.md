# Phase 6: Invoice Input Page - COMPLETED ✅

## Overview
Dynamic invoice input page with real-time item management, automatic calculations, and Alpine.js integration.

## Features Implemented

### 1. Controller Methods ✅

**Added to `InvoiceController.php`:**

```php
/**
 * Show the invoice input page with item management.
 */
public function input()
{
    $salesList = Sales::all();
    return view('invoices.input', compact('salesList'));
}

/**
 * Store invoice with items.
 */
public function storeWithItems(Request $request)
{
    // Validates invoice data + items array
    // Calculates total from items
    // Creates invoice + detail items in one transaction
    // Redirects to invoice detail page
}
```

**Validation Rules:**
- Invoice fields: tanggal_invoice, nama_pelanggan, status_pembayaran, jatuh_tempo, id_sales (all required)
- Items: required array with minimum 1 item
- Each item: id_kuitansi (string), jumlah (numeric ≥1), harga_satuan (numeric ≥0)
- Automatic total calculation from items

### 2. Routes ✅

**Added before resource routes:**
```php
Route::get('/invoices/input', [InvoiceController::class, 'input'])->name('invoices.input');
Route::post('/invoices/store-with-items', [InvoiceController::class, 'storeWithItems'])->name('invoices.storeWithItems');
```

**Note:** Must be placed BEFORE `Route::resource()` to avoid conflict with `/invoices/{invoice}` route.

### 3. Invoice Input View (`invoices/input.blade.php`) ✅

**Page Structure:**

#### A. Invoice Information Card
- Invoice Date (default: today)
- Due Date (date picker)
- Payment Status (Lunas/Belum Lunas/Cicilan)
- Sales Person (dropdown from database)

#### B. Customer Information Card
- Customer Name (required)
- Email Address (optional)
- Phone Number (optional)
- Address (textarea, optional)

#### C. Invoice Items Table (Dynamic)
**Columns:**
- # (auto-numbered)
- Item / Kuitansi ID (text input, required)
- Quantity (number input, min: 1, required)
- Unit Price (number input, min: 0, step: 0.01, required)
- Subtotal (auto-calculated, read-only)
- Action (delete button)

**Features:**
- ➕ **Add Item Button** - Adds new row to table
- 🗑️ **Delete Button** - Removes item (disabled if only 1 item)
- 📊 **Real-time Calculation** - Subtotal updates on quantity/price change
- 🔢 **Currency Formatting** - Indonesian Rupiah format (Rp 1.000.000)
- ⚡ **Dynamic Rows** - Add/remove unlimited items

#### D. Summary Card
**Real-time Calculations:**
- Subtotal: Sum of all item subtotals
- PPN (11%): Subtotal × 0.11
- Grand Total: Subtotal + PPN

All amounts update instantly when items change.

#### E. Additional Notes Card
- Keterangan field (textarea, optional)

#### F. Action Buttons
- Cancel (link back to index)
- Create Invoice (submit form)

### 4. Alpine.js Integration ✅

**JavaScript Function: `invoiceInput()`**

**Data Properties:**
```javascript
items: [{
    id_kuitansi: '',
    jumlah: 1,
    harga_satuan: 0,
    subtotal: 0
}] // Array of invoice items (starts with 1 empty item)
```

**Computed Properties:**
```javascript
grandTotal    // Sum of all item subtotals
ppn           // Grand total × 11%
totalWithPPN  // Grand total + PPN
```

**Methods:**
```javascript
addItem()                 // Push new item to array
removeItem(index)         // Remove item at index (min 1 item)
calculateSubtotal(index)  // Calculate item.subtotal = qty × price
formatCurrency(value)     // Format as Rp 1.000.000
```

**Event Bindings:**
- `@input="calculateSubtotal(index)"` on quantity and price inputs
- `@click="addItem"` on Add Item button
- `@click="removeItem(index)"` on delete buttons
- `x-text` directives for displaying computed values

### 5. Layout Updates ✅

**Updated `layouts/app.blade.php`:**
```blade
@stack('scripts')  // Added before </body> tag
```

Allows blade views to inject scripts using:
```blade
@push('scripts')
    <script>
        // Custom JavaScript
    </script>
@endpush
```

### 6. Index Page Update ✅

**Replaced single "Add Invoice" button with two buttons:**

1. **"Input Invoice (with Items)"** (Primary variant, blue)
   - Links to `/invoices/input`
   - Icon: document with lines
   - Full invoice creation with items

2. **"Quick Add"** (Success variant, green)
   - Links to `/invoices/create`
   - Existing simple form
   - Invoice header only (no items)

### 7. Form Submission Flow ✅

**Step-by-Step Process:**

1. **User fills form:**
   - Invoice info (date, status, sales)
   - Customer info (name, email, phone, address)
   - Add multiple items with quantity & price

2. **Real-time updates:**
   - Each item calculates subtotal automatically
   - Summary card shows running total + PPN
   - Grand total updates instantly

3. **Submit form:**
   - POST to `/invoices/store-with-items`
   - Server validates all fields
   - Returns errors if validation fails

4. **Server processing:**
   - Calculate total from items
   - Create invoice record
   - Create detail_invoices records (loop through items array)
   - Redirect to invoice detail page

5. **Success:**
   - Flash message: "Invoice dengan items berhasil dibuat!"
   - Shows invoice detail with all items

## Technical Details

### Input Names for Items Array

```html
items[0][id_kuitansi]     → "ITEM-001"
items[0][jumlah]          → 5
items[0][harga_satuan]    → 1000000

items[1][id_kuitansi]     → "ITEM-002"
items[1][jumlah]          → 3
items[1][harga_satuan]    → 500000
```

**Laravel receives as:**
```php
$request->items = [
    0 => [
        'id_kuitansi' => 'ITEM-001',
        'jumlah' => 5,
        'harga_satuan' => 1000000
    ],
    1 => [
        'id_kuitansi' => 'ITEM-002',
        'jumlah' => 3,
        'harga_satuan' => 500000
    ]
]
```

### Calculation Logic

**Frontend (Alpine.js):**
```javascript
// Per-item subtotal
item.subtotal = item.jumlah × item.harga_satuan

// Grand total (all items)
grandTotal = sum(item.subtotal for all items)

// PPN 11%
ppn = grandTotal × 0.11

// Total with tax
totalWithPPN = grandTotal + ppn
```

**Backend (Laravel):**
```php
$total = 0;
foreach ($validated['items'] as $item) {
    $total += $item['jumlah'] * $item['harga_satuan'];
}

// Store as invoice total_harga
$invoice->total_harga = $total;

// Create detail items
foreach ($validated['items'] as $item) {
    $invoice->detailInvoices()->create([
        'id_kuitansi' => $item['id_kuitansi'],
        'jumlah' => $item['jumlah'],
        'harga_satuan' => $item['harga_satuan'],
        'subtotal' => $item['jumlah'] * $item['harga_satuan'],
    ]);
}
```

**Note:** Backend calculates and stores total. Frontend PPN is for display only (not stored separately).

### Currency Formatting

**JavaScript Intl.NumberFormat:**
```javascript
formatCurrency(value) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value || 0);
}
```

**Output Examples:**
- 0 → "Rp 0"
- 1000000 → "Rp 1.000.000"
- 15750000 → "Rp 15.750.000"
- 1500000.50 → "Rp 1.500.001" (rounds up)

## UI/UX Features

### Empty State
When no items in table:
- Empty state icon (document)
- Message: "No items added"
- Instruction: "Click 'Add Item' button to add invoice items"

### Button States
- **Delete button disabled** when only 1 item exists
- Opacity: 50%, cursor: not-allowed
- Prevents deleting last item

### Form Validation
- Required fields marked with red asterisk (*)
- Error summary card at top if validation fails
- Individual field errors (from Laravel validation)

### Responsive Design
- Mobile: Single column layout
- Desktop: Multi-column grid
- Table: Horizontal scroll on mobile
- Buttons: Stack vertically on mobile

## Testing Guide

### 1. Access Invoice Input Page

**Method A: From Index**
```
1. Login as manager@bimasada.com / manager123
2. Click "Invoices" in navigation
3. Click "Input Invoice (with Items)" button (blue)
4. Verify input page loads
```

**Method B: Direct URL**
```
http://127.0.0.1:8000/invoices/input
```

### 2. Test Dynamic Item Management

**Add Items:**
```
1. Click "+ Add Item" button
2. Verify new row appears at bottom
3. Add 5 items total
4. Verify each row has unique index number
```

**Remove Items:**
```
1. Click delete button on row #3
2. Verify row removed
3. Verify row numbers re-indexed
4. Delete items until only 1 remains
5. Verify delete button becomes disabled/grayed
6. Try clicking disabled button → nothing happens
```

**Minimum Items:**
```
1. Start with 1 item (default)
2. Verify delete button is disabled
3. Add second item
4. Verify delete buttons now enabled
```

### 3. Test Real-time Calculations

**Single Item:**
```
1. Enter quantity: 5
2. Enter unit price: 1000000
3. Verify subtotal shows: Rp 5.000.000
4. Verify summary shows:
   - Subtotal: Rp 5.000.000
   - PPN (11%): Rp 550.000
   - Grand Total: Rp 5.550.000
```

**Multiple Items:**
```
Item 1: Qty 5 × Rp 1.000.000 = Rp 5.000.000
Item 2: Qty 3 × Rp 500.000   = Rp 1.500.000
Item 3: Qty 10 × Rp 250.000  = Rp 2.500.000

Expected Summary:
- Subtotal: Rp 9.000.000
- PPN (11%): Rp 990.000
- Grand Total: Rp 9.990.000
```

**Change Quantity:**
```
1. Change Item 1 qty from 5 to 10
2. Verify subtotal updates to: Rp 10.000.000
3. Verify grand total updates to: Rp 15.290.000
```

**Change Price:**
```
1. Change Item 2 price from 500000 to 750000
2. Verify subtotal updates to: Rp 2.250.000
3. Verify grand total updates accordingly
```

**Edge Cases:**
```
1. Enter quantity: 0 → Subtotal: Rp 0
2. Enter price: 0 → Subtotal: Rp 0
3. Leave quantity empty → Subtotal: Rp 0
4. Delete all text → Treated as 0
```

### 4. Test Form Submission

**Complete Invoice:**
```
1. Fill all required fields:
   - Invoice Date: 2025-12-20
   - Due Date: 2026-01-20
   - Payment Status: Belum Lunas
   - Sales Person: SLS001 - John Doe
   - Customer Name: PT. Test Indonesia
   - Email: test@test.com
   - Phone: 08123456789
   - Address: Jl. Test No. 123
   
2. Add 3 items:
   Item 1: ITEM-001, Qty 5, Price 1000000
   Item 2: ITEM-002, Qty 3, Price 500000
   Item 3: ITEM-003, Qty 2, Price 750000
   
3. Add notes: "Test invoice dari input page"

4. Click "Create Invoice" button

5. Verify redirected to invoice detail page

6. Verify invoice shows:
   - Customer: PT. Test Indonesia
   - Total: Rp 8.000.000 (5M + 1.5M + 1.5M)
   - Status: Belum Lunas
   - 3 items in table
```

**Validation Errors:**
```
Test Case 1: Missing required fields
1. Leave customer name empty
2. Submit form
3. Verify error summary appears at top
4. Verify error: "The nama pelanggan field is required"

Test Case 2: No items
1. Fill all invoice/customer fields
2. Delete all items (impossible due to min 1 item)
3. Leave item fields empty
4. Submit form
5. Verify error: "The items.0.id_kuitansi field is required"

Test Case 3: Invalid email
1. Fill form
2. Enter email: "notanemail"
3. Submit form
4. Verify error: "The email field must be a valid email address"

Test Case 4: Invalid dates
1. Set due date before invoice date
2. Submit form
3. Verify invoice still saves (no date comparison validation)
```

### 5. Database Verification

**After successful submission:**
```sql
-- Check invoice created
SELECT * FROM invoices ORDER BY id DESC LIMIT 1;

-- Check detail items created
SELECT * FROM detail_invoices WHERE id_invoice = [invoice_id];

-- Verify counts
SELECT 
    i.id,
    i.nama_pelanggan,
    i.total_harga,
    COUNT(di.id_detail) as item_count,
    SUM(di.subtotal) as calculated_total
FROM invoices i
LEFT JOIN detail_invoices di ON i.id = di.id_invoice
GROUP BY i.id
ORDER BY i.id DESC
LIMIT 1;

-- Should show item_count = 3 and calculated_total = total_harga
```

### 6. Compare with Quick Add

**Quick Add (existing /invoices/create):**
- Simple form
- Invoice header only
- No items management
- Manual total input
- Faster for simple invoices

**Input Invoice (new /invoices/input):**
- Comprehensive form
- Dynamic item table
- Auto-calculate total from items
- Better for detailed invoices

## File Changes Summary

### Modified Files (4):
```
app/Http/Controllers/InvoiceController.php
  +68 lines (2 new methods)

routes/web.php
  +2 lines (2 new routes)

resources/views/invoices/index.blade.php
  Changed header buttons (single → two buttons)

resources/views/layouts/app.blade.php
  +2 lines (@stack('scripts') support)
```

### New Files (1):
```
resources/views/invoices/input.blade.php
  ~370 lines
  - Alpine.js integration
  - Dynamic item table
  - Real-time calculations
  - Form with 5 sections
```

### Asset Build:
```
npm run build
  ✓ CSS: 55.66 kB (gzipped 9.60 kB) ← +0.30 kB from Phase 5
  ✓ JS: 81.83 kB (gzipped 30.58 kB)  ← unchanged
  ✓ Build time: 2.61s
```

## Known Limitations

1. **No Draft Save**
   - Must complete entire form in one session
   - No auto-save functionality
   - Future enhancement: Add "Save Draft" button

2. **PPN Not Stored**
   - PPN (11%) calculated on frontend for display
   - Only subtotal stored in database
   - Can be calculated from subtotal anytime

3. **No Item Description**
   - Only id_kuitansi field (Google Drive ID reference)
   - No dedicated description/name field
   - Use id_kuitansi for descriptive text

4. **No Item Validation**
   - Doesn't check if id_kuitansi exists
   - Accepts any string value
   - Future enhancement: Dropdown of actual items

5. **Minimum 1 Item**
   - Cannot submit invoice without items
   - Delete button disabled on last item
   - Use Quick Add for invoices without items

## Access URLs

**Development Server:** http://127.0.0.1:8000

**Invoice Input Page:**
- http://127.0.0.1:8000/invoices/input

**Related Pages:**
- List: http://127.0.0.1:8000/invoices
- Quick Add: http://127.0.0.1:8000/invoices/create

## Next Steps (Phase 7-10)

### Phase 7: Add Invoice Modal
- Modal component matching "Modals tambah invoice.png"
- Fields: No Invoice, No Kontrak, Mitra/Perusahaan, Status
- Auto-generate invoice number
- Batal and Simpan buttons

### Phase 8: Role-Based Access Control
- Apply Spatie permissions to invoice routes
- Marketing Manager: Full access (CRUD + input)
- Sales: Limited access (Read + Create only)
- Hide buttons based on role

### Phase 9: Kuitansi & Surat Perjanjian CRUD
- Build complete CRUD for Kuitansi (receipts)
- Build complete CRUD for Surat Perjanjian (agreements)
- Link receipts to invoices
- Similar input pages with item management

### Phase 10: Polish & Deploy
- Flash messages for all CRUD operations
- Export to PDF (invoice, receipt, agreement)
- Print functionality
- Excel export for reports
- Performance optimization
- Final testing
- Deployment guide

## Phase 6 Status: ✅ 100% COMPLETED

**Date Completed:** December 20, 2025

**Summary:**
- ✅ Invoice input view with Alpine.js (370 lines)
- ✅ Controller methods (input, storeWithItems)
- ✅ Routes (/invoices/input, /invoices/store-with-items)
- ✅ Dynamic item table (add/remove rows)
- ✅ Real-time calculations (subtotal, PPN, grand total)
- ✅ Currency formatting (Rp 1.000.000)
- ✅ Form validation (required fields, array validation)
- ✅ Layout update (@stack scripts support)
- ✅ Index page update (2 buttons)
- ✅ Asset rebuild successful

**Total New Lines:** ~440 lines (view + controller + routes)
**Build Output:** 55.66 kB CSS + 81.83 kB JS

---

**Ready for Phase 7!** 🚀
