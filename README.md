# 🧾 Laravel Assignment – Eloquent Relationships & Query Builder (Advanced)

## 🧩 Bối cảnh dự án
Bạn được giao phát triển một nền tảng học trực tuyến (**E-Learning**).  
Hệ thống bao gồm các thực thể chính:

- **Users**: học viên và giảng viên  
- **Profiles**: thông tin mở rộng của user (1-1)  
- **Courses**: khóa học  
- **Lessons**: bài học trong mỗi khóa học  
- **Tags**: gắn thẻ cho bài học (n-n)  
- **Comments**: bình luận (polymorphic: thuộc Course hoặc Lesson)  

---

## 🧱 Thiết kế quan hệ Eloquent

### 🔹 One-to-One
- User **hasOne** Profile  
- Profile **belongsTo** User  
- Profile có các cột: `user_id`, `bio`, `birthday`, `avatar_url`

### 🔹 One-to-Many
- User (giảng viên) **hasMany** Course  
- Course **hasMany** Lesson  

### 🔹 Many-to-Many
- Lesson **belongsToMany** Tag  
- Tag **belongsToMany** Lesson  
- Pivot table: `lesson_tag` gồm `lesson_id`, `tag_id`, `created_at`

### 🔹 Polymorphic (Morph)
- Comment **morphTo** (có thể thuộc Course hoặc Lesson)  
- Course **morphMany** Comment  
- Lesson **morphMany** Comment  
- Bảng `comments`: `id`, `commentable_id`, `commentable_type`, `user_id`, `content`  

---

## 🧠 Query Builder nâng cao

Yêu cầu viết các truy vấn bằng **Query Builder** (không dùng Eloquent trực tiếp):

1. Lấy danh sách các khóa học có từ 5 bài học trở lên  
2. Lấy các bài học có tag `'Laravel'`  
3. Lấy **top 3 giảng viên** có nhiều khóa học nhất  
4. Đếm tổng số comment của mỗi lesson (dùng **subquery** hoặc **join**)  
5. Lấy khóa học kèm theo số lượng bài học (dùng `withCount()` hoặc subquery)  

---

## ⚡ Eager Loading (Tối ưu hiệu năng)

Tránh **N+1 query** bằng cách sử dụng `with()`, `load()`, `withCount()`, `loadCount()`:

- Lấy danh sách **courses** kèm theo:
  - Tác giả (**user**)  
  - Danh sách **lessons**  
  - Mỗi lesson có **tags**  

- Lấy một **lesson cụ thể** kèm theo:
  - Danh sách **comments**  
  - Người viết comment (**user**)  

---

## 🧪 Kiểm thử thực tế

Viết route hoặc artisan command để kiểm thử:  

- **Tạo mới 1 khóa học** kèm theo 3 bài học (Eloquent + quan hệ 1-n)  
- **Gắn tag** `'Laravel'` và `'Eloquent'` cho 1 bài học (dùng `attach()`, `sync()`)  
- Lấy tất cả **comment của một course** (quan hệ `morphMany()`)  
- Hiển thị danh sách **khóa học + tổng số bài học & comment** (dùng `withCount()`)  
- Tìm lesson có tag `'Performance'` và nhiều hơn 3 comment (`whereHas` + `withCount`)  

---

## ✅ Kết quả kỳ vọng
- Thiết lập đúng các quan hệ **Eloquent**  
- Viết được **Query Builder** cho các truy vấn phức tạp  
- Tối ưu hiệu năng bằng **Eager Loading**  
- Hiểu rõ bản chất **morph**, **pivot table**, **subquery** và **joins**  

---

## 🔁 Gợi ý mở rộng
- Tạo bảng **likes** sử dụng morphable cho `comment`, `course`, `lesson`  
- Tạo `CourseController@index` kèm filter theo tag, số lượng lesson, instructor  
- Viết **Scope** cho các model (ví dụ: `scopePopular()` cho Course)  
