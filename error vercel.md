# Illuminate\Database\QueryException - Internal Server Error

SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql-37b9928d-vyd.l.aivencloud.com failed: System error (Connection: mysql, Host: mysql-37b9928d-vyd.l.aivencloud.com, Port: 28767, Database: defaultdb, SQL: select * from `sessions` where `id` = 9BjwkM9ICz8Ggy5fgPYkE7loQnISrsMk6QinNQN8 limit 1)

PHP 8.5.2
Laravel 12.62.0
aplikasi-healing-three.vercel.app

## Stack Trace

0 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
1 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:999
2 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:978
3 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:796
4 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:411
5 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3505
6 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3490
7 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:4080
8 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3489
9 - vendor/laravel/framework/src/Illuminate/Database/Concerns/BuildsQueries.php:366
10 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3412
11 - vendor/laravel/framework/src/Illuminate/Session/DatabaseSessionHandler.php:96
12 - vendor/laravel/framework/src/Illuminate/Session/Store.php:128
13 - vendor/laravel/framework/src/Illuminate/Session/Store.php:116
14 - vendor/laravel/framework/src/Illuminate/Session/Store.php:100
15 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:146
16 - vendor/laravel/framework/src/Illuminate/Support/helpers.php:393
17 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:143
18 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:115
19 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:63
20 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
21 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php:36
22 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
23 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php:74
24 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
25 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
26 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:821
27 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:800
28 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:764
29 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:753
30 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:200
31 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
32 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
33 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php:31
34 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
35 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
36 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php:51
37 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
38 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php:27
39 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
40 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php:109
41 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
42 - vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php:61
43 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
44 - vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php:58
45 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
46 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php:22
47 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
48 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php:26
49 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
50 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
51 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:175
52 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:144
53 - vendor/laravel/framework/src/Illuminate/Foundation/Application.php:1220
54 - public/index.php:20
55 - api/index.php:4

## Request

GET /

## Headers

