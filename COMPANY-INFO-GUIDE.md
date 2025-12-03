# Hướng dẫn Quản lý Thông tin Doanh nghiệp - TD Classic Theme

## Tổng quan

Tính năng **Quản lý Thông tin Doanh nghiệp** cho phép bạn quản lý tất cả thông tin công ty, liên hệ và hồ sơ năng lực từ một nơi duy nhất. Thông tin này sẽ tự động được đồng bộ và hiển thị trên toàn bộ website.

## Truy cập Trang Quản lý

1. Đăng nhập vào WordPress Admin
2. Trên menu bên trái, tìm mục **"Thông tin"** (có icon tòa nhà)
3. Click vào để mở trang quản lý

## Các Tab Quản lý

### Tab 1: Thông tin Doanh nghiệp

Quản lý thông tin cơ bản của công ty:

#### Tên Doanh nghiệp (*)
- Tên công ty/trang web
- Sẽ hiển thị trên tiêu đề trình duyệt và trong kết quả tìm kiếm Google
- **Đồng bộ với:** WordPress Site Title

#### Mô tả
- Slogan hoặc mô tả ngắn về doanh nghiệp
- **Đồng bộ với:** WordPress Tagline

#### Biểu tượng Trang Web (Favicon)
- Icon hiển thị trên tab trình duyệt
- **Khuyến nghị:** 512x512px, định dạng PNG hoặc ICO
- **Đồng bộ với:** WordPress Site Icon

**Cách chọn Favicon:**
1. Click nút "Chọn Favicon"
2. Upload file mới hoặc chọn từ thư viện Media
3. Click "Sử dụng hình ảnh này"

#### Logo Trang Web
- Logo hiển thị trên header website
- **Khuyến nghị:** Chiều cao 50-80px, nền trong suốt (PNG)
- **Đồng bộ với:** WordPress Custom Logo (Customizer)

**Cách chọn Logo:**
1. Click nút "Chọn Logo"
2. Upload file mới hoặc chọn từ thư viện Media
3. Click "Sử dụng hình ảnh này"

#### Meta Description
- Mô tả trang web cho SEO (Search Engine Optimization)
- Hiển thị trong kết quả tìm kiếm Google
- **Giới hạn:** 160 ký tự
- Bộ đếm ký tự sẽ đổi màu:
  - 🟢 Xanh lá: Còn nhiều ký tự (>20)
  - 🟡 Vàng: Gần đầy (≤20)
  - 🔴 Đỏ: Vượt giới hạn

#### Link Trang Web
- URL chính thức của website
- **Lưu ý:** Phải bao gồm `https://`
- **Đồng bộ với:** WordPress Site URL

---

### Tab 2: Liên hệ Doanh nghiệp

Quản lý các thông tin liên hệ của công ty:

#### Số Điện thoại Liên hệ
- **Định dạng:** Mỗi số điện thoại trên một dòng
- Số điện thoại đầu tiên sẽ được sử dụng làm **số chính**
- Số chính hiển thị trên header và footer

**Ví dụ:**
```
+84 904 433 799
0904 433 799
(024) 1234 5678
```

#### Email Liên hệ
- **Định dạng:** Mỗi email trên một dòng
- Email đầu tiên sẽ được sử dụng làm **email chính**
- Email chính hiển thị trên header và footer

**Ví dụ:**
```
info@tdclassic.vn
sales@tdclassic.vn
support@tdclassic.vn
```

#### Địa chỉ
- **Định dạng:** Mỗi địa chỉ trên một dòng
- Địa chỉ đầu tiên sẽ được sử dụng làm **địa chỉ chính**
- Địa chỉ chính hiển thị trên footer và trang liên hệ

**Ví dụ:**
```
Số 22A Ngô Quyền, phường Ngô Quyền, TP. Hải Phòng
Văn phòng chi nhánh: 123 Đường ABC, Quận XYZ, TP. HCM
Showroom: 456 Đường DEF, Quận GHI, TP. Hà Nội
```

#### Nơi hiển thị thông tin liên hệ:
- ✅ Header - Thanh thông tin liên hệ phía trên
- ✅ Footer - Thông tin công ty và liên hệ
- ✅ Trang Liên hệ - Form và thông tin công ty
- ✅ Trang Đại lý - Thông tin chi tiết từng đại lý

---

### Tab 3: Hồ sơ Năng lực

Quản lý file PDF hồ sơ năng lực công ty:

#### File Hồ sơ Năng lực (PDF)
- Upload file PDF giới thiệu về công ty, năng lực, dịch vụ
- File sẽ hiển thị trên trang "Hồ sơ năng lực"
- Người dùng có thể xem trực tuyến hoặc tải về

**Cách chọn file PDF:**
1. Click nút "Chọn file PDF"
2. Upload file PDF mới hoặc chọn từ thư viện Media
3. Chỉ chấp nhận file định dạng `.pdf`
4. Click "Chọn file này"
5. URL file sẽ tự động điền vào ô input

**Xem file đã chọn:**
- Sau khi chọn file, phần "File hiện tại" sẽ hiển thị
- Click "Xem PDF" để mở file trong tab mới

**Trang hiển thị:**
- Tạo trang mới với slug: `ho-so-nang-luc`
- Sử dụng template: `page-ho-so-nang-luc.php`
- Hoặc dùng shortcode: `[tdclassic_company_profile]`

---

## Lưu Thay đổi

- Sau khi chỉnh sửa thông tin ở bất kỳ tab nào
- Click nút **"Lưu Thay đổi"** ở cuối trang
- Thông báo "Đã lưu thay đổi thành công!" sẽ hiển thị

