# Backend for iEats App and website.

## Requirements:
1. laravel
2. Xamp Server
3. Basic php knowledge.

# Update compooser to avoid errors.
```
composer update
```

# Sample error message
```
Route [login] not defined.
```
- The above error is caused by errors in the headers...

## Admin login URL:
- [Admin](http://localhost:8000/admin)
- Credentials:
```
username: admin
password: admin
```

## API KEYs
- Google map Android key: AIzaSyB9txBevFfFt2ENt4pvW8-Ch6PWfyxHsNo
- Google map iOS key: AIzaSyDnyW47ZnMaCi0sNgUfAbe4lWIZmTh7O1A
- Google map All devices key: AIzaSyDIcs-cXjaLkxO4FHUXdAJsUSXG4UjuvWE
- DBESTECH Google map ;-) key: AIzaSyCMESvjp3G5FtPnukZ28_GVOuFSvEhSS9c


## API DOCUMENTATION:
1. Get popular products
- Endpoint : http://127.0.0.1:8000/api/v1/products/popular
- Headers: Accept : json/application
- Response: 
```
{
    "total_size": 6,
    "type_id": 2,
    "offset": 0,
    "products": [
        {
            "id": 11,
            "name": "Hilsha fish",
            "description": "Ilish Mach aka Hilsa fish is in the season and needless to say, I cooked it a few times this year as well. This year, however, I have used Ilish mach to make simple delicacies mostly. Ilish Beguner Jhol is probably the simplest of the lot, well, after Ilish Mach Bhaja.Ilish Mach aka Hilsa fish is in the season and needless to say, I cooked it a few times this year as well. This year, however, I have used Ilish mach to make simple delicacies mostly. Ilish Beguner Jhol is probably the simplest of the lot, well, after Ilish Mach Bhaja.Ilish Mach aka Hilsa fish is in the season and needless to say, I cooked it a few times this year as well. This year, however, I have used Ilish mach to make simple delicacies mostly. Ilish Beguner Jhol is probably the simplest of the lot, well, after Ilish Mach Bhaja.",
            "price": 12,
            "stars": 5,
            "img": "images/1343ce6cf6792383dfc071727afd5c46.jpeg",
            "location": "china",
            "created_at": "2021-12-27 01:35:34",
            "updated_at": "2022-01-01 03:56:22",
            "type_id": 2
        },
        {
            "id": 1,
            "name": "Nutritious fruit meal in china",
            "description": "This five red bases, two are dedicated to salami (fennel and regular), and there s a classic capricciosa or beef carpaccio. Blanco options include a mushroom, and a four-cheese extravaganza featuring great lobes of a tangy fior di latte they make in house every day (more on this later). Classic, precise, good.I think it s still better to think of this venue not as a pizzeria, but as Pizza, by Di Stasio.Rinaldo Di Stasio and Mallory Wall s empire, including the original restaurant and bar in St Kilda, Citta and now Carlton, is a designer label for dining.",
            "price": 12,
            "stars": 4,
            "img": "images/ea9367e8a16f1d3e41d4a3ae9af2baff.png",
            "location": "Canada, British Columbia",
            "created_at": "2021-11-17 05:09:08",
            "updated_at": "2022-01-01 03:27:22",
            "type_id": 2
        }
    ]
}
```

2. Get recommended products
- Endpoint : http://127.0.0.1:8000/api/v1/products/recommended
- Headers: Accept : json/application
- Response: 
```

```

