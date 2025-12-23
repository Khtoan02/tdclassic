# 📁 Cấu trúc Assets - Theme TD Classic

**Version:** 2.4.0  
**Ngày cập nhật:** 2025-01-16

---

## 🎯 Mục đích

Tài liệu này mô tả cấu trúc tổ chức file CSS và JavaScript trong theme TD Classic, giúp developers dễ dàng tìm kiếm, chỉnh sửa và bảo trì code.

---

## 📂 Cấu trúc thư mục

```
tdclassic/
├── assets/
│   ├── css/
│   │   ├── modules/          # CSS cho các phần lớn của website
│   │   ├── components/       # CSS cho các component nhỏ, tái sử dụng
│   │   ├── pages/           # CSS cho các trang cụ thể
│   │   └── admin/           # CSS cho admin panel
│   └── js/
│       ├── main.js          # File JS chính (header, footer, common)
│       ├── modules/         # JS cho các module lớn
│       ├── components/      # JS cho các component nhỏ
│       └── utils/           # Utility functions (nếu có)
└── style.css                # Base stylesheet của theme
```

---

## 🎨 CSS Structure

### **1. Modules** (`assets/css/modules/`)

CSS cho các phần lớn của website, thường load theo điều kiện (conditional loading).

| File | Mô tả | Load khi nào |
|------|------|--------------|
| `header.css` | Styles cho header, top header, navigation | Tất cả trang |
| `footer.css` | Styles cho footer, footer accordion, newsletter | Tất cả trang |
| `front-page.css` | Styles cơ bản cho trang chủ | Chỉ trang chủ |
| `front-page-enhanced.css` | Styles nâng cao cho trang chủ (hero, sections) | Chỉ trang chủ |
| `product.css` | Styles cho trang sản phẩm (single & archive) | Trang sản phẩm |
| `projects.css` | Styles cho trang dự án | Trang dự án |

### **2. Components** (`assets/css/components/`)

CSS cho các component nhỏ, có thể tái sử dụng ở nhiều nơi.

| File | Mô tả | Load khi nào |
|------|------|--------------|
| `mobile.css` | Mobile optimization, responsive styles | Tất cả trang |
| `caption.css` | WordPress caption responsive styles | Trang blog/posts |
| `modal.css` | Modal, popup styles | Khi cần |
| `product-image.css` | Product image square ratio, gallery | Trang sản phẩm |
| `product-tabs.css` | Product tabs styling | Trang single product |

### **3. Pages** (`assets/css/pages/`)

CSS cho các trang cụ thể, template riêng.

| File | Mô tả | Load khi nào |
|------|------|--------------|
| `company-profile.css` | Trang Hồ sơ năng lực | Template `page-ho-so-nang-luc.php` |
| `project-archive.css` | Trang archive dự án | Archive project |

### **4. Admin** (`assets/css/admin/`)

CSS cho admin panel.

| File | Mô tả |
|------|------|
| `company-info.css` | Admin styles cho quản lý thông tin công ty |

---

## 📜 JavaScript Structure

### **1. Main Script** (`assets/js/main.js`)

File JavaScript chính, chứa các tính năng chung:
- Smooth scrolling
- Back to top button
- Form validation
- Card hover effects
- Mobile menu
- Header features (DateTime, Weather)
- Footer functionality (accordion, newsletter)

**Load:** Tất cả trang

### **2. Modules** (`assets/js/modules/`)

JavaScript cho các module lớn, load theo điều kiện.

| File | Mô tả | Load khi nào |
|------|------|--------------|
| `carousel.js` | Reusable carousel function | Trang chủ |
| `counter.js` | Counter animation | Trang chủ |
| `front-page.js` | Front page specific JS | Trang chủ |
| `single-product.js` | Single product page JS | Trang single product |

### **3. Components** (`assets/js/components/`)

JavaScript cho các component nhỏ.

