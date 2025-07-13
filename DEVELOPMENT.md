## Admin Yetkilendirme ve Middleware Kullanımı

### 1. AdminController Oluşturma

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function test_admin()
   {
       return view('admin.test_admin');
   }
}
```

Bu controller, admin paneline özel işlemleri yönetmek için kullanılır. test_admin fonksiyonu, admin/test_admin.blade.php view dosyasını döndürür.

### 2. AdminMiddleware Oluşturma

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            return $next($request);
        }
        abort(401, 'Unauthorized action.');
    }
}
```

Bu middleware, kullanıcının admin olup olmadığını kontrol eder. Eğer kullanıcı admin değilse 401 hatası döner.

### 3. Middleware Alias Tanımlama

```php
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
```

Bu kod, AdminMiddleware'i 'admin' adıyla alias olarak tanımlar. Böylece route tanımlarında kolayca kullanılabilir.

### 4. Admin View Dosyası

`resources/views/admin/test_admin.blade.php`

### 5. Route Tanımı

```php
Route::middleware('admin')->group(function () {
    Route::get('/test_admin', [AdminController::class, 'test_admin'])->name('test_admin');
});
```

Bu route, sadece admin yetkisine sahip kullanıcılar tarafından erişilebilir. test_admin fonksiyonu çağrılır ve admin paneli sayfası gösterilir.

### 6. Controller Oluşturma

```bash
php artisan make:controller UserController
```

Bu komut, `app/Http/Controllers` klasöründe `UserController.php` adında bir controller dosyası oluşturur. Controller'lar, gelen HTTP isteklerini karşılamak ve uygun yanıtları döndürmek için kullanılır. Yazım hatası yapılırsa (ör: `make:contoller`), komut çalışmaz ve öneriler sunulur. Doğru yazım `make:controller` olmalıdır.

## Migration Komutları ve Açıklamaları

### 1. Migration Oluşturma

```bash
php artisan make:migration add_column_to_users --table=users
```

Bu komut, mevcut `users` tablosuna yeni bir sütun eklemek için bir migration dosyası oluşturur. `--table=users` parametresi, migration'ın var olan tablo üzerinde değişiklik yapacağını belirtir. Migration dosyasında, genellikle `up()` metodunda yeni sütun eklenir, `down()` metodunda ise bu sütun kaldırılır.

### 2. Migration'ı Çalıştırma

```bash
php artisan migrate
```

Tüm migration dosyalarını çalıştırarak veritabanı şemasını günceller. Yeni eklenen migration dosyası da bu komutla uygulanır.

### 3. Migration'ı Geri Alma

```bash
php artisan migrate:rollback
```

Son çalıştırılan migration grubunu geri alır. Eğer eklediğiniz sütunda hata varsa veya geri almak isterseniz bu komut kullanılır.

### 4. Migration'ı Sıfırlama

```bash
php artisan migrate:reset
```

Tüm migrationları geri alır. Veritabanını migration öncesi haline döndürmek için kullanılır.

### 5. Migration'ı Baştan Uygulama

```bash
php artisan migrate:fresh
```

Tüm tabloları silip migrationları baştan çalıştırır. Geliştirme aşamasında veritabanını temiz bir şekilde başlatmak için kullanılır.

## 1. Controller Oluşturma

```php
php artisan make:controller AdminController
```

