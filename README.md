# TD Classic® WordPress Theme v1.32.8

Một theme WordPress đơn giản, tinh gọn với thiết kế hiện đại sử dụng màu sắc chủ đạo đen, xám, trắng.

**Latest Update**: Version 1.32.8 - Mobile Optimization & Product Image Square Ratio

## Tính năng chính

- **Thiết kế đơn giản**: Giao diện sạch sẽ, tối ưu UX/UI
- **Responsive**: Tương thích với mọi thiết bị
- **Bootstrap 5**: Sử dụng framework Bootstrap mới nhất
- **Custom Post Types**: Hỗ trợ Sản phẩm và Dự án
- **SEO Friendly**: Tối ưu cho công cụ tìm kiếm
- **Fast Loading**: Tải nhanh, hiệu suất cao
- **Modern Navigation**: Menu dropdown với danh mục và icon
- **DateTime Widget**: Hiển thị thời gian thực
- **Weather Widget**: Thời tiết theo vị trí với geolocation
- **Smart Icons**: Icon tự động cho danh mục

### 🆕 Tính năng mới trong v1.32.8

- **📱 Mobile Optimization**: Font size 2/3 desktop, grid 2 cột, footer 2 cột
- **🖼️ Product Image Square**: Tất cả hình ảnh sản phẩm có tỉ lệ 1:1
- **🎨 Enhanced Responsive**: Hero section tối ưu, mobile-first approach
- **⚡ Performance**: CSS tối ưu, modern properties, WooCommerce integration

## Cấu trúc trang

### Trang chủ

- Hero Section với call-to-action
- Giới thiệu về doanh nghiệp
- Dịch vụ nổi bật
- Dự án mới nhất
- Tin tức mới nhất

### Trang sản phẩm

- Hiển thị grid sản phẩm
- Phân trang
- Responsive design

### Trang Blog

- Danh sách bài viết
- Thumbnail và excerpt
- Thông tin meta (tác giả, ngày, danh mục)

### Trang dự án

- Tương tự blog nhưng cho dự án
- Trạng thái dự án
- Thông tin đặc biệt

### Trang tin tức (/tin-tuc/)

- Hiển thị bài viết với sidebar
- Tìm kiếm
- Danh mục và tags
- Phân trang

### Trang danh mục bài viết

- Hiển thị bài viết theo danh mục
- Breadcrumb navigation
- Sidebar với thông tin danh mục

### Trang danh mục sản phẩm

- Hiển thị sản phẩm theo danh mục
- Bộ lọc và sắp xếp
- Danh mục liên quan

### Trang danh mục dự án

- Hiển thị dự án theo danh mục
- Thống kê dự án
- Call-to-action

### Trang liên hệ (/lien-he/)

- Form liên hệ đầy đủ
- Thông tin liên hệ
- Bản đồ Google Maps
- FAQ section
- Xử lý form qua AJAX

## Cài đặt

1. Upload thư mục theme vào `/wp-content/themes/`
2. Vào WordPress Admin > Appearance > Themes
3. Kích hoạt theme "TD Classic®"
4. Cấu hình menu tại Appearance > Menus
5. Tạo menu "Primary Menu" với các link:
   - Trang chủ
   - Sản phẩm
   - Blog
   - Dự án
6. (Tùy chọn) Cấu hình Weather API:
   - Vào Settings > General
   - Nhập OpenWeatherMap API Key
   - Lấy API key miễn phí tại https://openweathermap.org/

## Custom Post Types

Theme tự động tạo 2 custom post types:

### Sản phẩm (Products)

- Slug: `/san-pham`
- Hỗ trợ: title, editor, thumbnail, excerpt
- Template: `archive-product.php`, `single-product.php`

### Dự án (Projects)

- Slug: `/du-an`
- Hỗ trợ: title, editor, thumbnail, excerpt
- Template: `archive-project.php`, `single-project.php`

## Widget Areas

Theme có 3 widget areas trong footer:

- Footer Widget Area 1
- Footer Widget Area 2
- Footer Widget Area 3

## Customization

### Màu sắc

Theme sử dụng màu sắc chủ đạo:

- Đen: `#000000`
- Xám: `#666666`, `#999999`
- Trắng: `#ffffff`
- Xám nhạt: `#f8f9fa`

