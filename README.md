# 花凜

這是一個使用 [Laravel](https://laravel.com/) 框架開發的網站。

目的在於提供我自己開發的機器人一個後端 API 介面。

名字發想來自於我玩的遊戲 [公主連結 Re:dive](https://priconne-redive.jp/) 中的角色 [花凜](https://pcredivewiki.tw/static/images/unit_big/unit_big_118531.jpg)。

## 環境需求

- PHP >= 8.1.13
- Composer
- MySQL
- Redis

## 安裝

1. 複製 `.env.example` 為 `.env`，並修改其中的設定。
2. 執行 `composer install` 安裝相依套件。

## 執行

### 透過 `sail` 執行

1. 執行 `./vendor/bin/sail up -d` 啟動 Docker 容器。
2. 執行 `./vendor/bin/sail artisan migrate` 執行資料庫遷移。

### 透過 `artisan` 執行

1. 執行 `php artisan migrate` 執行資料庫遷移。
2. 執行 `php artisan serve` 啟動內建的 PHP 伺服器。