* **x-vercel-internal-intra-session**: 3.wDqMIHEX2fqjjX4af2gAtFwzSS+WeL0hLHFFmDPifLLZhSSQgfY9NBjDZiwK6xui
* **accept-encoding**: gzip, deflate, br, zstd
* **x-vercel-ip-latitude**: -6.7456
* **sec-fetch-dest**: document
* **x-vercel-deployment-url**: aplikasi-healing-au8yeecen-vyds-projects-761a2afb.vercel.app
* **x-vercel-sc-runtime-cache**: 1
* **sec-ch-ua-mobile**: ?0
* **referer**: https://vercel.com/
* **forwarded**: for=182.10.161.229;host=aplikasi-healing-three.vercel.app;proto=https;sig=0QmVhcmVyIDA3OTY3ZDkyMWJkOGIzMzY5YzlkNzI1MGYxNjM3YWYwNzc0YzBmMmFlYTU4ZGJjYjcxOGVlNjM0M2NiOGVkNjY=;exp=1782906324
* **x-forwarded-for**: 182.10.161.229
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36
* **x-vercel-ip-longitude**: 108.5516
* **sec-fetch-mode**: navigate
* **x-vercel-ip-as-number**: 23693
* **x-forwarded-host**: aplikasi-healing-three.vercel.app
* **x-real-ip**: 182.10.161.229
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
* **x-vercel-sc-basepath**: 
* **x-vercel-sc-no-header-leak**: 1
* **x-vercel-proxied-for**: 182.10.161.229
* **x-vercel-proxy-signature**: Bearer 07967d921bd8b3369c9d7250f1637af0774c0f2aea58dbcb718ee6343cb8ed66
* **x-vercel-internal-sni-host**: aplikasi-healing-three.vercel.app
* **accept-language**: id,en-US;q=0.9,en;q=0.8
* **x-vercel-oidc-token**: eyJraWQiOiJtcmstNDMwMmVjMWI2NzBmNDhhOThhZDYxZGFkZTRhMjNiZTciLCJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE3ODI5MDYwMjQsInNjb3BlIjoib3duZXI6dnlkcy1wcm9qZWN0cy03NjFhMmFmYjpwcm9qZWN0OmFwbGlrYXNpLWhlYWxpbmc6ZW52aXJvbm1lbnQ6cHJvZHVjdGlvbiIsIm5iZiI6MTc4MjkwNjAyNCwiaXNzIjoiaHR0cHM6XC9cL29pZGMudmVyY2VsLmNvbVwvdnlkcy1wcm9qZWN0cy03NjFhMmFmYiIsInN1YiI6Im93bmVyOnZ5ZHMtcHJvamVjdHMtNzYxYTJhZmI6cHJvamVjdDphcGxpa2FzaS1oZWFsaW5nOmVudmlyb25tZW50OnByb2R1Y3Rpb24iLCJleHAiOjE3ODI5MTMyMjQsInByb2plY3QiOiJhcGxpa2FzaS1oZWFsaW5nIiwicHJvamVjdF9pZCI6InByal83bWdxbkFwVTlsbnphTFVDVWE4WFZwcmZzVEJ6Iiwib3duZXJfaWQiOiJ0ZWFtX3JrcjRzR1hNZkNmbEhoSEVMNU85U1QzRSIsInBsYW4iOiJob2JieSIsImF1ZCI6Imh0dHBzOlwvXC92ZXJjZWwuY29tXC92eWRzLXByb2plY3RzLTc2MWEyYWZiIiwiZW52aXJvbm1lbnQiOiJwcm9kdWN0aW9uIiwib3duZXIiOiJ2eWRzLXByb2plY3RzLTc2MWEyYWZiIn0.CGX-wZukwXYSpCXvYGuZxzv6hPnXi7p0PHm69zuImTmgl-Xrulhu7Kgz2rgZJ9bVE-rPUPDQxNZYkd5Kx3AvnNvxFHKA3vxGCKKN2xj5vz0DHpCnLrTxEIuB6JJ2jlh2LQmp8Yuu_L974UTo1yE403o5bI5GjxuRVUkmjOcvInQo7mXYoVefbLXvukrsAkSJCQfJTW5RpAZkt0cRQ9S8oJjFcF8XjqyYyOMv3XIyCFH__j1szMV1CgThg7jTI1VskLu2NxU4lDmCwKvBcBDy7rYJNiByiyoBRaLUiqA_rz9M8jvwDm1oaJDl77n1Nqb9iE19JXmQvanmEPM5mOZSrA
* **x-vercel-sc-headers**: {"x-vercel-function-platform":"vercel\/proxy+serverless","Authorization":"Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE3ODI5MDYwMjQsIm93bmVySWQiOiJ0ZWFtX3JrcjRzR1hNZkNmbEhoSEVMNU85U1QzRSIsImJsb2NrIjpmYWxzZSwiaXNzIjoic2VydmVybGVzcyIsInVubGltaXRlZCI6ZmFsc2UsImV4cCI6MTc4MjkwNzg0NCwicGxhbiI6ImhvYmJ5IiwicHJvamVjdElkIjoicHJqXzdtZ3FuQXBVOWxuemFMVUNVYThYVnByZnNUQnoiLCJkZXBsb3ltZW50SWQiOiJkcGxfRmU1RW43WEExYVBGTGdrcTZWMkpNSGhUZnJBMSIsInJlcXVlc3RJZCI6ImxxY2JxLTE3ODI5MDYwMjQyMDQtYjlmMGRkNzZkYTk0IiwiZG9tYWluIjoiYXBsaWthc2ktaGVhbGluZy10aHJlZS52ZXJjZWwuYXBwIiwiZW52IjoicHJvZHVjdGlvbiJ9.Mi6440rAkKOEb9pmumqk6RUD6gezNpAlsVKND1EkFho","x-vercel-ept":"0"}
* **host**: aplikasi-healing-three.vercel.app
* **x-vercel-ja4-digest**: t13d1517h2_8daaf6152771_b6f405a00624
* **x-vercel-ip-city**: Cirebon
* **sec-fetch-user**: ?1
* **x-vercel-proxy-signature-ts**: 1782906324
* **x-vercel-ip-country**: ID
* **x-vercel-id**: sin1::lqcbq-1782906024204-b9f0dd76da94
* **x-vercel-enable-rewrite-caching**: 1
* **x-vercel-sc-host**: iad1.suspense-cache.vercel-infra.com
* **x-vercel-internal-bot-check**: skip
* **sec-ch-ua-platform**: "Windows"
* **x-forwarded-proto**: https
* **priority**: u=0, i
* **sec-fetch-site**: cross-site
* **x-vercel-internal-ingress-bucket**: bucket018
* **sec-ch-ua**: "Google Chrome";v="149", "Chromium";v="149", "Not)A;Brand";v="24"
* **x-vercel-ip-postal-code**: 45171
* **x-vercel-internal-waf-tags**: res-proxy
* **x-vercel-ip-continent**: AS
* **x-vercel-ip-country-region**: JB
* **x-vercel-ip-timezone**: Asia/Jakarta
* **x-vercel-internal-ingress-port**: 18445
* **x-vercel-forwarded-for**: 182.10.161.229
* **connection**: keep-alive

## Route Context

controller: Closure
middleware: web

## Route Parameters

No route parameter data available.

## Database Queries

No database queries detected.