3. Register User
- Endpoint: http://127.0.0.1:8000/api/v1/auth/register
- Headers: Content-Type : application/json
- Body:
```
{
    "f_name": "B",
    "email": "b@gmail.com",
    "phone": "0727613272",
    "password": "123456"
}
```
- response : 
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMzZhMWNjNWQzN2JjODg5OWZjOWU2M2IzNDIxNTg1NDJhNmVmYWIwMjI0OGQwN2JhNDY5ZjU1ZjAyNjI2ZmJhOWI0M2RmYWVkNjczMTgyNzMiLCJpYXQiOjE2Nzk3NDQyNzAuMDc3MTg4LCJuYmYiOjE2Nzk3NDQyNzAuMDc3MTg5LCJleHAiOjE3MTEzNjY2NzAuMDc1MzQzLCJzdWIiOiI3OSIsInNjb3BlcyI6W119.JVGpPBDojznSNF98DNzNpoTDVmQ4qA65fTfqQ46FWeSCnhbqwyNAftDfCBdQ8c_csdJy8YkhB-jhd-j_WBDWTNg4gRJsfwP-UPJkaDtrxvupQNK3lPnOp0zUp4KB04WVjO4b1QoeC9_1rPpV6siPoZslWjx8Grts4m_bxW5SxJseqZP0bC3Frut2aa2KWxFBVd44AwCbE4M-FOwPhqcBwBinWnsVfNKt8G78jALRZXYWn6zBgQFt4kpQ97HkKCK0Fh59g9jKjsktIJ_CYd5hQnTAmeP7AvZaMsz2kKcfg_ZuKSWFgxsLbMIHkbe0bsBVknDcjf7-5khuXTBAf6l-eq6atwxhfHQ64TO-izANE9F0hTDng5HHOBs06LDtv0J8OY6D8-cF1BkSNjlfmLCWXU8RZy9xn5C_28QuWFv8sfodOjey5zIvg8Kj10rPL7X73L6txjhBIAoqkhx5BTdoFC0Y1R-A_cDrESFB3Ueij6ZY2U-I51xWNHpACCKn0ll8W6ZBBkZNPbE2Czl8Zpxyjb_h1k0X3905lBlB_EQnX8P25qV9i4LUHfbAWy6Q2QfRkVvapHKeJ1_Px0ho7aBPxWQpqOb0rvkkoajZR10J_juZbWl5j2VleDs3vyChVemUSfTcsBTGeyoCXOvnOjaWhNwPFCLp5bWxp6x8Dn4XNV8",
    "is_phone_verified": 0,
    "phone_verify_end_url": "api/v1/auth/verify-phone"
}
```

3. Login User
- Endpoint: http://127.0.0.1:8000/api/v1/auth/login
- Headers: Content-Type : application/json
- Body:
```
{
    "email": "b@gmail.com",
    "password": "123456"
}
```
- response : 
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTMzYTNhZmUzMjYzNDA1MjJmZTk0MjVhZDMzODhmYWNjMzNkMzg0YjJhOWIwMzI1ZjAzNjkyZTY0OTViMGMzOWFlNzM4M2E5ODNmMGFmMTkiLCJpYXQiOjE2Nzk3NDUyNjMuMTM1MTI3LCJuYmYiOjE2Nzk3NDUyNjMuMTM1MTI4LCJleHAiOjE3MTEzNjc2NjMuMTMwODM3LCJzdWIiOiI3OSIsInNjb3BlcyI6W119.Jw0q22oMsjiV-yQFULOc_nehSPsqRGH70php7AS_4PIG8aHIfr94Pa8bCk67o1tj-cGthYaPSKlHMTjbagyGWHMNYYKPHK9kvru-8FMwgZ0gmz0u-Dr8Ka32TKoNhFzhyLQgxFsAICII-J5P5Pkz-Sa4OJ5WMEdUHgf-RNCDZSUIKpjhu6m9sXVALqGmLmWZEBitxiLMdlAtJdXLmrCl3iuVcDjAUtINOY6HDdIR4EEdGQZicjom8axvSVIgPS85RtmJcXU_IuXrm2hRe4IwFjDKJQbZo-NdDvpEkUQ-NKWB4GSuOAjpNliX8zWrUtuyVgHY9rHT16AteyhbETBBAOqkYSzv8fv9jNm77PxXHYVu-fB4qYWH-YihsM4eVPAyftjz3xKrJ_gfE_EnoTafYT1i8Eg3r3jE70K3Fqhq9unpKDxK6J0D38EexWHSCV_7BUtSE0ycaFVIyXefkGEw7Q8cMvVJLmIOZ1ATRXD-TJJb1N8pv9YWY5XzGexWFHcHRjm32poDOLQ_POk3aHqElVYeKBXrFUdNZbgZxeyljX2qzymAJaQaUD3nM-pC8lx1jYiSfxeY2D9-l-fzUCIaDK1uL1rYSkKK_x-sh7MohNKRXcBKvE6lPr59gj4yC7J55w_BJT8DJdHRpMwTb4kf-NV7yk0E-hytX6FhpJ0N0p0",
    "email_verified_at": null
}
```

