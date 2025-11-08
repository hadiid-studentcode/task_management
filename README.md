# API Manajemen Tugas (Laravel SOLID Technical Test)

Ini adalah proyek API RESTful sederhana untuk manajemen tugas, dibuat sebagai bagian dari tes teknis backend. Fokus utama proyek ini adalah untuk mendemonstrasikan implementasi API CRUD yang bersih, *maintainable*, dan *scalable* dengan menerapkan **prinsip-prinsip SOLID** dalam ekosistem Laravel.

---

## 🚀 Fitur Utama

* **Autentikasi & Otorisasi:** Registrasi, login, dan logout user menggunakan **Laravel Sanctum**.
* **Manajemen Project:** Fungsionalitas CRUD penuh untuk *projects*.
* **Manajemen Task:** Fungsionalitas CRUD penuh untuk *tasks* yang terhubung ke *projects*.
* **Validasi Request:** Menggunakan kelas *Form Request* khusus untuk validasi data yang masuk.
* **Transformasi Respons:** Menggunakan *API Resources* untuk memformat output JSON secara konsisten.
* **Arsitektur Berbasis SOLID:** Pemisahan tanggung jawab yang jelas menggunakan *Service* dan *Repository Pattern*.

---

## 🛠️ Teknologi yang Digunakan

* **PHP 8.2**
* **Laravel 12.x**
* **Laravel Sanctum** (Untuk autentikasi API)
* **MySQL** (Sesuai konfigurasi `.env`)

---

## ⚙️ Instalasi & Setup

Ikuti langkah-langkah ini untuk menjalankan proyek secara lokal:

1.  **Clone repository:**
    ```bash
    git clone https://github.com/hadiid-studentcode/task_management.git
    cd task_management
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    ```

3.  **Buat file environment:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database:**
    Buka file `.env` dan atur koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

6.  **Jalankan migrasi:**
    ```bash
    php artisan migrate
    ```

7.  **(Opsional) Jalankan database seeder:**
    Jika Anda menyediakannya, jalankan seeder untuk data dummy.
    ```bash
    php artisan db:seed
    ```

8.  **Jalankan server:**
    ```bash
    php artisan serve
    ```
    API akan berjalan di `http://127.0.0.1:8000`.

---

## 📚 Dokumentasi API (Endpoints)

Semua *endpoint* memiliki prefix `/api`.

### 1. Autentikasi

| Method | Endpoint | Deskripsi | Headers | Body (JSON) |
| :--- | :--- | :--- | :--- | :--- |
| `POST` | `/register` | Registrasi user baru. | `Accept: application/json` | `{ "name": "User", "email": "user@test.com", "password": "password", "password_confirmation": "password" }` |
| `POST` | `/login` | Login user untuk mendapatkan token. | `Accept: application/json` | `{ "email": "user@test.com", "password": "password" }` |
| `POST` | `/logout` | Logout user & membatalkan token. | `Authorization: Bearer [TOKEN]` | (Kosong) |

---

### 2. Projects (Membutuhkan Autentikasi)

Semua *endpoint* di bawah ini memerlukan header `Authorization: Bearer [TOKEN]`.

| Method | Endpoint | Deskripsi | Body (JSON) |
| :--- | :--- | :--- | :--- |
| `GET` | `/projects` | Mendapatkan semua *projects* milik user yang sedang login. | (Kosong) |
| `POST` | `/projects` | Membuat *project* baru. | `{ "name": "Project Baru", "description": "Deskripsi singkat" }` |
| `GET` | `/projects/{id}` | Menampilkan detail satu *project*. | (Kosong) |
| `PUT` | `/projects/{id}` | Memperbarui *project*. | `{ "name": "Project Update", "description": "Deskripsi baru" }` |
| `DELETE` | `/projects/{id}` | Menghapus *project*. | (Kosong) |

---

### 3. Tasks (Membutuhkan Autentikasi)

Semua *endpoint* di bawah ini memerlukan header `Authorization: Bearer [TOKEN]`.

| Method | Endpoint | Deskripsi | Body (JSON) |
| :--- | :--- | :--- | :--- |
| `GET` | `/tasks` | Mendapatkan semua *tasks* (idealnya difilter milik user). | (Kosong) |
| `POST` | `/tasks` | Membuat *task* baru. | `{ "project_id": 1, "title": "Task Baru", "description": "Detail task", "status": "pending", "due_date": "2025-12-31 23:59:00", "assignee_id": 1 }` |
| `GET` | `/tasks/{id}` | Menampilkan detail satu *task*. | (Kosong) |
| `PUT` | `/tasks/{id}` | Memperbarui *task*. | `{ "title": "Task Update", "status": "in_progress" }` |
| `DELETE` | `/tasks/{id}` | Menghapus *task*. | (Kosong) |

---

## 💡 Penerapan Prinsip SOLID

Arsitektur kode ini dirancang untuk mematuhi 5 prinsip SOLID:

### S - Single Responsibility Principle (SRP)
Setiap kelas memiliki satu tanggung jawab utama:
* **Controllers** (`ProjectsController`): Hanya bertanggung jawab atas request & response HTTP.
* **Services** (`ProjectService`): Bertanggung jawab atas semua logika bisnis (membuat, update, validasi bisnis).
* **Repositories** (`ProjectRepository`): Bertanggung jawab atas kueri dan interaksi dengan database (Eloquent).
* **Form Requests** (`StoreProjectRequest`): Bertanggung jawab atas validasi data input dan otorisasi request.
* **API Resources** (`ProjectResource`): Bertanggung jawab atas transformasi data model ke format JSON.

### O - Open/Closed Principle (OCP)
Sistem ini terbuka untuk ekstensi tapi tertutup untuk modifikasi.
* **Contoh:** Jika kita ingin mengirim notifikasi email saat sebuah *task* selesai, kita tidak perlu mengubah `TaskService`. Kita bisa menggunakan **Events & Listeners** Laravel. `TaskService` akan men-dispatch event `TaskCompleted`, dan `SendNotificationListener` akan menangani logika pengiriman email.

### L - Liskov Substitution Principle (LSP)
Setiap implementasi *repository* harus bisa menggantikan *interface*-nya tanpa merusak aplikasi.
* `EloquentProjectRepository` mengimplementasikan `ProjectRepositoryInterface`. Jika kita ingin mengganti database ke MongoDB, kita bisa membuat `MongoProjectRepository` yang juga mengimplementasikan *interface* yang sama, dan aplikasi akan tetap berjalan hanya dengan mengubah *binding* di Service Provider.

### I - Interface Segregation Principle (ISP)
*Interface* dibuat spesifik sesuai kebutuhan kliennya.
* Kami memisahkan `ProjectRepositoryInterface` dan `TaskRepositoryInterface`. Kami tidak membuat satu `CrudRepositoryInterface` raksasa yang memaksa setiap *repository* mengimplementasikan metode yang tidak diperlukannya (misalnya, `findByName` mungkin hanya ada di Project, tidak di Task).

### D - Dependency Inversion Principle (DIP)
Modul *high-level* (Services, Controllers) tidak bergantung pada modul *low-level* (Eloquent), melainkan keduanya bergantung pada **abstraksi (Interfaces)**.
* **Dependency Injection (DI)** digunakan secara masif. `ProjectsController` bergantung pada `ProjectServiceInterface`, bukan `ProjectService`. `ProjectService` bergantung pada `ProjectRepositoryInterface`, bukan `EloquentProjectRepository`.
* *Binding* antara *interface* dan implementasi konkretnya diatur dalam **Service Provider** (mis. `AppServiceProvider` atau `RepositoryServiceProvider`).