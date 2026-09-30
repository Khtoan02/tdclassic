# TD Classic Theme - Changelog

## Version 3.0.0 - 2026-09-30

### 🚀 MAJOR REDESIGN & OPTIMIZATION

#### ✅ Tối Giản Hóa Quản Trị Thông Số Kỹ Thuật (Single Specs Table)
- **Tập trung & Tinh gọn**: Loại bỏ các metabox rườm rà thừa thãi (xóa bỏ "Điểm nổi bật", "Thông tin cơ bản", "Mô tả chi tiết bổ sung").
- **Duy nhất 1 Bảng thông số**: Quản trị chỉ gồm Mô tả sản phẩm (WordPress Editor) và 1 Bảng Thông Số Kỹ Thuật dạng Table (Tên thông số - Giá trị).

#### ✅ Tính Năng Nhận Diện & Dán Nhanh Tự Động (Smart Paste Parser)
- **Bóc tách tự động**: Hỗ trợ copy từ Excel, Google Sheets (dạng 2 cột phân cách Tab `\t`), Word, hoặc dạng văn bản `Tên: Giá trị`.
- **Dán trực tiếp (Direct Paste)**: Nhấn `Ctrl+V` / `Cmd+V` trực tiếp vào ô bất kỳ trong bảng để tự động điền hàng loạt.
- **Nút "Dán nhanh từ Excel / Văn bản"**: Khung nhập liệu trực quan với lựa chọn "Thay thế toàn bộ" hoặc "Thêm tiếp".

#### ✅ Chuẩn Hóa Hiển Thị Public (Single-Product Frontend)
- **Xóa bỏ Fallback tĩnh**: Loại bỏ triệt để các thông số giả lập cố định (450W / 98dB / Loa 12-inch) gây sai lệch cho các dòng sản phẩm khác (Micro, Vang số, Màn hình...).
- **Đồng bộ dữ liệu thực**: Bảng thông số kỹ thuật ngoài Public chỉ hiển thị đúng các dòng thực tế được nhập từ Admin.
- **Tự động ẩn thông minh**: Sản phẩm nào chưa nhập thông số thì bảng sẽ tự động ẩn đi hoàn toàn.

---

## Version 1.32.8 - 2025-01-XX

### 🚀 NEW FEATURES

#### ✅ Mobile Optimization CSS Integration

- **Font Size Optimization**: Font size trên mobile bằng 2/3 so với desktop
- **Product Grid Layout**: Grid sản phẩm 2 cột trên mobile
- **Footer Layout**: Footer-left chia làm 2 cột trên mobile
- **Responsive Typography**: Tất cả text elements được tối ưu cho mobile
- **Spacing Optimization**: Giảm margin và padding để tiết kiệm không gian

#### ✅ Product Image Square Ratio 1:1

- **Universal Coverage**: Tất cả hình ảnh sản phẩm có tỉ lệ 1:1
- **All Pages**: Hoạt động trên mọi trang và component
- **WooCommerce Integration**: Tương thích hoàn toàn với WooCommerce
- **Responsive Design**: Sử dụng `aspect-ratio: 1/1` hiện đại

#### ✅ Enhanced Responsive Design

- **Hero Section**: Thay đổi từ `min-height: 80vh` sang `max-height: 40vh`
- **Mobile-First Approach**: Tối ưu hóa cho mobile trước
- **Optimized Spacing**: Spacing và typography được tối ưu hóa

### 🔧 IMPROVEMENTS

#### ✅ CSS Organization & Structure

- Tách biệt CSS thành các file riêng biệt theo chức năng
- Cấu trúc CSS rõ ràng và dễ bảo trì
- Sử dụng CSS variables và modern properties

#### ✅ Performance Optimization

- CSS được minify và tối ưu hóa
- Sử dụng `!important` một cách hợp lý
- Efficient selectors và minimal CSS rules

#### ✅ Browser Compatibility

- Hỗ trợ modern browsers (Chrome 88+, Firefox 87+, Safari 14+, Edge 88+)
- Sử dụng CSS properties hiện đại như `aspect-ratio`
- Fallback cho các browser cũ

#### ✅ WooCommerce Integration

- Tương thích hoàn toàn với WooCommerce
- Product grid, single product, cart, checkout
- Custom WooCommerce blocks