5. Get Customer info
- Endpoint: http://127.0.0.1:8000/api/v1/customer/info
- Headers: Content-Type : application/json
- Authorization Bearer: [[[Add the token obtained above]]]
- response :
```
{
    "id": 76,
    "f_name": "Martin Wainaina",
    "phone": "0797292290",
    "email": "martin@gmail.com",
    "status": 1,
    "email_verified_at": null,
    "created_at": "2023-03-22 02:24:34",
    "updated_at": "2023-03-22 02:24:34",
    "order_count": 0
}
```

## Paypal Integration
- [Github link](https://github.com/paypal/PayPal-PHP-SDK/wiki/Installation-Composer)
- Install Paypal SDK
```
composer require "paypal/rest-api-sdk-php:*"
or
composer require "paypal/rest-api-sdk-php:*" --ignore-platform-req=ext-sodium
111
```

## create models
- create business Settings and orders model and migrations
```
php artisan make:model BusinessSetting -m
php artisan make:model Order
```

## Install Toastr 
- [Toastr Documentation](https://packagist.org/packages/brian2694/laravel-toastr)
- Use following command to install toastr js:
```
composer require brian2694/laravel-toastr
or
composer require brian2694/laravel-toastr --ignore-platform-req=ext-sodium
```
# Paypal
- My Email: martinwainaina002@gmail.com
- Paypal Sandbox Account: sb-wllwa15159589@business.example.com
- Paypal Client ID: Ab8dCglfrtHWB0gOxJvMdw5RqvG3X5EC2QrH9VRKKa-_wXldtZjIgRwejtqr8Kz-eB2CcljdqpmdkzWr
- Secret key: EIL3gdug3RgJvVWhD-e1NeXO_Yt-i6BljZmIenzhoXN9mngwY2o0022MVwu7JdRh_7PUDeUk4pLjZaJC 


## Paypal payment integration
- [Documentation link] (https://techsolutionstuff.com/post/how-to-integrate-paypal-payment-gateway-in-laravel-8)
- Run the following command in your project to get the latest version of the paypal API package using composer.
```
composer require paypal/rest-api-sdk-php
```

- create controller
```
php artisan make:controller PaypalController
```

# To NB TO SOLVE THE FOLLOWING ERROR:
```
sizeof(): Argument #1 ($value) must be of type Countable|array, string given
```
- The solution is in following link : https://stackoverflow.com/questions/54087631/paypal-sizeof-parameter-must-be-an-array-or-an-object-that-implements-countab
<br>
- Use the following change. <br>
- Change File: vendor\paypal\rest-api-sdk-php\lib\PayPal\Common\PayPalModel.php:
```
} else if (sizeof($v) <= 0 && is_array($v) ) {
```
- to
```
} else if (is_array($v) && sizeof($v) <= 0) {
```

# http://i-eats-api.codegarage.co.ke/ DB
- DB name: codegara_i_eats_db
- Username: codegara_martin
- PSWD : 7zOp^On$#z.b
- DB_HOST: http://i-eats-api.codegarage.co.ke
- SAMPLE .ENV file... NB use the '' for username and password
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=codegara_i_eats_db
DB_USERNAME='codegara_martin'
DB_PASSWORD='7zOp^On$#z.b'
````

## Hosting laravel Web/API on a server:
- [Dbestech youtube link](youtube.com/watch?v=kgC4GXINx-4&t=336s)
- [Dbestech Documentation](https://www.dbestech.com/tutorials/flutter-food-delivery-app-e-commerce-for-ios-and-android)
- To solve Error:
```
Your Composer dependencies require a PHP version ">= 8.1.0" [duplicate]
```
- Follow the following link: https://stackoverflow.com/questions/72846653/your-composer-dependencies-require-a-php-version-8-1-0
- solutions is : 
```
Don't change any thing in your application. In your shard hosting, go to cPanel and find/search Multi PHP Manager. Select your domain or sub domain (whatever you are working with), from dropdown list select PHP 8.1 and apply.
```