Bu komut, [**Controllers**](vscode-file://vscode-app/c:/Users/musta/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-browser/workbench/workbench.html) klasöründe `AdminController.php` adında bir controller dosyası oluşturur. Controller'lar, gelen HTTP isteklerini karşılamak ve uygun yanıtları döndürmek için kullanılır.

## 2. Middleware Oluşturma

```php
php artisan make:middleware AdminMiddleware
```

Bu komut, [**Middleware**](vscode-file://vscode-app/c:/Users/musta/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-browser/workbench/workbench.html) klasöründe `AdminMiddleware.php` adında bir middleware dosyası oluşturur. Middleware'ler, HTTP isteklerini işlemek için kullanılır ve genellikle yetkilendirme gibi işlemleri gerçekleştirir

## 3. Model ve Migration Oluşturma

```php
php artisan make:middleware AdminMiddleware
```

Bu komut, [**Models**](vscode-file://vscode-app/c:/Users/musta/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-browser/workbench/workbench.html) klasöründe `Category.php` adında bir model dosyası ve [**migrations**](vscode-file://vscode-app/c:/Users/musta/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-browser/workbench/workbench.html) klasöründe bir migration dosyası oluşturur. Model, veritabanı tablolarını temsil ederken migration, tablo yapısını tanımlar.

## 4. Migration'ı Çalıştırma

```php
php artisan migrate
```

Bu komut, tüm migration dosyalarını çalıştırarak veritabanı şemasını günceller. Yeni eklenen migration dosyası da bu komutla uygulanır.

## 5. Migration'ı Baştan Uygulama

```php
php artisan migrate:fresh
```

Tüm tabloları silip migrationları baştan çalıştırır. Geliştirme aşamasında veritabanını temiz bir şekilde başlatmak için kullanılır.

---

### Kategori Listeleme Özelliği

#### 1. Controller Fonksiyonu

AdminController.php dosyasına aşağıdaki fonksiyon eklenir:

```php
public function viewCategory()
{
    $categories = Category::all();
    return view('admin.viewcategory', compact('categories'));
}
```

#### 2. Route Tanımı

web.php dosyasına aşağıdaki route eklenir:

```php
Route::get('/view_category', [AdminController::class, 'viewCategory'])->name('viewcategory');
```

#### 3. View Dosyası

resources/views/admin/viewcategory.blade.php dosyasının içeriği:

```blade
@extends('admin.maindesign')

@section('view_category')
    <h1>View Categories</h1>
    @if(session('category_message'))
        <div class="alert alert-success">
            {{ session('category_message') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->category }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
```

---

### Kategori Silme Özelliği

#### 1. Controller Fonksiyonu

AdminController.php dosyasına aşağıdaki fonksiyon eklenir:

```php
/* delete category */
public function deleteCategory($id)
{
    $category = Category::findOrFail($id);
    $category->delete();
    return redirect()->back()->with('category_message', 'Category deleted successfully!');
}
```

#### 2. View Dosyası Hata Mesajı

viewcategory.blade.php dosyasına hata mesajı gösterimi eklenir:

```blade
{{-- delete --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

#### 3. Route Tanımı

web.php dosyasına aşağıdaki route eklenir:

```php
/* delete category */
Route::delete('/delete_category/{id}', [AdminController::class, 'deleteCategory'])->name('deletecategory');
```

---

## Ürün Yönetimi (Product Management) Sistemi

### 1. Ürün Ekleme (Add Product)

#### Controller Fonksiyonu

AdminController.php dosyasına eklenen fonksiyonlar:

```php
/* add product */
public function addProduct() {
    $categories = Category::all(); // Tüm kategorileri al
    return view('admin.add_product', compact('categories')); // View'e gönder
}

public function postAddProduct(Request $request) {
    $request->validate([
        'product_title' => 'required|string|max:255',
        'product_description' => 'required|string',
        'product_quantity' => 'required|integer|min:0',
        'product_price' => 'required|numeric|min:0',
        'product_category' => 'required|exists:categories,id',
        'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    try {
        $product = new Product();
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity = $request->product_quantity;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;

        // Handle multiple image uploads
        $imagePaths = [];
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                // Create directory if it doesn't exist
                $uploadPath = public_path('uploads/products');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Generate unique filename
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Move image to public/uploads/products directory
                $image->move($uploadPath, $imageName);

                // Store relative path
                $imagePaths[] = 'uploads/products/' . $imageName;
            }
        }

        // Store image paths as JSON, or empty array if no images
        $product->product_images = json_encode($imagePaths);
        $product->save();

        return redirect()->back()->with('product_add', 'Ürün başarıyla eklendi!');
    } catch (\Exception $e) {
        return redirect()->back()->with('product_error', 'Ürün eklenirken hata oluştu: ' . $e->getMessage());
    }
}
```

#### Özellikler:

-   **Çoklu Resim Yükleme**: Birden fazla ürün resmi yüklenebilir
-   **Resim Doğrulama**: JPEG, PNG, JPG, GIF formatları desteklenir (max 2MB)
-   **Dinamik Klasör Oluşturma**: uploads/products klasörü otomatik oluşturulur
-   **Benzersiz Dosya Adları**: timestamp + uniqid ile çakışma önlenir
-   **JSON Saklama**: Resim yolları JSON formatında veritabanında saklanır

### 2. Ürün Listeleme ve Pagination (View Products with Pagination)

#### Controller Fonksiyonu

```php
/* view product */
public function viewProduct()
{
    $products = Product::with('category')->paginate(10); // 10 products per page
    return view('admin.view_product', compact('products'));
}
```

#### AppServiceProvider.php Pagination Ayarları

```php
public function boot(): void
{
    // Use Bootstrap 4 pagination views
    Paginator::useBootstrap();

    // Optional: Set default pagination view
    Paginator::defaultView('pagination::bootstrap-4');
    Paginator::defaultSimpleView('pagination::simple-bootstrap-4');
}
```

#### View Dosyasında Pagination Gösterimi

```blade
<!-- Pagination -->
@if ($products->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3 px-4 pb-4">
        <div class="text-muted">
            <small>
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
            </small>
        </div>
        <div>
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endif
```

#### Özellikler:

-   **Sayfa Başına 10 Ürün**: Performans için optimize edilmiş
-   **Bootstrap Styling**: Modern ve responsive tasarım
-   **Sonuç Sayacı**: "Showing X to Y of Z results" gösterimi
-   **Kategori İlişkisi**: Eager loading ile N+1 problem çözümü

### 3. Ürün Güncelleme (Update Product)

#### Controller Fonksiyonları

```php
/* edit product */
public function editProduct($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all();
    return view('admin.update_product', compact('product', 'categories'));
}

/* update product */
public function updateProduct(Request $request, $id)
{
    $request->validate([
        'product_title' => 'required|string|max:255',
        'product_description' => 'required|string',
        'product_quantity' => 'required|integer|min:0',
        'product_price' => 'required|numeric|min:0',
        'product_category' => 'required|exists:categories,id',
        'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'existing_images' => 'nullable|string'
    ]);

    try {
        $product = Product::findOrFail($id);

        // Get original images before update
        $originalImages = is_string($product->product_images)
            ? json_decode($product->product_images, true) ?? []
            : $product->product_images ?? [];

        // Handle existing images from form
        $existingImages = [];
        if ($request->existing_images) {
            $existingImages = json_decode($request->existing_images, true) ?: [];
        }

        // Find images that were removed (exist in original but not in existing)
        $removedImages = array_diff($originalImages, $existingImages);

        // Delete removed images from file system
        if (!empty($removedImages)) {
            foreach ($removedImages as $imagePath) {
                $fullPath = public_path($imagePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath); // Delete the physical file
                }
            }
        }

        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity = $request->product_quantity;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;

        // Handle new image uploads
        $newImagePaths = [];
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $uploadPath = public_path('uploads/products');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($uploadPath, $imageName);
                $newImagePaths[] = 'uploads/products/' . $imageName;
            }
        }

        // Merge existing and new images
        $allImages = array_merge($existingImages, $newImagePaths);
        $product->product_images = json_encode($allImages);

        $product->save();

        return redirect()->route('view_product')->with('product_update', 'Product updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('product_error', 'Error updating product: ' . $e->getMessage());
    }
}
```

#### Özellikler:

-   **Mevcut Resim Yönetimi**: Var olan resimleri göster ve silme imkanı
-   **Yeni Resim Ekleme**: Mevcut resimleri koruyarak yeni resim ekleme
-   **Dosya Temizleme**: Silinen resimleri dosya sisteminden kaldırma
-   **Array Diff Kullanımı**: Silinen resimleri tespit etme
-   **Form Validation**: Kapsamlı doğrulama kuralları

### 4. Ürün Silme (Delete Product)

#### Controller Fonksiyonu

```php
/* delete product */
public function deleteProduct($id)
{
    try {
        $product = Product::findOrFail($id);

        // Delete associated images from storage
        if ($product->product_images) {
            $images = is_string($product->product_images)
                ? json_decode($product->product_images, true)
                : $product->product_images;

            if (is_array($images) && !empty($images)) {
                foreach ($images as $imagePath) {
                    $fullPath = public_path($imagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath); // Delete the physical file
                    }
                }
            }
        }

        // Delete the product record
        $product->delete();

        return redirect()->back()->with('product_delete', 'Product and associated images deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('product_error', 'Error deleting product: ' . $e->getMessage());
    }
}
```

#### Özellikler:

-   **Cascade Silme**: Ürün silinirken tüm resimleri de sil
-   **Dosya Sistemi Temizliği**: Fiziksel dosyaları da kaldır
-   **Hata Yönetimi**: Try-catch ile güvenli silme işlemi
-   **Başarı Mesajı**: Kullanıcıya geri bildirim

### 5. Str::limit Kullanımı (Text Limiting)

#### View Dosyasında Metin Sınırlama

```blade
<!-- Product Title with 100 character limit -->
<td class="fw-semibold" title="{{ $product->product_title }}">
    {{ Str::limit($product->product_title, 100) }}
</td>

<!-- Product Description with 250 character limit -->
<td class="text-muted" title="{{ $product->product_description }}">
    {{ Str::limit($product->product_description, 250) }}
</td>
```

#### Özellikler:

-   **Başlık Sınırı**: 100 karakter ile başlık kısaltma
-   **Açıklama Sınırı**: 250 karakter ile açıklama kısaltma
-   **Tooltip Gösterimi**: Tam metni title attribute ile gösterme
-   **Responsive Tasarım**: Tablo düzenini koruma
-   **Kullanıcı Deneyimi**: Hover ile tam içerik görüntüleme

### 6. Resim Gösterimi ve Modal (Image Display and Modal)

#### View Dosyasında Resim Gösterimi

```blade
@php
    $images = $product->product_images;
    // If it's a string, decode it to array
    if (is_string($images)) {
        $images = json_decode($images, true) ?? [];
    }
    // Ensure it's an array
    if (!is_array($images)) {
        $images = [];
    }
@endphp

@if (!empty($images) && count($images) > 0)
    @foreach (array_slice($images, 0, 3) as $imagePath)
        <img src="{{ asset($imagePath) }}"
             alt="Product Image"
             class="product-thumbnail"
             style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px; border: 2px solid #fd7e14; cursor: pointer;"
             onclick="showImageModal('{{ asset($imagePath) }}', '{{ $product->product_title }}')">
    @endforeach
    @if (count($images) > 3)
        <span class="badge bg-orange">+{{ count($images) - 3 }}</span>
    @endif
@else
    <div class="d-flex align-items-center justify-content-center">
        <i class="fas fa-image text-muted"></i>
    </div>
@endif
```

#### JavaScript Modal Fonksiyonu

```javascript
function showImageModal(imageSrc, productTitle) {
    document.getElementById("modalImage").src = imageSrc;
    document.getElementById("imageModalLabel").textContent =
        productTitle + " - Image";

    const modal = new bootstrap.Modal(document.getElementById("imageModal"));
    modal.show();
}
```

#### Özellikler:

-   **Thumbnail Gösterimi**: İlk 3 resmi küçük boyutta göster
-   **Overflow Counter**: 3'ten fazla resim varsa sayıcı göster
-   **Modal Büyütme**: Resme tıklayınca modal ile büyüt
-   **JSON Parsing**: String/Array format uyumluluğu
-   **Placeholder Icon**: Resim yoksa ikon göster

### 7. Route Tanımları

```php
// Product Management Routes
Route::middleware('admin')->group(function () {
    Route::get('/add_product', [AdminController::class, 'addProduct'])->name('add_product');
    Route::post('/post_add_product', [AdminController::class, 'postAddProduct'])->name('post_add_product');
    Route::get('/view_product', [AdminController::class, 'viewProduct'])->name('view_product');
    Route::get('/edit_product/{id}', [AdminController::class, 'editProduct'])->name('edit_product');
    Route::put('/update_product/{id}', [AdminController::class, 'updateProduct'])->name('update_product');
    Route::delete('/delete_product/{id}', [AdminController::class, 'deleteProduct'])->name('delete_product');
});
```

### 8. Migration Dosyası

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('product_title');
    $table->text('product_description');
    $table->integer('product_quantity');
    $table->decimal('product_price', 10, 2);
    $table->unsignedBigInteger('product_category');
    $table->json('product_images')->nullable();
    $table->timestamps();

    $table->foreign('product_category')->references('id')->on('categories')->onDelete('cascade');
});
```

### 9. Teknolojiler ve Özellikler

#### Frontend:

-   **Bootstrap 5**: Modern ve responsive tasarım
-   **JavaScript**: Modal ve dinamik işlemler
-   **FontAwesome**: İkonlar
-   **CSS3**: Özel animasyonlar ve hover efektleri

#### Backend:

-   **Laravel Validation**: Kapsamlı form doğrulama
-   **File Upload**: Çoklu resim yükleme
-   **JSON Storage**: Resim yolları JSON formatında
-   **Pagination**: Laravel built-in pagination
-   **Eloquent ORM**: Veritabanı işlemleri
-   **Exception Handling**: Try-catch ile hata yönetimi

#### Database:

-   **Foreign Key**: Kategori ilişkisi
-   **JSON Column**: Resim yolları saklama
-   **Indexing**: Performans optimizasyonu

---

## Müşteri Yönetimi (Customer Management) Sistemi

### 1. Adım: Customer (Müşteri) Modeli Oluşturma

#### Model ve Migration Oluşturma Komutu

```bash
php artisan make:model Customer -m
```

Bu komut:

-   `app/Models/Customer.php` modelini oluşturur
-   `database/migrations/create_customers_table.php` migration dosyasını oluşturur
-   `-m` parametresi migration dosyasını otomatik oluşturur

#### Planlanan Müşteri Özellikleri:

-   **Temel Bilgiler**: Ad, soyad, e-mail (unique), şifre
-   **İletişim**: Adres, telefon numarası
-   **Satın Alma**: Satın aldığı ürün miktarı ve fiyatı
-   **Dashboard**: Müşteri paneli
-   **Sepet Sistemi**: Ürün seçme ve sepete ekleme
-   **Sipariş Geçmişi**: Satın alınan ürünlerin listesi

---

### 2. Adım: Migration Dosyasını Düzenleme

#### Migration Dosyası Yapısı

```php
public function up(): void
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');           // Müşteri adı
        $table->string('last_name');            // Müşteri soyadı
        $table->string('email')->unique();      // E-mail (benzersiz)
        $table->timestamp('email_verified_at')->nullable(); // E-mail doğrulama
        $table->string('password');             // Şifre (hash'lenmiş)
        $table->text('address')->nullable();    // Adres bilgisi
        $table->string('phone')->nullable();    // Telefon numarası
        $table->decimal('total_spent', 10, 2)->default(0); // Toplam harcama
        $table->integer('total_orders')->default(0);       // Toplam sipariş sayısı
        $table->rememberToken();               // "Beni hatırla" özelliği
        $table->timestamps();                  // created_at, updated_at
    });
}
```

#### Sütun Açıklamaları:

-   **first_name**: Müşterinin adı
-   **last_name**: Müşterinin soyadı
-   **email**: Benzersiz e-mail adresi (giriş için kullanılacak)
-   **password**: Hash'lenmiş şifre
-   **address**: Teslimat adresi (nullable)
-   **phone**: Telefon numarası (nullable)
-   **total_spent**: Toplam harcanan miktar (decimal 10,2)
-   **total_orders**: Toplam sipariş sayısı (integer)

### 3. Adım: Migration'ı Çalıştırma

#### Migration Komutu

```bash
php artisan migrate
```

Bu komut customers tablosunu veritabanında oluşturur.

#### Çıktı Sonucu:

```
INFO  Running migrations.
2025_07_12_211927_create_customers_table ........................ 59.19ms DONE
```

### 4. Adım: Customer Modelini Düzenleme

#### Model Yapısı

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'phone',
        'total_spent',
        'total_orders',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'total_spent' => 'decimal:2',
        ];
    }
}
```

#### Model Özellikleri:

-   **Authenticatable**: Müşteri giriş işlemleri için
-   **Notifiable**: Bildirimler için
-   **$fillable**: Mass assignment için güvenli alanlar
-   **$hidden**: Serileştirmede gizlenecek alanlar (şifre)
-   **$casts**: Veri tipi dönüşümleri
-   **password hashed**: Şifre otomatik hash'lenir

### 5. Adım: CustomerController Oluşturma

#### Controller Oluşturma Komutu

```bash
php artisan make:controller CustomerController
```

Bu komut `app/Http/Controllers/CustomerController.php` dosyasını oluşturur.

#### Planlanan Controller Fonksiyonları:

-   **register()**: Kayıt formu gösterimi
-   **postRegister()**: Kayıt işlemi
-   **login()**: Giriş formu gösterimi
-   **postLogin()**: Giriş işlemi
-   **logout()**: Çıkış işlemi
-   **dashboard()**: Müşteri paneli
-   **profile()**: Profil sayfası
-   **updateProfile()**: Profil güncelleme

### 6. Adım: CustomerController'ı Düzenleme

#### Controller Fonksiyonları

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Show customer registration form
     */
    public function register()
    {
        return view('customers.register');
    }

    /**
     * Handle customer registration
     */
    public function postRegister(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            return redirect()->route('customer.login')->with('success', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    /**
     * Show customer login form
     */
    public function login()
    {
        return view('customer.login');
    }

    /**
     * Handle customer login
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials, $request->remember)) {
            return redirect()->intended(route('customer.dashboard'));
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    /**
     * Customer dashboard
     */
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.dashboard', compact('customer'));
    }

    /**
     * Customer logout
     */
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('success', 'Logged out successfully');
    }
}
```

