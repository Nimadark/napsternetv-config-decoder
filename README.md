# WBAES NPV Config Importer (PHP)

[English](#english) | [فارسی](#فارسی)

---

## English

A highly optimized PHP implementation designed to parse, decrypt, and import custom encrypted proxy configurations (such as `.npvt` profiles). This engine reverse-engineers and mirrors the precise execution of client-side **White-Box AES block ciphers operating in CTR mode**.

### Features
- **Monolithic Performance:** Core classes (`WhiteboxTables`, `WBAESCTR`, `ConfigImporter`) are fully integrated for zero dependency execution.
- **OPcache Friendly Lookup:** Converts massive memory dumped JSON lookup tables (LUTs) into optimized native PHP static buffers via serialization.
- **Strict Format Controls:** Automates `NPVT1` magic byte header validation and filters out whitespace or trailing newline (`\n`) injections.
- **Precise Bitwise Interoperability:** Shifting mimics unsigned 32-bit (`>>>`) operators alongside Big-Endian byte evaluation matching Kotlin/Java counter increments.

### Installation & Directory Layout
├── perfect_dumped_tables.json   # Full dumped JSON tables extracted from Frida
├── convert.php                  # Run once to optimize your raw JSON tables
├── index.php                    # Monolithic engine containing decryptor & payload test
└── .gitignore                   # Ignore runtime files


### Quick Start

1. **Optimize Massive Tables (Recommended):**
   Parsing massive lookup arrays dynamically causes intense CPU overhead. Render them natively once:
```bash
   php convert.php
Run Execution Pipeline:
Provide the decrypted structure or trigger incoming app configs over index.php:

PHP
   $rawConfig = "NPVT1\nCwoL5kFsDa...[Your Encrypted Payload]";
   $result = $importer->importConfig($rawConfig);
   
   print_r($result);
فارسی
یک پیاده‌سازی همه‌جانبه و بسیار بهینه در PHP برای پارس، لایه‌برداری و رمزگشایی پروفایل‌های متقاطع کانفیگ کلاینت (مانند ساختارهای .npvt). این پکیج فرآیند رمزنگاری بلوکی White-Box AES در حالت CTR را شبیه‌سازی می‌کند.

قابلیت‌ها
پیاده‌سازی یکپارچه (Monolithic): ادغام کامل کلاس‌های کنترلر، موتور کریپتو و لایه اعتبارسنجی بدون نیاز به وابستگی‌های جانبی (No Dependencies).

بهینه‌سازی در سطح OPcache: تبدیل جداول غول‌آسای واکشی‌شده جیسون به آرایه‌های ساختاریافته PHP جهت افزایش سرعت پاسخ‌دهی سرور تا ۱۰۰ برابر.

پاک‌سازی کاراکترهای مخدوش‌کننده: خنثی‌سازی هوشمند فاصله‌ها، اینترها (\n) و اعتبارسنجی انحصاری هدر متنی با امضای ساختاری NPVT1.

شبیه‌سازی معماری کاتلین و جاوا: محاسبات بیتی دقیق بر اساس شیفت راست بدون علامت (>>>) و افزایش شمارنده ۱۶ بایتی موازی با کلاینت.

ساختار فایل‌های پروژه
├── perfect_dumped_tables.json   # فایل خام جداول دامپ شده حافظه توسط فرایدا
├── convert.php                  # اسکریپت مبدل و کش‌کننده آرایه‌های جیسون
├── index.php                    # فایل اصلی شامل موتور کریپتو, کانتینرها و پکت تست واقعی
└── .gitignore                   # جلوگیری از آپلود جداول تست شخصی
نحوه راه‌اندازی
۱. بهینه‌سازی ساختار جداول (فقط یک‌بار):
پارس کردن مداوم لوکاپ‌تیبل‌های سنگین باعث کندی پردازش می‌شود. دستور زیر را در ترمینال بزنید تا نسخه کش کامپایل شود:

Bash
   php convert.php
۲. اجرای رمزگشایی کانفیگ:
پکت دریافتی از کلاینت را به متد importConfig پاس دهید تا دیتای سرورها به صورت فرمت JSON استاندارد به شما تحویل داده شود:

PHP
   $rawConfig = "NPVT1\nCwoL5kFsDa...[رشته رمزشده اختصاصی]";
   $result = $importer->importConfig($rawConfig);
   
   print_r($result);
License / لایسنس
This project is open-sourced software licensed under the MIT License.