### Fonts

- Hệ thống font: `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto`
- Font weight: 400, 500, 600, 700

### Breakpoints

- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

### Navigation Features

- **Dropdown Menu**: Hover để hiển thị danh mục
- **Smart Icons**: Icon tự động dựa trên tên danh mục
- **Badge Count**: Hiển thị số lượng bài viết/sản phẩm
- **Responsive**: Tương thích mobile với toggle menu

### Weather Widget

- **Real-time**: Cập nhật thời tiết theo thời gian thực với OpenWeatherMap API
- **Geolocation**: Tự động lấy vị trí hiện tại với GPS và reverse geocoding
- **Multi-location**: Hỗ trợ 5 thành phố lớn tại Việt Nam + vị trí hiện tại
- **Location Display**: Hiển thị tên địa điểm chính xác khi dùng GPS
- **Smart Caching**: Cache 10 phút để tối ưu performance
- **Auto-refresh**: Tự động làm mới mỗi 15 phút
- **Fallback**: Dữ liệu mẫu nhất quán khi không có API
- **API Setup**: Cấu hình API key tại Settings → General

### DateTime Widget

- **Live Clock**: Đồng hồ thời gian thực
- **Vietnamese Format**: Định dạng ngày tháng Việt Nam
- **Auto Update**: Tự động cập nhật mỗi giây

### Audio-Themed Header Effects

- **Speaker Mesh Pattern**: Background pattern lưới loa với dots pattern
- **Sound Wave Animation**: Hiệu ứng sóng âm thanh chuyển động
- **Speaker Icons**: Icons loa pulse ở hai góc header
- **Equalizer Bars**: Thanh equalizer animation bên logo
- **Audio Visualization**: Hiệu ứng hover cho navigation links
- **Logo Pulse**: Hiệu ứng pulse tinh tế cho logo
- **Mobile Optimized**: Tự động disable animation phức tạp trên mobile

**Tùy chỉnh hiệu ứng:**

- Chỉnh opacity patterns tại `.site-header::before`
- Thay đổi tốc độ animation tại các `@keyframes`
- Disable hiệu ứng bằng cách comment CSS tương ứng
- Responsive breakpoints tại media query cuối file

## File Structure

```
tdclassic/
├── style.css                        # Theme stylesheet
├── functions.php                   # Theme functions
├── index.php                       # Homepage template
├── header.php                      # Header template
├── footer.php                      # Footer template
├── single.php                      # Single post template
├── home.php                        # Blog page template
├── page-tin-tuc.php               # News page template
├── page-lien-he.php               # Contact page template
├── category.php                    # Category archive template
├── archive-product.php             # Product archive template
├── archive-project.php             # Project archive template
├── taxonomy-product_category.php   # Product category template
├── taxonomy-project_category.php   # Project category template
├── single-product.php              # Single product template
├── single-project.php              # Single project template
├── js/
│   └── script.js                   # Theme JavaScript
└── README.md                       # This file
```

## Tối ưu hóa

### Performance

- Minified CSS/JS
- Lazy loading images
- Optimized queries
- Clean HTML structure

### SEO

- Structured data
- Meta tags
- Clean URLs
- Fast loading

### Accessibility

- ARIA labels
- Keyboard navigation
- Screen reader friendly
- High contrast ratio

## Hỗ trợ

Nếu bạn có câu hỏi hoặc cần hỗ trợ, vui lòng liên hệ:

- Email: cskh.tdclassic@gmail.com
- Phone: +84 123 456 789

## Cấu trúc file

### Core Files

- `style.css` - Main theme stylesheet (v1.32.8)
- `functions.php` - Theme functions và enqueue scripts
- `index.php` - Main template file
- `header.php` - Header template
- `footer.php` - Footer template

### CSS Files

- `/assets/css/mobile-optimization.css` - Mobile optimization CSS
- `/assets/css/product-image-square.css` - Product image square ratio CSS
- `/assets/css/front-page.css` - Front page specific styles
- `/assets/css/single-product.css` - Single product page styles

### Documentation

- `/CHANGELOG.md` - Detailed changelog
- `/assets/css/README-MOBILE-OPTIMIZATION.md` - Mobile optimization guide
- `/assets/css/README-PRODUCT-IMAGE-SQUARE.md` - Product image square guide

