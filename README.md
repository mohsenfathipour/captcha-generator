
# Laravel CAPTCHA Generator

A simple CAPTCHA generator for Laravel, designed to be easy to use and highly customizable. This package allows you to create CAPTCHA images with configurable width, height, background color, and characters. It also includes the option to generate dynamic and unique CAPTCHA images for multiple forms.

This package **supports Laravel 11** and provides a clean, lightweight solution for adding CAPTCHA to your forms.

## Features

- **Customizable Width and Height**: Set custom dimensions for the CAPTCHA image.
- **Background Color**: Choose any background color or use a random light color.
- **Contrasting Text Colors**: Text colors are automatically selected to contrast with the background.
- **Noise**: Add random lines for added difficulty.
- **No External Dependencies**: This package does not rely on external libraries or packages.

## Installation

### 1. Install via Composer

Add the package to your Laravel 11 project by running the following command:

```bash
composer require mohsenfathipour/captcha-generator
```

### 2. Publish the Configuration (Optional)

If you want to customize the CAPTCHA settings (like default width, height, or background color), you can publish the configuration file by running:

```bash
php artisan vendor:publish --provider="MohsenFathipour\CaptchaGenerator\CaptchaServiceProvider" --tag="config"
```

This will publish a `captcha.php` file to the `config` directory of your Laravel project.

## Configuration

You can configure the default CAPTCHA options in the `config/captcha.php` file:

```php
return [
    'width' => 120, // Default width of the CAPTCHA image
    'height' => 35, // Default height of the CAPTCHA image
    'characters' => 'ABCDEFGHJKLMNPQRTWZ234679', // Characters used in CAPTCHA (Avoids similar characters)
    'bg_color' => 'F0F0F0', // Default background color (hex format)
];
```

### Custom Background Color and Dimensions

If you want to use custom dimensions or background colors when generating CAPTCHA, you can pass the desired values as parameters to the route.

## Usage

### 1. Generate CAPTCHA Image

To generate the CAPTCHA image, simply access the following route:

```http
GET /captcha/{name?}
```

Where:
- `{name?}` is an optional name for your form or CAPTCHA session. Each form can have its own CAPTCHA stored in the session.

### Example Usage in Blade Template

```html
<img src="{{ url('/captcha/form1') }}" alt="Captcha">
```

This will generate a CAPTCHA image for the form named `form1`.

### 2. Handle CAPTCHA Validation

In your form validation logic, you can validate the CAPTCHA input as follows:

```php
use Illuminate\Support\Facades\Session;

$request->validate([
    'captcha' => function ($attribute, $value, $fail) {
        if ($value !== Session::get('captcha.form1')) {
            $fail('The captcha code is incorrect.');
        }
    },
]);
```

This code validates that the user-entered CAPTCHA matches the one stored in the session for `form1`.

## Example Controller

Here’s how you might use the CAPTCHA in your controller:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MohsenFathipour\CaptchaGenerator\Facades\Captcha;

class MyController extends Controller
{
    public function showCaptchaForm()
    {
        return view('myform');
    }

    public function validateCaptcha(Request $request)
    {
        $request->validate([
            'captcha' => function ($attribute, $value, $fail) {
                if ($value !== Session::get('captcha.form1')) {
                    $fail('The captcha code is incorrect.');
                }
            },
        ]);

        // Your form submission logic here...
    }
}
```

## Customizing CAPTCHA Settings on the Fly

You can pass custom parameters like background color, width, and height directly in the URL:

```http
GET /captcha/{name}?bgColor=FF5733&width=200&height=50
```

This will generate a CAPTCHA with a `#FF5733` background color, `200px` width, and `50px` height.

## License

This package is open source and available under the [MIT License](LICENSE).
