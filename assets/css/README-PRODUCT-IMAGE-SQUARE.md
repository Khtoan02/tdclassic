# Product Image Square CSS - TD Classic Theme

## Tổng quan

File CSS này được thiết kế để đảm bảo tất cả hình ảnh sản phẩm trên website TD Classic đều có tỉ lệ 1:1 (hình vuông), tạo ra giao diện nhất quán và chuyên nghiệp.

## Tính năng chính

### 1. Tỉ lệ hình ảnh 1:1 (Hình vuông)
- **Aspect Ratio**: Sử dụng `aspect-ratio: 1/1` để tạo tỉ lệ hình vuông hoàn hảo
- **Responsive**: Tự động điều chỉnh kích thước theo container
- **Consistent**: Tất cả hình ảnh sản phẩm đều có cùng tỉ lệ

### 2. Object Fit Optimization
- **Cover**: Hình ảnh được cắt và căn giữa để lấp đầy container
- **Center**: Hình ảnh được căn giữa để hiển thị phần quan trọng nhất
- **Smooth**: Transition mượt mà khi hover

### 3. Universal Coverage
- **All Product Images**: Áp dụng cho tất cả hình ảnh sản phẩm
- **All Pages**: Hoạt động trên tất cả các trang
- **All Components**: Bao gồm grid, carousel, single product, etc.

## Các selector được hỗ trợ

### Product Image Containers
```css
.product-image,
.product-thumbnail,
.product-img,
.product-picture,
.product-photo
```

### WooCommerce Specific
```css
.woocommerce ul.products li.product .product-image
.woocommerce .woocommerce-product-gallery
.woocommerce .cart .cart_item .product-thumbnail
```

### Product Grid Layouts
```css
.products-container .product-image
.products-grid .product-image
.archive-product .product-image
.page-san-pham .product-image
```

### Carousels and Sliders
```css
.products-carousel .product-image
.news-carousel .product-image
.tdc-product-grid .product-image
```

### Related Products
```css
.related-products .product-image
.other-products-section .product-image
.cross-sells .product-image
.upsells .product-image
```

## Cách hoạt động

### 1. Aspect Ratio 1:1
```css
.product-image {
  aspect-ratio: 1/1 !important;
  width: 100%;
  overflow: hidden;
}
```

### 2. Image Object Fit
```css
.product-image img {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  object-position: center !important;
}
```

### 3. Responsive Design
```css
@media (max-width: 768px) {
  .product-image {
    aspect-ratio: 1/1 !important;
    max-height: 200px;
  }
}
```

## Tương thích

### Browsers hỗ trợ
- **Modern Browsers**: Chrome 88+, Firefox 87+, Safari 14+, Edge 88+
- **Aspect Ratio**: Sử dụng CSS `aspect-ratio` property
- **Fallback**: Tự động fallback cho các browser cũ

### WordPress & WooCommerce
- **WordPress**: Tương thích hoàn toàn
- **WooCommerce**: Hỗ trợ đầy đủ các tính năng
- **Custom Themes**: Hoạt động với mọi theme

## Responsive Breakpoints

### Desktop (1024px+)
- Grid: 3-4 cột
- Image size: Full container width
- Aspect ratio: 1:1

### Tablet (768px - 1024px)
- Grid: 2 cột
- Image size: Full container width
- Aspect ratio: 1:1

### Mobile (480px - 768px)
- Grid: 2 cột
- Image size: Full container width
- Max height: 200px
- Aspect ratio: 1:1

### Small Mobile (< 480px)
- Grid: 1 cột
- Image size: Full container width
- Max height: 150px
- Aspect ratio: 1:1

## Tùy chỉnh

### Thay đổi tỉ lệ
```css
.product-image {
  aspect-ratio: 4/3; /* Tỉ lệ 4:3 */
  /* hoặc */
  aspect-ratio: 16/9; /* Tỉ lệ 16:9 */
}
```

### Thay đổi object-fit
```css
.product-image img {
  object-fit: contain; /* Hiển thị toàn bộ hình ảnh */
  /* hoặc */
  object-fit: fill; /* Kéo giãn hình ảnh */
}
```

### Thay đổi border radius
```css
.product-image {
  border-radius: 0; /* Không bo góc */
  /* hoặc */
  border-radius: 16px; /* Bo góc lớn hơn */
}
```

## Troubleshooting

### 1. Hình ảnh không vuông
- Kiểm tra CSS có được load không
- Đảm bảo không có CSS khác override
- Kiểm tra browser support cho `aspect-ratio`

### 2. Hình ảnh bị méo
- Kiểm tra `object-fit: cover`
- Đảm bảo `object-position: center`
- Kiểm tra container có đúng width không

### 3. Responsive không hoạt động
- Kiểm tra media queries
- Đảm bảo CSS được load đúng thứ tự
- Kiểm tra CSS specificity

## Performance

### CSS Optimization
- Sử dụng `!important` để đảm bảo override
- Minimal CSS rules
- Efficient selectors

### Browser Performance
- `aspect-ratio` được hỗ trợ native
- `object-fit` được tối ưu hóa
- Smooth transitions với `will-change`

## Cập nhật

### Version 1.0.0
- Aspect ratio 1:1 cho tất cả hình ảnh sản phẩm
- Object-fit cover và center
- Responsive design
- WooCommerce integration
- Universal selector coverage

## Tác giả

Khánh Toàn - TD Classic Theme
Version: 1.0.0
Date: 2025

## Chú ý

- CSS này sẽ override tất cả CSS khác liên quan đến hình ảnh sản phẩm
- Sử dụng `!important` để đảm bảo tính ưu tiên
- Tương thích với mobile optimization CSS
- Không ảnh hưởng đến layout và spacing
