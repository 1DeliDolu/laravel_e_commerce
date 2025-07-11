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
