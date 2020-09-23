# Imageplus Authentication
Simple authentication scaffolding based off Laravel Fortify built with InertiaJS, VueJS and Bootstrap

## Getting Started
To install the package you must run

```
composer i imageplus/auth-scaffolding
```

Once the package has installed run

```
php artisan imageplus:scaffold-auth
```
This will generate the auth scaffolding in the application

The package required certain npm packages so after running the above please run ```npm i``` to install the required packages

The package uses the database session driver so to create this table run the migration with ```php artisan migrate```

## Toggling Functionality
Some of the Fortify features are optional. You may disable the features by removing them from the features array found at ```config/fortify.php```. You're free to only remove some of these features, or you can even remove all of these if you need to.

This package does have some of its own custom functionality which can be disabled in its config file locations at ```config/imageplus-auth-scaffolding.php``` but this first must be published
### 2 Factor Authentication
This comes enabled by default within fortify but the trait ```TwoFactorAuthenticatable``` must be added to the User model to enable this functionality

### Email Verification
To enable this uncomment the line ```Features::emailVerification()``` in ```config/fortify.php``` and implement the contract ```MustVerifyEmail```

## Routes
Please use the ImagePlusAuthScaffolding class or config as apposed to Fortify as the custom provider allows the use of InertiaJS authentication views

The views themselves are configured in 2 places. 

#### The config file 
which must first be published using the below command
```
php artisan vendor:publish --tag=imageplus-auth-scaffolding-config
```
Once published you can change the array values to the Inertia Component you want to use

#### The ImageplusAuthServiceProvider
Routes can be changed in here by removing the line ```ImageplusAuthScaffolding::useDefaultViews();``` and calling the below functions directly with an Inertia view
```
ImageplusAuthScaffolding::loginView($view)
ImageplusAuthScaffolding::twoFactorChallengeView($view)
ImageplusAuthScaffolding::resetPasswordView(
    $view,
    function($request) {
        return [
            'token' => $request->route()->parameter('token')
        ];
    }
);
ImageplusAuthScaffolding::registerView($view)
ImageplusAuthScaffolding::verifyEmailView($view)
ImageplusAuthScaffolding::confirmPasswordView($view)
ImageplusAuthScaffolding::requestPasswordResetLinkView($view)
```
*Please note additional data can be given as a second parameter as either an array or a function*

##### Changing The Login View
The below code shows an example of how to change the login view. It will change the login view to the Login component inside the Auth folder in the Pages directory as well as passing the additional prop foo
```
ImageplusAuthScaffolding::loginView('Auth/Login', ['foo' => 'bar'])
```

## Browser Sessions
The package can logout all other instances of a users account with the *logout-other-sessions* feature enabled but for this to work the ```\Illuminate\Session\Middleware\AuthenticateSession::class``` middleware must be enabled

## Other Help
Any information not found here can be found on the official documentation for the other packages required

- [Fortify](https://github.com/laravel/fortify).
- [InertiaJS](https://inertiajs.com/).