#### Controller Özellikleri:

-   **register()**: Kayıt formu gösterir
-   **postRegister()**: Kayıt işlemini yapar, validation dahil
-   **login()**: Giriş formu gösterir
-   **postLogin()**: Giriş işlemini yapar, customer guard kullanır
-   **dashboard()**: Müşteri panelini gösterir
-   **logout()**: Çıkış işlemi yapar

#### Validation Kuralları:

-   **first_name/last_name**: Zorunlu, string, max 255 karakter
-   **email**: Zorunlu, email formatı, benzersiz (customers tablosunda)
-   **password**: Zorunlu, min 8 karakter, onay gerekli
-   **phone/address**: Opsiyonel alanlar

### 7. Adım: Customer Guard Yapılandırması

#### Auth.php Dosyasını Düzenleme

`config/auth.php` dosyasında customer authentication için ayrı guard yapılandırması yapılır.

#### Guards Bölümüne Ekleme

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'customer' => [
        'driver' => 'session',
        'provider' => 'customers',
    ],
],
```

#### Providers Bölümüne Ekleme

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],

    'customers' => [
        'driver' => 'eloquent',
        'model' => App\Models\Customer::class,
    ],
],
```

#### Guard Özellikleri:

-   **Ayrı Session**: Customer'lar ayrı session kullanır
-   **Ayrı Provider**: Customer model'ı kullanır
-   **Çoklu Authentication**: Admin ve customer aynı anda login olabilir
-   **Güvenlik**: Her guard kendi authentication logic'i kullanır

