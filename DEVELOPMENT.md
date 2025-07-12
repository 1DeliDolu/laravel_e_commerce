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
