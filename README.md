<p><h1 align="center">Sanctum Auth Boilerplate</h1></p>

## About It

A basic REST API authentication boilerplate using Laravel Sanctum. The boilerplate consists of:
1. Registration
1. Login
1. Email Verification
1. Forgot Password
1. Reset Password

## Installation

Clone this repository and run `composer install && php artisan key:generate`.

## Setting Up

This boilerplate is using UUIDs as the User primary id. Thus, in order to get sanctum work you should tweak the default settings a little bit. Of course you can change that if you want the default auto-increment primary id.

### Sanctum Personal Token

The making of this boilerplate followed the instruction on Laravel Sanctum installation section on it's official website. But before you migrate the database, go to the personal access token migration file and change the tokenable field type from `morphs` to `uuidMorphs`. You can keep it to `morphs` if you want to use default incrementing primary id for User.
```
// from
$table->morphs('tokenable');

// to
$table->uuidMorphs('tokenable');
```

### User Increment ID
As I said in the beginning, the User model is using UUIDs as the primary id. Now you can change it back to default incrementing integer in the migration. But you might want to also change the `$incrementing` property in User model to true. Or you can just delete the line since that line is overriding the same property on Model.
```
public $incrementing = true;
```

### Mailing
This authentication boilerplate is using a simple SMTP mailing. Make sure to fill out your mail credentials on .`env` file.

### Token Abilities
The default tokens that are generated don't have any abilities at all. Means that all users can access any endpoint on your site. Make sure to set their abilities. You can refer to the [Token Abilities section](https://laravel.com/docs/8.x/sanctum#token-abilities) on Laravel Sanctum official documentation site

## MVC Structure
This boilerplate is aimed for REST API backend application. You might want to be extra careful to not leak any exception warnings to your clients. That's why I made some helper functions specifically for catching exceptions. People usually use `try catch` block for catching errors. But constantly typing those will flood your controllers with the same codes and obviously makes it redundant.

Before using the helpers, make sure you add them into your `composer.json` file in autoload > files. In this case the files are `app/Helpers/responses.php` abd `app/Helpers/responses.php`.
```
"autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        },
        "files": [
            "app/Helpers/responses.php",
            "app/Helpers/catcher.php"
        ]
    },
```
Once you've done that, jump into your terminal and run `composer dump-autoload`. The helpers are now ready to use.

### Catcher
The `catcher` helper helps you to encapsulate your functions' logic in a `try catch`. The whole function is just literally a `try catch` block.
```
function catcher($fn) {
  try {
    return $fn();
  } catch (\Exception $e) {
    return response()->json(err($e));
  }
}
```
Now to use this helper, you need to wrap your functions' logic in your controller in an anonymous function and assign it to a variable.
```
// Let's say you have this controller named SomeController
class SomeController extends Controller {

    // And a function named someLogic()
    public function someLogic(Request $request) {
        
        // A function wrapper
        $fn = function () use ($request) {
            
            // Your logic here...
            
            return response()->json(['message' => 'Hello!']);
        }
        
        // Return catcher() helper with $fn as an argument
        return catcher($fn);
    }
    
}
```

### Responses
Use the response helpers to generate responses. There is `res()` for generating success responses. The other thing is `err()` for generating failed response. Now at this point this boilerplate currently has basic authentication responses. Feel free to add more codes and error messages on `app/Helpers/responses.php` file.

### Form Request Validation
Other thing to consider in order to tidy up your codes is to use Form Request Validations. You can refer to the [Form Request Validation section](https://laravel.com/docs/8.x/validation#form-request-validation) on Laravel official site. This boilerplate is using `AuthRequest` for validation. This class handles all of the request fired on all of the authentication endpoints. You can edit the validation rules and their messages at `app/Http/Requests/AuthRequest.php`.
```
public function rules() {
    $path = explode('/', Request::path())[1];

    return [
        'name' => Rule::requiredIf($path === 'register'),
        'email' => Rule::requiredIf(in_array($path, ['register', 'login', 'forgot-password', 'reset-password'])),
        'password' => Rule::requiredIf(in_array($path, ['register', 'login', 'reset-password'])),
        'password_confirm' => [
            Rule::requiredIf(in_array($path, ['register', 'reset-password'])),
            'same:password'
        ],
        'token' => Rule::requiredIf($path === 'reset-password')
    ];
}
```

