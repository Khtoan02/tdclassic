# Hướng Dẫn Config Dữ Liệu Product Category Page - TD Classic

## 📋 Tổng Quan

Trang Product Category đã được thiết kế với **Luxury Dark Mode** và cần một số dữ liệu để hiển thị đầy đủ:

---

## 1️⃣ **Thông Tin Product (Sản Phẩm)**

### A. **Product Specs (Thông Số Kỹ Thuật)**

**Vị trí:** WP Admin → Products → Edit Product → Sidebar → "Thông Số Kỹ Thuật"

**Mục đích:** Hiển thị thông số ngắn gọn ngay trên product card

**Ví dụ:**
- `2-Way, 400W RMS`
- `Dual 12 inch`
- `Class D, 2000W`
- `Neodymium Driver`

**Hiển thị:** Text màu vàng gold dưới tên sản phẩm

---

### B. **Product Badge (Huy Hiệu)**

**Vị trí:** WP Admin → Products → Edit Product → Sidebar → "Huy Hiệu Sản Phẩm"

**Các giá trị:**
- 🔥 **HOT** - Sản phẩm hot/trending
- ✨ **NEW** - Sản phẩm mới
- ⭐ **BEST SELLER** - Bán chạy nhất
- ⏰ **LIMITED** - Số lượng có hạn

**Lưu ý:** 
- Nếu sản phẩm đang **Sale** (giảm giá), badge "Sale" sẽ được ưu tiên hiển thị
- Badge hiển thị ở góc trên phải của hình ảnh sản phẩm

---

## 2️⃣ **Thông Tin Category (Danh Mục)**

### A. **Category Title & Description**

**Vị trí:** WP Admin → Products → Categories → Edit Category

**Fields:**
- **Name:** Tên danh mục (VD: "Bàn Trộn Âm Thanh")
- **Description:** Mô tả ngắn về danh mục (hiển thị trong Hero section)

**Ví dụ Description:**
```
Bộ sưu tập mixer chuyên nghiệp với chất lượng âm thanh vượt trội, 
phù hợp cho studio recording, live sound và broadcast.
```

---

### B. **Category Thumbnail (Hình Ảnh)**

**Vị trí:** WP Admin → Products → Categories → Edit Category → Thumbnail

**Specs:**
- Kích thước đề xuất: 1600x900px trở lên
- Format: JPG/PNG
- Hiển thị: Background phía sau category title (opacity 20%, grayscale)

**Fallback:** Nếu không set, sẽ dùng ảnh mặc định từ Unsplash

---

### C. **Sub-Categories (Danh Mục Con)**

**Vị trí:** WP Admin → Products → Categories → Add New

**Cách tạo:**
1. Tạo category con với **Parent** = Category chính
2. VD: Category chính "Loa", Sub-categories: "Loa Passive", "Loa Active", "Loa Sub"

**Hiển thị:** 
- Thanh filter dính (sticky) ở đầu trang
- Cho phép lọc sản phẩm theo sub-category

---

## 3️⃣ **Flagship Product (Sản Phẩm Nổi Bật)**

**Logic tự động:**
- Hệ thống tự động chọn sản phẩm **ĐẮT NHẤT** trong category làm Flagship
- Hiển thị ở section lớn ngay sau Hero

**Nếu muốn custom:**
- Để sản phẩm bạn muốn nổi bật có giá cao nhất
- Hoặc đánh dấu "Featured" trong WooCommerce

---

## 4️⃣ **Technology Section (Công Nghệ)**

**Hiện tại:** Hardcoded 3 công nghệ chính:
1. Thùng Gỗ Bạch Dương
2. Củ Loa Neodymium
3. Sơn Polyurea

**Nếu muốn custom:**
- Edit file: `/wp-content/themes/tdclassic/woocommerce/taxonomy-product_cat.php`
- Tìm dòng 233-255 (Technology Highlight section)
- Thay đổi icon (Lucide), title và description

---

## 5️⃣ **Pagination Settings**

**Số sản phẩm/trang:** 
- WP Admin → WooCommerce → Settings → Products → Display
- "Products per page": Đề xuất 12 hoặc 16

---

## 🎨 **Visual Checklist**

### Hero Section ✅
- [ ] Category title hiển thị
- [ ] Description hiển thị (nếu có)
- [ ] Background image hiển thị (grayscale)

### Sticky Filter Bar ✅
- [ ] Hiển thị khi có sub-categories
- [ ] Link "Tất cả" active mặc định
- [ ] Product count hiển thị đúng

### Flagship Product ✅
- [ ] Sản phẩm đắt nhất được highlight
- [ ] Badge "Flagship Model" hiển thị
- [ ] Hover overlay với CTA button

### Product Grid ✅
- [ ] Tất cả products hiển thị
- [ ] Product specs hiển thị (nếu đã nhập)
- [ ] Badge hiển thị (Sale/Custom)
- [ ] Hover effect hoạt động (zoom image)

### Technology Section ✅
- [ ] 3 cards công nghệ hiển thị
- [ ] Icons Lucide load đúng
- [ ] Hover border gold effect

### Documentation Footer ✅
- [ ] Text pháp lý hiển thị
- [ ] Opacity 70% cho subtle look

---

## 🚀 **Quick Start Guide**

### Bước 1: Tạo Category
```
WP Admin → Products → Categories → Add New
- Name: "Bàn Trộn Âm Thanh"
- Slug: "audio-mixer"
- Description: "Bộ sưu tập mixer chuyên nghiệp..."
- Thumbnail: Upload ảnh mixer
```

### Bước 2: Thêm Products
```
WP Admin → Products → Edit Product
1. Đảm bảo product thuộc category vừa tạo
2. Set giá sản phẩm (để tính flagship)
3. Upload ảnh chất lượng cao
4. Điền "Product Specs": "16 Channel, USB Interface"
5. Chọn "Product Badge": HOT/NEW/...
```

### Bước 3: Test
```
Truy cập: https://your-domain.com/product-cat/audio-mixer/
- Check Hero section
- Check Flagship product
- Check Product grid
- Check Pagination (nếu >12 products)
```

---

## 📝 **Notes**

1. **Performance:** Category thumbnail nên optimize (<200KB)
2. **SEO:** Description nên 150-160 ký tự
3. **Mobile:** Trang đã responsive, test trên điện thoại
4. **Icons:** Lucide icons load từ CDN (cần internet)
5. **Fonts:** Cinzel & Manrope load từ Google Fonts

---

## 🔧 **Troubleshooting**

### Products không hiển thị?
- Check product có thuộc category không
- Check product status = "Published"
- Check WooCommerce settings

### Flagship không đúng sản phẩm?
- Check giá sản phẩm (flagship = đắt nhất)
- Hoặc set product Featured

### Specs/Badge không hiển thị?
- Check đã save product chưa
- Check meta box sidebar có hiển thị không
- Hard refresh browser (Ctrl+Shift+R)

---

**Last Updated:** 2025-12-30  
**Version:** 2.4.1  
**Contact:** TD Classic Support