| File | Mô tả | Load khi nào |
|------|------|--------------|
| `partner-slider.js` | Partner slider functionality | Trang chủ, trang đối tác |
| `product-tabs.js` | Product tabs functionality | Trang single product |

---

## 🔄 Quy tắc Enqueue

Tất cả CSS và JS được enqueue trong function `tdclassic_scripts()` trong file `functions.php`.

### **CSS Enqueue Order:**

1. **External Libraries** (Bootstrap, Font Awesome)
2. **Base Theme Stylesheet** (`style.css`)
3. **Global Modules** (header, footer, mobile)
4. **Conditional Modules** (front-page, product, projects)
5. **Components** (theo nhu cầu)
6. **Pages** (theo template)

### **JS Enqueue Order:**

1. **External Libraries** (Bootstrap JS)
2. **Main Script** (`main.js`)
3. **Modules** (theo điều kiện)
4. **Components** (theo điều kiện)

---

## 📝 Quy tắc đặt tên

### **CSS:**
- **Modules:** `kebab-case.css` (ví dụ: `front-page.css`, `single-product.css`)
- **Components:** `kebab-case.css` (ví dụ: `product-tabs.css`, `mobile.css`)
- **Pages:** `kebab-case.css` (ví dụ: `company-profile.css`)

### **JavaScript:**
- **Main:** `main.js`
- **Modules:** `kebab-case.js` (ví dụ: `carousel.js`, `front-page.js`)
- **Components:** `kebab-case.js` (ví dụ: `product-tabs.js`)

---

## ✅ Best Practices

1. **Không có inline CSS/JS** trong templates
   - Tất cả CSS phải nằm trong file `.css`
   - Tất cả JS phải nằm trong file `.js`
   - Enqueue đúng cách qua `wp_enqueue_style()` và `wp_enqueue_script()`

2. **Tổ chức theo chức năng:**
   - CSS/JS cho header → `modules/header.*`
   - CSS/JS cho component nhỏ → `components/*`
   - CSS/JS cho trang cụ thể → `pages/*`

3. **Conditional Loading:**
   - Chỉ load CSS/JS khi cần thiết
   - Sử dụng WordPress conditional tags (`is_front_page()`, `is_singular()`, etc.)

4. **Dependencies:**
   - Khai báo đúng dependencies khi enqueue
   - Ví dụ: `front-page.js` depends on `carousel.js` và `counter.js`

---

## 🔍 Tìm file nhanh

### **Tôi muốn sửa style cho header:**
→ `assets/css/modules/header.css`

### **Tôi muốn sửa style cho footer:**
→ `assets/css/modules/footer.css`

### **Tôi muốn sửa style cho trang chủ:**
→ `assets/css/modules/front-page.css` hoặc `front-page-enhanced.css`

### **Tôi muốn sửa style cho sản phẩm:**
→ `assets/css/modules/product.css` và `assets/css/components/product-image.css`

### **Tôi muốn sửa JavaScript cho carousel:**
→ `assets/js/modules/carousel.js`

### **Tôi muốn sửa JavaScript chung (header, footer):**
→ `assets/js/main.js`

---

## 📚 Tài liệu liên quan

- `functions.php` - Nơi enqueue tất cả CSS/JS
- `README.md` - Tài liệu tổng quan theme
- `CHANGELOG.md` - Lịch sử thay đổi

---

## 🚀 Cập nhật cấu trúc

**Version 2.4.0 (2025-01-16):**
- ✅ Tổ chức lại CSS theo modules/components/pages
- ✅ Tổ chức lại JS theo modules/components
- ✅ Xóa các file CSS/JS cũ không còn sử dụng
- ✅ Cập nhật functions.php để enqueue đúng cấu trúc mới
- ✅ Loại bỏ inline CSS/JS trong templates

---

**Lưu ý:** Khi thêm file CSS/JS mới, nhớ:
1. Đặt đúng thư mục (modules/components/pages)
2. Enqueue trong `tdclassic_scripts()` với conditional loading phù hợp
3. Cập nhật file này nếu cần