---

## Sử dụng Thông tin trong Template

### PHP Functions có sẵn

#### Lấy thông tin đơn (Primary)
```php
// Lấy số điện thoại chính
<?php echo tdclassic_get_primary_phone(); ?>

// Lấy email chính
<?php echo tdclassic_get_primary_email(); ?>

// Lấy địa chỉ chính
<?php echo tdclassic_get_primary_address(); ?>
```

#### Lấy tất cả thông tin (Array)
```php
// Lấy tất cả số điện thoại
<?php $phones = tdclassic_get_company_phones(); ?>

// Lấy tất cả email
<?php $emails = tdclassic_get_company_emails(); ?>

// Lấy tất cả địa chỉ
<?php $addresses = tdclassic_get_company_addresses(); ?>
```

#### Hiển thị với link
```php
// Hiển thị số điện thoại chính với link tel:
<?php tdclassic_display_phone(); ?>

// Hiển thị email chính với link mailto:
<?php tdclassic_display_email(); ?>

// Hiển thị địa chỉ chính
<?php tdclassic_display_address(); ?>
```

#### Hiển thị tất cả thông tin
```php
// Hiển thị tất cả số điện thoại (mỗi số một dòng)
<?php tdclassic_display_all_phones(); ?>

// Hiển thị tất cả email (mỗi email một dòng)
<?php tdclassic_display_all_emails(); ?>

// Hiển thị tất cả địa chỉ (mỗi địa chỉ một dòng)
<?php tdclassic_display_all_addresses(); ?>

// Hiển thị block liên hệ đầy đủ
<?php tdclassic_display_contact_block(); ?>
```

### Ví dụ sử dụng

#### Trong template page-lien-he.php
```php
<div class="contact-info">
    <h3>Liên hệ với chúng tôi</h3>
    
    <div class="phones">
        <strong>Điện thoại:</strong>
        <?php tdclassic_display_all_phones('<br>'); ?>
    </div>
    
    <div class="emails">
        <strong>Email:</strong>
        <?php tdclassic_display_all_emails('<br>'); ?>
    </div>
    
    <div class="addresses">
        <strong>Địa chỉ:</strong>
        <?php tdclassic_display_all_addresses('<br>'); ?>
    </div>
</div>
```

#### Trong footer.php
```php
<div class="footer-contact">
    <p><i class="fas fa-phone"></i> <?php tdclassic_display_phone(); ?></p>
    <p><i class="fas fa-envelope"></i> <?php tdclassic_display_email(); ?></p>
    <p><i class="fas fa-map-marker-alt"></i> <?php tdclassic_display_address(); ?></p>
</div>
```

---

## Đồng bộ với WordPress

Hệ thống tự động đồng bộ với các cài đặt WordPress:

| Thông tin | Lưu tại TD Classic | Đồng bộ với WordPress |
|-----------|-------------------|----------------------|
| Tên doanh nghiệp | `tdclassic_company_name` | `blogname` (Site Title) |
| Mô tả | `tdclassic_company_description` | `blogdescription` (Tagline) |
| Favicon | `tdclassic_site_icon` | `site_icon` |
| Logo | `tdclassic_company_logo` | `custom_logo` (Theme Mod) |
| Link website | `tdclassic_site_url` | `siteurl`, `home` |
| SĐT chính | `tdclassic_company_phone` | - |
| Email chính | `tdclassic_company_email` | - |
| Địa chỉ chính | `tdclassic_company_address` | - |

---

## Backward Compatibility

Hệ thống mới hoàn toàn tương thích ngược (backward compatible) với code cũ:

- ✅ Tất cả functions cũ vẫn hoạt động bình thường
- ✅ Theme templates không cần chỉnh sửa
- ✅ Dữ liệu cũ được tự động migrate sang hệ thống mới
- ✅ Cả hai hệ thống (cũ và mới) đều được đồng bộ

---

## Câu hỏi thường gặp (FAQ)

### 1. Tôi có thể có bao nhiêu số điện thoại/email/địa chỉ?
- **Không giới hạn** số lượng
- Mỗi thông tin trên một dòng
- Thông tin đầu tiên sẽ là thông tin chính

### 2. Favicon và Logo có bắt buộc không?
- **Không bắt buộc**, nhưng **khuyến nghị nên có**
- Favicon giúp website trông chuyên nghiệp hơn
- Logo là nhận diện thương hiệu quan trọng

### 3. Meta Description có bắt buộc phải đúng 160 ký tự không?
- **Không bắt buộc**, nhưng **khuyến nghị 150-160 ký tự**
- Google sẽ cắt bớt nếu quá dài
- Quá ngắn thì không tận dụng được không gian hiển thị

### 4. Thay đổi thông tin có cần xóa cache không?
- **Nên xóa cache** sau khi thay đổi
- Nếu dùng plugin cache (WP Super Cache, W3 Total Cache, etc.)
- Nếu dùng CDN (Cloudflare, etc.)

### 5. Tôi có thể sử dụng HTML trong địa chỉ/mô tả không?
- **Không nên** vì lý do bảo mật
- Hệ thống sẽ tự động escape HTML
- Dùng plain text đơn giản

---

## Hỗ trợ

Nếu cần hỗ trợ thêm:
- 📧 Email: support@tdclassic.vn
- 📞 Hotline: +84 904 433 799
- 🌐 Website: https://tdclassic.vn

---

**Phiên bản:** 1.0.0  
**Cập nhật lần cuối:** Tháng 1, 2025  
**Theme:** TD Classic

