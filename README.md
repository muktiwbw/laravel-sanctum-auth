<p><h1 align="center">Sanctum Auth Boilerplate</h1></p>

## About It

A basic REST API authentication boilerplate using Laravel Sanctum. The boilerplate consists of:
1. Registration
1. Login
1. Email Verification
1. Forgot Password
1. Reset Password

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