### 8. Adım: Customer Routes Oluşturma

#### Web.php'ye Route Ekleme

```php
// Customer Routes
use App\Http\Controllers\CustomerController;

Route::prefix('customer')->name('customer.')->group(function () {
    // Guest routes (for non-authenticated customers)
    Route::middleware('guest:customer')->group(function () {
        Route::get('/register', [CustomerController::class, 'register'])->name('register');
        Route::post('/register', [CustomerController::class, 'postRegister'])->name('post.register');
        Route::get('/login', [CustomerController::class, 'login'])->name('login');
        Route::post('/login', [CustomerController::class, 'postLogin'])->name('post.login');
    });

    // Authenticated customer routes
    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
    });
});
```

#### Route Özellikleri:

-   **Prefix**: Tüm customer route'ları `/customer` ile başlar
-   **Name Prefix**: Route isimleri `customer.` ile başlar
-   **Guest Middleware**: Login olmamış customer'lar için
-   **Auth Middleware**: Login olmuş customer'lar için
-   **Customer Guard**: `auth:customer` ve `guest:customer` kullanır

#### Route Listesi:

-   `GET /customer/register` → Kayıt formu
-   `POST /customer/register` → Kayıt işlemi
-   `GET /customer/login` → Giriş formu
-   `POST /customer/login` → Giriş işlemi
-   `GET /customer/dashboard` → Müşteri paneli
-   `POST /customer/logout` → Çıkış işlemi