## Changelog

### Version 1.32.8 (Latest)

- **📱 Mobile Optimization**: Font size 2/3 desktop, grid 2 cột, footer 2 cột
- **🖼️ Product Image Square**: Tất cả hình ảnh sản phẩm có tỉ lệ 1:1
- **🎨 Enhanced Responsive**: Hero section tối ưu, mobile-first approach
- **⚡ Performance**: CSS tối ưu, modern properties, WooCommerce integration
- **🔧 CSS Organization**: Tách biệt CSS thành các file riêng biệt
- **📱 Responsive Breakpoints**: Desktop, Tablet, Mobile, Small Mobile
- **🖼️ Universal Coverage**: Tất cả trang và component được tối ưu

### Version 1.2.4

- **Audio-Themed Header**: Thêm hiệu ứng âm thanh chuyên nghiệp cho header
- **Speaker Mesh Pattern**: Background pattern lưới loa tinh tế
- **Sound Wave Animation**: Hiệu ứng sóng âm thanh chuyển động
- **Equalizer Bars**: Thanh equalizer animation bên logo
- **Speaker Icons**: Icons loa pulse ở hai góc header
- **Audio Visualization**: Hiệu ứng hover cho navigation
- **Mobile Optimized**: Tối ưu hiệu ứng cho mobile performance

### Version 1.2.3

- **WooCommerce Integration**: Chuyển sang sử dụng WooCommerce product categories
- **Audio Equipment Icons**: Thêm icons chuyên dụng cho thiết bị âm thanh
- **Template Update**: Tạo taxonomy-product_cat.php cho WooCommerce
- **Remove Sample Data**: Disable tạo sample categories/products
- **Better Compatibility**: Tích hợp hoàn toàn với WooCommerce

### Version 1.2.2

- **Menu Highlight Fix**: Sửa lỗi trang chủ luôn được highlight
- **Product Categories**: Tự động tạo sample categories nếu chưa có
- **Enhanced Icons**: Thêm nhiều icons cho product categories
- **Better Navigation**: Cải thiện logic active menu items
- **Dropdown Fallback**: Hiển thị thông báo nếu chưa có danh mục

### Version 1.2.1

- **Geolocation Fix**: Sửa lỗi hiển thị địa chỉ khi dùng GPS
- **Reverse Geocoding**: Tự động lấy tên địa điểm từ tọa độ GPS
- **Smart Location Display**: Hiển thị "📍 Tên địa điểm" khi dùng vị trí hiện tại
- **Persistent Location**: Lưu trữ vị trí hiện tại khi reload trang
- **Enhanced UI**: Animation loading cho nút định vị
- **Better UX**: Dropdown tự động cập nhật theo vị trí thực tế

### Version 1.2

- **Weather Bug Fix**: Sửa lỗi thời tiết thay đổi khi reload
- **Real-time Weather**: Tích hợp OpenWeatherMap API thực tế
- **Smart Caching**: Cache 10 phút giảm gọi API
- **Auto-refresh**: Tự động cập nhật thời tiết 15 phút
- **Consistent Data**: Dữ liệu mẫu nhất quán cho mỗi vị trí
- **Enhanced Icons**: Weather icons dựa trên điều kiện thực tế
- **Error Handling**: Fallback graceful khi API lỗi
- **Admin Settings**: Cấu hình API key trong WordPress Admin

### Version 1.1

- **Modern Navigation**: Menu dropdown với danh mục và icon
- **DateTime Widget**: Hiển thị thời gian thực trong header
- **Weather Widget**: Thời tiết theo vị trí với geolocation
- **Smart Icons**: Icon tự động cho danh mục dựa trên slug
- **Enhanced Header**: Layout 2 cột với widgets
- **Weather API**: Tích hợp OpenWeatherMap API
- **Improved UX**: Hover effects và animations
- **Mobile Responsive**: Tối ưu cho mobile devices

### Version 1.0

- Initial release
- Homepage with hero section
- Product grid layout
- Blog and project templates
- Responsive design
- Bootstrap 5 integration

## License

Copyright © 2025 TD Classic®. All rights reserved.

---

**TD Classic® v1.32.8 - Đơn giản, Tinh gọn, Thông minh**

**Latest Features**: Mobile Optimization & Product Image Square Ratio