### 📁 FILES ADDED

#### ✅ CSS Files

- `/assets/css/mobile-optimization.css` - Mobile optimization CSS
- `/assets/css/product-image-square.css` - Product image square ratio CSS

#### ✅ Documentation Files

- `/assets/css/README-MOBILE-OPTIMIZATION.md` - Mobile optimization guide
- `/assets/css/README-PRODUCT-IMAGE-SQUARE.md` - Product image square guide
- `/CHANGELOG.md` - This changelog file

### 🎯 TECHNICAL DETAILS

#### Mobile Optimization Features

```css
/* Font size: 2/3 của desktop */
@media (max-width: 768px) {
  body {
    font-size: 14px;
  }
  h1 {
    font-size: 1.67rem;
  } /* 2/3 của 2.5rem */
  h2 {
    font-size: 1.33rem;
  } /* 2/3 của 2rem */
  /* ... */
}
```

#### Product Image Square Features

```css
/* Tất cả hình ảnh sản phẩm có tỉ lệ 1:1 */
.product-image,
.product-thumbnail,
.product-img {
  aspect-ratio: 1/1 !important;
  width: 100%;
  overflow: hidden;
}
```

#### Responsive Breakpoints

- **Desktop**: 1024px+
- **Tablet**: 768px - 1024px
- **Mobile**: 480px - 768px
- **Small Mobile**: < 480px

### 🔄 UPDATED FILES

#### ✅ Core Files

- `style.css` - Updated to version 1.32.8
- `functions.php` - Added new CSS files loading
- `CHANGELOG.md` - New changelog file

#### ✅ CSS Files

- `mobile-optimization.css` - New mobile optimization CSS
- `product-image-square.css` - New product image square CSS

### 📱 MOBILE OPTIMIZATION CLASSES

#### Typography Classes

- `.text-sm` - Small text (0.73rem)
- `.text-md` - Medium text (0.87rem)
- `.text-lg` - Large text (1rem)

#### Spacing Classes

- `.p-1` to `.p-5` - Mobile padding utilities
- `.m-1` to `.m-5` - Mobile margin utilities

### 🖼️ PRODUCT IMAGE CLASSES

#### Universal Selectors

- `.product-image` - Main product image container
- `.product-thumbnail` - Product thumbnail
- `.product-img` - Alternative product image
- `.product-picture` - Product picture
- `.product-photo` - Product photo

#### WooCommerce Specific

- `.woocommerce ul.products li.product .product-image`
- `.woocommerce .woocommerce-product-gallery`
- `.woocommerce .cart .cart_item .product-thumbnail`

### 🚀 PERFORMANCE IMPROVEMENTS

#### CSS Optimization

- Minimal CSS rules
- Efficient selectors
- Proper CSS specificity
- Use of `!important` strategically

#### Browser Performance

- Native `aspect-ratio` support
- Optimized `object-fit` properties
- Smooth transitions with `will-change`

### 🔍 TROUBLESHOOTING

#### Common Issues

1. **Font size không thay đổi**: Kiểm tra CSS loading và specificity
2. **Hình ảnh không vuông**: Kiểm tra `aspect-ratio: 1/1` và browser support
3. **Layout không đúng**: Kiểm tra CSS conflicts và media queries

#### Solutions

- Sử dụng `!important` để override CSS khác
- Kiểm tra CSS loading order trong `functions.php`
- Đảm bảo browser support cho modern CSS properties

### 📋 FUTURE PLANS

#### Version 1.33.0

- Advanced mobile gestures
- Dark mode support
- Enhanced WooCommerce features
- Performance monitoring

#### Version 1.34.0

- PWA support
- Advanced animations
- Custom CSS variables
- Theme customization panel

### 👨‍💻 AUTHOR

**Khánh Toàn** - TD Classic Theme Developer

- **Email**: [Contact information]
- **Website**: [Website information]
- **GitHub**: [GitHub profile]

### 📄 LICENSE

TD Classic Theme is proprietary software.
All rights reserved © 2025 Khánh Toàn.

---

**Note**: This changelog documents all major changes and new features added to the TD Classic theme. For detailed technical information, please refer to the individual README files in the `/assets/css/` directory.