### 9. Adım: Customer View Dosyalarını Oluşturma

#### 9.1. Customer Register Form (register.blade.php)

`resources/views/customer/register.blade.php` dosyası oluşturulur.

#### Register Form Özellikleri:

-   **Modern Design**: Bootstrap 5 ile responsive tasarım
-   **Glass Effect**: Backdrop filter ile şeffaf arka plan
-   **Form Validation**: Frontend ve backend validation
-   **Error Handling**: Session mesajları ve validation hatalarını gösterir
-   **Responsive Layout**: Mobil uyumlu grid sistemi

#### Form Alanları:

-   **First Name**: Zorunlu alan
-   **Last Name**: Zorunlu alan
-   **Email**: Zorunlu, unique alan
-   **Password**: Min 8 karakter, confirmation gerekli
-   **Phone**: Opsiyonel alan
-   **Address**: Opsiyonel textarea

#### Visual Features:

-   **Gradient Background**: Modern arkaplan
-   **Card Design**: Gölgeli kart tasarımı
-   **Icon Integration**: FontAwesome ikonları
-   **Hover Effects**: Button animasyonları
-   **Alert Messages**: Bootstrap alert componentleri

#### 9.2. Customer Login Form (login.blade.php)

`resources/views/customer/login.blade.php` dosyası oluşturulur.

