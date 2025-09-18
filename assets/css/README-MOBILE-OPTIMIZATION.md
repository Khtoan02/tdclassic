# Mobile Optimization CSS - TD Classic Theme

## Tổng quan

File CSS này được thiết kế để tối ưu hóa giao diện mobile cho theme TD Classic với các tính năng chính:

### 1. Font Size Optimization (2/3 của Desktop)

- **Body text**: 14px (2/3 của 21px)
- **H1**: 1.67rem (2/3 của 2.5rem)
- **H2**: 1.33rem (2/3 của 2rem)
- **H3**: 1rem (2/3 của 1.5rem)
- **H4**: 0.83rem (2/3 của 1.25rem)
- **H5**: 0.75rem (2/3 của 1.125rem)
- **H6**: 0.67rem (2/3 của 1rem)
- **Paragraphs**: 0.93rem (2/3 của 1.4rem)
- **Buttons**: 0.87rem (2/3 của 1.3rem)
- **Form elements**: 0.87rem (2/3 của 1.3rem)

### 2. Layout Optimization

- **Product Grid**: 2 cột trên mobile (thay vì 3-4 cột trên desktop)
- **Footer**: 2 cột cho footer-left (thay vì 3 cột)
- **Spacing**: Giảm margin và padding để tiết kiệm không gian

### 3. Responsive Breakpoints

- **Tablet**: max-width: 768px
- **Mobile**: max-width: 480px

## Cách sử dụng

### 1. File đã được tự động load

CSS này đã được thêm vào `functions.php` và sẽ tự động load trên tất cả các trang.

### 2. Kiểm tra hoạt động

- Mở website trên mobile hoặc sử dụng Developer Tools
- Kiểm tra font size của các element
- Kiểm tra layout grid sản phẩm (2 cột)
- Kiểm tra footer layout (2 cột)

### 3. Tùy chỉnh

Nếu muốn thay đổi font size, chỉnh sửa các giá trị trong file CSS:

```css
@media (max-width: 768px) {
  body {
    font-size: 14px; /* Thay đổi giá trị này */
  }

  h1 {
    font-size: 1.67rem; /* Thay đổi giá trị này */
  }
}
```

## Các tính năng chính

### Typography

- Tất cả text elements đều có font size nhỏ hơn bằng 2/3 so với desktop
- Sử dụng `!important` để đảm bảo override các CSS khác
- Responsive font sizes cho các breakpoint khác nhau

### Grid Layout

- **Products**: 2 cột trên mobile
- **Footer**: 2 cột cho footer-left
- **Spacing**: Giảm gap và margin

### Form Elements

- Input fields, buttons, labels đều có font size nhỏ hơn
- Padding và margin được tối ưu hóa cho mobile

### WooCommerce Integration

- Tương thích với WooCommerce
- Product grid: 2 cột
- Product titles, prices, buttons đều được tối ưu

## Troubleshooting

### 1. Font size không thay đổi

- Kiểm tra xem CSS có được load không
- Kiểm tra console để xem có lỗi CSS không
- Đảm bảo không có CSS khác override

### 2. Layout không đúng

- Kiểm tra CSS specificity
- Sử dụng `!important` nếu cần
- Kiểm tra CSS conflicts

### 3. Performance

- CSS được minify để tối ưu performance
- Sử dụng media queries để chỉ load CSS cần thiết

## Cập nhật

### Version 1.0.0

- Font size optimization (2/3 của desktop)
- Product grid: 2 cột
- Footer layout: 2 cột
- Responsive breakpoints
- WooCommerce integration

## Tác giả

Khánh Toàn - TD Classic Theme
Version: 1.0.0
Date: 2025
