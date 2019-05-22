Curler
==

cURL helper for PHP

[![Build Status](https://travis-ci.org/wernerdweight/Curler.svg?branch=master)](https://travis-ci.org/wernerdweight/Curler)
[![Latest Stable Version](https://poser.pugx.org/wernerdweight/curler/v/stable)](https://packagist.org/packages/wernerdweight/curler)
[![Total Downloads](https://poser.pugx.org/wernerdweight/curler/downloads)](https://packagist.org/packages/wernerdweight/curler)
[![License](https://poser.pugx.org/wernerdweight/curler/license)](https://packagist.org/packages/wernerdweight/curler)

Instalation
--

1) Download using composer

```bash
composer require wernerdweight/curler
```

2) Use in your project

```php
use WernerDweight\Curler\Curler;
use WernerDweight\Curler\Request;

$curler = new Curler();
$request = (new Request())
    ->setEndpoint('https://some-website.tld')
    ->setMethod('POST')
    ->setPayload(['key' => 'value'])
    ->setHeaders(['Accept: text/html', 'Accept-Encoding: gzip'])
    ->setAuthentication('user', 'password')
;
$response = $curler->request($request);
echo $response->text();  // '<html>...</html>'
var_dump($response->getMetaData()); // array of response metadata (content-type, status...)
```

API
--

#### Curler
* **`request(Request $request): Response`**  \
Allows to fetch data according to given `$request`.

#### Request
* **`setEndpoint(string $endpoint): self`**
* **`getEndpoint(): ?string`**
* **`setMethod(string $method): self`**
* **`getMethod(): ?string`**
* **`setPayload(array $payload): self`**
* **`getPayload(): ?array`**
* **`setHeaders(array $headers): self`**
* **`addHeader(string $header): self`**
* **`removeHeader(string $header): bool`**
* **`getHeaders(): ?array`**
* **`setAuthentication(string $user, string $password): self`**
* **`getAuthentication(): ?array`**

#### Response
* **`getMetaData(): WernerDweight\RA\RA`** \
cURL info (see [here](https://www.php.net/manual/en/function.curl-getinfo.php)).
* **`ok(): bool`** \
Returns a boolean stating whether the response was successful (status in the range 200-299) or not.
* **`redirected(): bool`** \
Returns whether or not the response is the result of a redirect; that is, redirect count is more than zero.
* **`status(): int`** \
Returns the status code of the response (e.g., 200 for a success).
* **`contentType(): string`** \
Returns the content type of the response (e.g., text/html).
* **`url(): string`** \
Returns the URL of the response.
* **`text(): string`** \
Returns the response as text.
* **`json(): WernerDweight\RA\RA`**
Returns the response as RA (see [here](https://github.com/wernerdweight/RA)).