#### Login Form Özellikleri:

-   **Compact Design**: Daha küçük ve odaklanmış tasarım
-   **Password Toggle**: Şifre göster/gizle özelliği
-   **Remember Me**: Beni hatırla checkbox'ı
-   **Form Validation**: JavaScript ile client-side validation
-   **Shopping Cart Icon**: E-commerce temasına uygun ikon

#### Form Alanları:

-   **Email**: Login için email adresi
-   **Password**: Şifre alanı (toggle özellikli)
-   **Remember Me**: Session süresini uzatma
-   **Forgot Password**: Şifre sıfırlama linki (placeholder)

#### JavaScript Features:

-   **Password Visibility Toggle**: Şifre göster/gizle butonu
-   **Form Validation**: Bootstrap validation ile
-   **Eye Icon Animation**: Dinamik ikon değişimi

#### 9.3. Customer Dashboard (dashboard.blade.php)

`resources/views/customers/dashboard.blade.php` dosyası oluşturulur.

#### Dashboard Özellikleri:

-   **Tabbed Interface**: 4 ana bölüm (Profile, Orders, Cart, Settings)
-   **Customer Stats**: Toplam sipariş, harcama, üyelik tarihi
-   **Profile Avatar**: Müşteri adının baş harfleriyle avatar
-   **Responsive Design**: Tüm cihazlarda uyumlu
-   **Modern UI**: Glass effect ve gradient tasarım

#### Dashboard Bölümleri:

**1. Profile Tab:**

-   Müşteri bilgilerini görüntüleme
-   Form alanları (readonly)
-   Account summary
-   Edit profile butonu

**2. Orders Tab:**

-   Sipariş geçmişi (şu an boş)
-   "Start Shopping" linki
-   Gelecekte orders tablosu eklenecek

**3. Cart Tab:**

-   Sepet içeriği (şu an boş)
-   "Continue Shopping" linki
-   Gelecekte cart items gösterilecek

**4. Settings Tab:**

-   Password change
-   Notifications
-   Privacy settings
-   Account deletion (tehlikeli alan)

#### Visual Features:

-   **Stats Cards**: Gradient renkli istatistik kartları
-   **Navigation Pills**: Bootstrap tab navigation
-   **Glass Effect**: Backdrop filter background
-   **Profile Avatar**: Dynamic initials avatar
-   **Responsive Grid**: Mobile-friendly layout

#### Functional Elements:

-   **Logout**: Header'da logout butonu
-   **Homepage Link**: Ana sayfaya dönüş
-   **Tab Switching**: JavaScript ile tab geçişi
-   **Data Display**: Customer model verilerini gösterme

---

## Müşteri Yönetim Sistemi Tamamlandı!

### ✅ Tamamlanan Özellikler:

1. **Customer Model ve Migration** ✅
2. **Customer Authentication** ✅
3. **Customer Guard Yapılandırması** ✅
4. **Customer Routes** ✅
5. **Register Form** ✅
6. **Login Form** ✅
7. **Dashboard** ✅
8. **Ana Sayfa Integration** ✅
9. **Profile Edit** ✅
10. **Navigation Links** ✅

### 🎯 Final System Features:

#### **Complete Authentication Flow:**

-   Customer registration with validation
-   Customer login with remember me
-   Profile editing with optional password update
-   Secure logout functionality
-   Guard-based session management

#### **Modern UI/UX:**

-   Bootstrap 5 responsive design
-   Glass effect backgrounds
-   Gradient color schemes
-   FontAwesome icon integration
-   Interactive JavaScript features
-   Consistent navigation structure

#### **Security Implementation:**

-   CSRF protection on all forms
-   Password hashing with bcrypt
-   Form validation (client & server-side)
-   Authentication guards separation
-   Unique email validation
-   Protected route access

#### **Navigation & Flow:**

-   Clean URL structure with prefixes
-   Proper route naming conventions
-   Intuitive user flow between pages
-   Consistent header/footer navigation
-   Admin/Customer separation

#### 🚀 System Ready For:

-   Product catalog integration
-   Shopping cart functionality
-   Order management
-   Payment processing
-   Email notifications
-   Advanced customer features

Customer Management System tamamen tamamlanmış ve production-ready durumda! 🎉

### 12. Adım: Admin Dashboard Integration ve CSRF Hata Çözümü

#### 12.1. Admin Dashboard Otomatik Yönlendirme

Admin login olduktan sonra direkt admin dashboard'a yönlendirilmesi için gerekli entegrasyonlar yapıldı.

#### Route Ekleme

`routes/web.php` dosyasına admin dashboard route'u eklendi:

```php
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    // ...existing routes...
});
```

