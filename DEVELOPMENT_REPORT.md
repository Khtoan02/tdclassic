# BÁO CÁO PHÁT TRIỂN & KẾ HOẠCH NÂNG CẤP GIAO DIỆN TD CLASSIC

Tài liệu này ghi lại toàn bộ các thay đổi kiến trúc, thiết kế, lỗi đã khắc phục và định hướng phát triển tiếp theo cho giao diện Luxury Black & Gold của **TD Classic**.

---

## 1. THÀNH TỰU ĐÃ ĐẠT ĐƯỢC (COMPLETED & OPTIMIZED)

Chúng ta đã nâng cấp giao diện từ cấu trúc cũ sang hệ sinh thái giao diện đẳng cấp điện ảnh (Cinematic Modern Luxury), loại bỏ hoàn toàn các lỗi hiển thị phổ biến trên các môi trường hosting thực tế.

### A. Sửa lỗi xung đột CSS toàn cục (CSS Variable Collision)
* **Vấn đề**: Các biến CSS gốc như `--gray-text`, `--gold` bị trùng lặp với các plugin bên thứ ba trên môi trường host, dẫn đến các link trên top bar bị tối màu và mất định dạng.
* **Giải pháp**: Tiến hành đổi tên và bao gói toàn bộ các biến trong `header-new.css` thành tiền tố riêng biệt: `--td-gray-text`, `--td-gold`, `--td-gold-glow`, `--td-void`, `--td-metal`, `--td-surface`.
* **Kết quả**: Giao diện top-bar hiển thị hoàn hảo, độc lập hoàn toàn, không bị ảnh hưởng bởi bất kỳ plugin hay theme ngoài nào khác.

### B. Khắc phục lỗi đứt gãy Hover & Khoảng trống ở Bottom Header (Hover Gap Bug)
* **Vấn đề**: Có một khoảng trống đệm (`padding: 11px 0` trên `.header-bottom-wrapper`) ngăn cách thanh menu danh mục với vùng hiển thị Mega Menu bên dưới. Khi di chuột ra rìa dưới, vùng nhạy cảm hover bị đứt làm menu đóng mở đột ngột (nhấp nháy khó chịu).
* **Giải pháp**:
  - Loại bỏ hoàn toàn padding tĩnh trên lớp wrapper chứa viền vàng.
  - Phân bổ padding `py-3` vào trực tiếp các mục liên kết chính `.has-bottom-mega`.
  - Thiết kế vùng nhạy cảm hover kéo dài liên mạch đến sát mép của Mega Menu bên dưới.
* **Kết quả**: Trải nghiệm di chuột mượt mà 100%, không còn hiện tượng giật lắc hay nhấp nháy menu.

### C. Nâng cấp Mega Menu chuyên biệt theo từng Danh mục (Woocommerce Category Mega Menus)
* **Tính năng**:
  - Mỗi danh mục chính trên Header Bottom có bảng điều hướng Mega Menu riêng độc lập.
  - Tự động truy vấn (Query) danh sách sản phẩm thực tế từ Woocommerce (`tdclassic_get_products_by_category($cat_slug, 6)`) với giới hạn tối đa 6 sản phẩm mới nhất.
  - Thiết kế khung hiển thị sản phẩm sang trọng (Không hiện giá bán để giữ chất Luxury, tập trung vào tên, mô tả ngắn, và thông số kỹ thuật tối giản).
  - Có khung Banner lớn quảng bá riêng cho từng danh mục ở phía bên phải cực kỳ lôi cuốn.