#### AdminController Dashboard Metodu

```php
/**
 * Admin dashboard
 */
public function adminDashboard()
{
    // Dashboard için gerekli verileri alabilirsiniz
    $totalCustomers = \App\Models\Customer::count();
    $totalProducts = \App\Models\Product::count();
    $totalCategories = \App\Models\Category::count();
    $totalOrders = 0; // Order model eklendiğinde güncellenir

    return view('admin.admin_dashboard', compact(
        'totalCustomers',
        'totalProducts',
        'totalCategories',
        'totalOrders'
    ));
}
```

#### Dashboard View Güncelleme

`admin_dashboard.blade.php` dosyası gerçek verilerle güncellendi:

```blade
<div class="statistic-block block">
    <div class="progress-details d-flex align-items-end justify-content-between">
        <div class="title">
            <div class="icon"><i class="icon-user-1"></i></div><strong>Total
                Customers</strong>
        </div>
        <div class="number dashtext-1">{{ $totalCustomers }}</div>
    </div>
    <div class="progress progress-template">
        <div role="progressbar" style="width: {{ min(($totalCustomers / 100) * 100, 100) }}%"
             aria-valuenow="{{ $totalCustomers }}" aria-valuemin="0" aria-valuemax="100"
            class="progress-bar progress-bar-template dashbg-1"></div>
    </div>
</div>
```

#### Dashboard Home Redirect

Laravel'in standart `/dashboard` route'unu admin dashboard'a yönlendirme:

```php
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
```

#### Model Import

AdminController'a Customer model'i import edildi:

```php
use App\Models\Customer;
```

### 12.2. 419 Page Expired Hatası Çözümü

Logout işlemlerinde oluşan CSRF token sorunu düzeltildi.

#### Ana Sayfa Navigation Düzeltmesi

`index.blade.php` dosyasında logout form'ları güvenli hale getirildi:

**Admin Logout:**

```blade
<a class="btn nav_search-btn" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
    <i class="fa fa-sign-out" aria-hidden="true"></i>
    <span>Logout</span>
</a>
<form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
```

**Customer Logout:**

```blade
<a class="btn nav_search-btn" href="#" onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();">
    <i class="fa fa-sign-out" aria-hidden="true"></i>
    <span>Logout</span>
</a>
<form id="customer-logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
```

#### Customer Dashboard Logout Düzeltmesi

`dashboard.blade.php` dosyasındaki logout butonu güvenli hale getirildi:

```blade
<a class="btn btn-danger" href="#" onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();">
    <i class="fas fa-sign-out-alt me-1"></i>Logout
</a>
<form id="customer-logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
```

#### CSRF Token Refresh System

CSRF token'ının yenilenmesi için route eklendi:

```php
// CSRF Token refresh route
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
```

#### Hata Çözüm Yaklaşımları

**1. Hidden Form Technique:**

-   Logout butonlarını görsel link olarak tutma
-   Gerçek form'u gizli tutma
-   JavaScript ile form submit etme
-   CSRF token'ının doğru şekilde gönderilmesi

**2. Event Prevention:**

-   `event.preventDefault()` ile default link davranışını engelleme
-   Form submit işlemini manuel kontrole alma
-   Session timeout sorunlarını önleme

**3. Form Structure:**

-   Inline form'lar yerine hidden form'lar kullanma
-   Unique form ID'leri ile çakışma önleme
-   Style ile form'u görünmez yapma

### 12.3. Navigation Dinamik Sistem

Ana sayfada kullanıcı durumuna göre navigation:

```blade
@if (Auth::guard('customer')->check())
    <!-- Customer Navigation -->
@elseif (Auth::check() && Auth::user()->user_type === 'admin')
    <!-- Admin Navigation -->
@else
    <!-- Guest Navigation -->
@endif
```

#### Navigation Durumları:

**Customer Login:**

-   My Account → Customer Dashboard
-   Logout → Customer Logout

**Admin Login:**

-   Admin Dashboard → Admin Dashboard
-   Logout → Admin Logout

**Guest (Not logged in):**

-   Login → Customer Login
-   Register → Customer Register

### 12.4. Security Enhancements

#### CSRF Protection:

-   Tüm POST form'larda `@csrf` token
-   Hidden form yapısı ile güvenli logout
-   JavaScript ile form submission
-   Session timeout korunması

#### Authentication Guards:

-   Customer ve Admin ayrı guard'lar
-   Session tabanlı authentication
-   Route-level middleware korunması
-   Multiple login support

#### User Experience:

-   Seamless navigation experience
-   No page refresh needed for logout
-   Visual consistency across all pages
-   Error-free authentication flow

### 12.5. Dashboard Features

#### Admin Dashboard:

-   **Real-time Statistics:** Customer, Product, Category counts
-   **Dynamic Progress Bars:** Data-driven progress indicators
-   **Responsive Design:** Mobile-friendly layout
-   **Modern UI:** Professional admin interface

#### Customer Dashboard:

-   **Profile Management:** Edit profile functionality
-   **Account Statistics:** Orders, spending, membership info
-   **Tabbed Interface:** Profile, Orders, Cart, Settings
-   **Security:** Protected routes and CSRF protection

#### Visual Features:

-   **Gradient Colors:** Modern and vibrant color schemes
-   **Glassmorphism:** Background blur effects
-   **Dynamic Data:** Real-time statistics updates
-   **Responsive Layouts:** Mobile and tablet friendly
-   **Consistent Branding:** Aligned with overall site design

#### Functional Elements:

-   **Logout:** Secure and CSRF-protected logout
-   **Homepage Link:** Easy navigation to homepage
-   **Tab Switching:** Smooth transitions between dashboard tabs
-   **Data Display:** Clear and organized data presentation

---

## Müşteri Yönetim Sistemi Tamamlandı!

### ✅ Tamamlanan Özellikler:

1. **Customer Model ve Migration** ✅
2. **Customer Authentication** ✅
3. **Customer Guard Yapılandırması** ✅
4. **Customer Routes** ✅
5. **Register Form** ✅
6. **Login Form** ✅
7. **Dashboard** ✅
8. **Ana Sayfa Integration** ✅
9. **Profile Edit** ✅
10. **Navigation Links** ✅

### 🎯 Final System Features:

#### **Complete Authentication Flow:**

-   Customer registration with validation
-   Customer login with remember me
-   Profile editing with optional password update
-   Secure logout functionality
-   Guard-based session management

#### **Modern UI/UX:**

-   Bootstrap 5 responsive design
-   Glass effect backgrounds
-   Gradient color schemes
-   FontAwesome icon integration
-   Interactive JavaScript features
-   Consistent navigation structure

#### **Security Implementation:**

-   CSRF protection on all forms
-   Password hashing with bcrypt
-   Form validation (client & server-side)
-   Authentication guards separation
-   Unique email validation
-   Protected route access

#### **Navigation & Flow:**

-   Clean URL structure with prefixes
-   Proper route naming conventions
-   Intuitive user flow between pages
-   Consistent header/footer navigation
-   Admin/Customer separation

#### 🚀 System Ready For:

-   Product catalog integration
-   Shopping cart functionality
-   Order management
-   Payment processing
-   Email notifications
-   Advanced customer features

Customer Management System tamamen tamamlanmış ve production-ready durumda! 🎉

### 17. Adım: Checkout ve PDF Dekont Sistemi

#### 17.1. Database Yapısı

**Orders Migration:**

```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('order_number')->unique();
    $table->unsignedBigInteger('customer_id')->nullable();
    $table->string('customer_name');
    $table->string('customer_email');
    $table->string('customer_phone');
    $table->text('customer_address');
    $table->decimal('subtotal', 10, 2);
    $table->decimal('tax', 10, 2)->default(0);
    $table->decimal('shipping', 10, 2)->default(0);
    $table->decimal('total', 10, 2);
    $table->string('status')->default('pending');
    $table->timestamp('order_date');
    $table->timestamps();
});
```

**Order Items Migration:**

```php
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('order_id');
    $table->unsignedBigInteger('product_id');
    $table->string('product_title');
    $table->decimal('product_price', 10, 2);
    $table->integer('quantity');
    $table->decimal('total', 10, 2);
    $table->timestamps();
});
```

#### 17.2. Models

**Order Model:**

-   Unique order number generation
-   Customer relationship
-   Order items relationship
-   Status badge helper

**OrderItem Model:**

-   Order relationship
-   Product relationship
-   Price calculations

#### 17.3. CheckoutController

**Key Methods:**

-   `processCheckout()`: Order creation and cart clearing
-   `downloadReceipt()`: PDF generation
-   `getCheckoutData()`: Form data preparation

**Features:**

-   Stock validation
-   Transaction safety
-   Cart clearing after order
-   PDF receipt generation

#### 17.4. Checkout Flow

1. **Cart → Checkout Button**
2. **Modal Form** (Customer details)
3. **Order Processing** (Database transactions)
4. **PDF Receipt Generation**
5. **Cart Clearing**
6. **Success Message**

#### 17.5. PDF Receipt Features

**Professional Layout:**

-   Company branding
-   Order information
-   Customer details
-   Itemized products
-   Price calculations
-   Status indicators

**Technical Features:**

-   DomPDF integration
-   Responsive design
-   Professional styling
-   Download functionality

#### 17.6. Routes Structure

```php
// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/data', [CheckoutController::class, 'getCheckoutData'])->name('data');
    Route::post('/process', [CheckoutController::class, 'processCheckout'])->name('process');
    Route::get('/receipt/{orderId}', [CheckoutController::class, 'downloadReceipt'])->name('receipt');
});
```

#### 17.7. Customer Dashboard Integration

**Order History:**

-   Recent orders display
-   Order status tracking
-   Receipt download links
-   Order summary information

#### 17.8. Implementation Commands

```bash
# Install DomPDF (if needed)
composer require barryvdh/laravel-dompdf

# Run migrations
php artisan migrate

# Clear cache
php artisan config:clear
php artisan route:clear
```

#### 17.9. Features Summary

✅ **Complete Checkout Process**
✅ **PDF Receipt Generation**
✅ **Order Management**
✅ **Customer Order History**
✅ **Stock Management**
✅ **Transaction Safety**
✅ **Professional Receipt Design**

Bu sistem ile tam fonksiyonel e-commerce checkout süreci tamamlandı! 🛒📄