### D. Tối ưu nút điều hướng Slide Trang chủ (Premium Navigation Arrows)
* **Vấn đề**: Các nút điều hướng cũ dùng chiều cao đầy đủ (`h-full`) vô tình che phủ toàn bộ rìa trái/phải banner khiến người dùng không click được các phần tử bên dưới. Ngoài ra, thư viện Lucide Icon thỉnh thoảng bị lỗi bất tuần tự thời gian tải (Timing) khiến mũi tên bị biến mất.
* **Giải pháp**:
  - Chuyển đổi sang thiết kế vòng tròn kính mờ mạ vàng lơ lửng sang trọng (`w-14 h-14 rounded-full border border-white/10 bg-black/45 backdrop-blur-md`).
  - Sử dụng biểu tượng **Font Awesome 6.4.0** ổn định tuyệt đối (`fa-solid fa-chevron-left/right`).
  - Hỗ trợ responsive đa thiết bị (co nhỏ lại thành dạng `w-10 h-10` trên di động để tăng UX điều hướng).
  - Giữ nguyên cơ chế tương tác thông minh: Tự động dừng Auto-play tạm thời khi người dùng click thủ công để đọc thông tin.

---

## 2. KẾ HOẠCH NÂNG CẤP TIẾP THEO (NEXT-STAGE ROADMAP)

Để dự án tiếp tục hoàn thiện hơn nữa, dưới đây là các đầu việc được đề xuất cho các giai đoạn tiếp theo:

### Giai đoạn 1: Đồng bộ hóa nội dung & Sản phẩm thật
* [ ] **Cập nhật thông số kỹ thuật (WooCommerce Custom Fields)**: Thiết lập thêm các trường thông tin cơ bản cho sản phẩm (như công suất, độ nhạy, chất liệu vỏ) thông qua ACF (Advanced Custom Fields) hoặc thuộc tính mặc định để hiển thị trực tiếp lên Mega Menu thay vì dùng mô tả ngắn chung chung.
* [ ] **Bổ sung ảnh Banner đại diện cho Danh mục**: Đảm bảo các danh mục sản phẩm WooCommerce đều có ảnh đại diện (Thumbnail) chất lượng cao để hiển thị lên khung banner phải của Mega Menu.

### Giai đoạn 2: Tối ưu hiệu năng & Trải nghiệm cuộn (Performance & Motion)
* [ ] **Tích hợp Lazy Loading cho Slider & Mega Menu**: Sử dụng thuộc tính `loading="lazy"` hoặc Intersection Observer cho toàn bộ ảnh sản phẩm để đạt điểm số tối ưu Google Lighthouse cao nhất (LCP < 2.5s).
* [ ] **Tích hợp hiệu ứng chuyển động mượt mà (View Transitions / GSAP)**: Thêm các hiệu ứng mượt mà khi đổi slide hoặc chuyển trang để tạo trải nghiệm "chạm là yêu".

### Giai đoạn 3: SEO & Khả năng tiếp cận (SEO & Accessibility)
* [ ] **Đồng bộ hóa từ khóa Schema**: Thêm thẻ Schema.org cho phần Header Bottom và danh sách danh mục để robot Google quét được cấu trúc trang web một cách trực quan nhất.
* [ ] **Bổ sung thẻ ARIA cho Nút slide**: Gán `aria-label="Previous Slide"` và `aria-label="Next Slide"` trên các nút điều hướng vừa sửa đổi để nâng điểm a11y.

---

## 3. HƯỚNG DẪN QUẢN TRỊ & ĐỒNG BỘ NGUỒN CỐT (DEPLOYMENT & SYNC)

Khi làm việc với môi trường Host, bạn nên tuân thủ quy trình sau để tránh xung đột mã nguồn:

### Bước 1: Đồng bộ mã nguồn trên Local lên GitHub
Mỗi khi có cập nhật, bạn chạy các lệnh sau ở máy cá nhân:
```bash
npx @tailwindcss/cli -i assets/css/tailwind-input.css -o assets/css/dist/tailwind.min.css --minify
git add .
git commit -m "Mô tả ngắn gọn về thay đổi"
git push origin main
```

### Bước 2: Đồng bộ mã nguồn từ GitHub về Hosting (Host)
SSH vào thư mục theme trên hosting và chạy lệnh:
```bash
git pull origin main
```

*Lưu ý: Luôn kiểm tra cache trình duyệt hoặc CDN sau khi pull để đảm bảo tệp tin `tailwind.min.css` được làm mới.*

---
*Tài liệu được soạn thảo tự động bởi Antigravity để đồng hành cùng bạn trên con đường nâng tầm thương hiệu âm thanh TD Classic.*
