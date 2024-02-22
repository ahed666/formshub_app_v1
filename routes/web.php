<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddForm;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UnsubscribeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SignPdfController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LocaleGuestController;
use App\Http\Controllers\PaymentController;

use Laravel\Jetstream\Http\Controllers\Livewire\AccountController;


use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Kiosk;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Form;
use App\Models\Answers;
use App\Models\Logos;
use App\Models\FormTrnslations;
use App\Models\AnswersTranslation;
use App\Models\QuestionType;
use App\Models\AccountUser;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\File;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use App\Models\Invoice;
use App\Models\FormType;
use App\Models\SubscribePlan;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\FormTemplate;


use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\App;
use Laravel\Jetstream\Http\Controllers\CurrentAccountController;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Livewire\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Livewire\TermsOfServiceController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Jetstream\Http\Controllers\AccountInvitationController;



// require_once __DIR__ .'/jetstream.php';
// require_once __DIR__.'/auth.php';

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $enableViews = config('fortify.views', true);

    // Authentication...
    if ($enableViews) {

        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('login');
    }

    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '1,3');


    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:'.config('fortify.guard'),
            'throttle:login',
        ]));

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        if ($enableViews) {
            Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('password.request');

            Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('password.reset');
        }

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('password.email');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('password.update.forget');
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('register');
        }

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')]);
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        if ($enableViews) {
            Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
                ->name('verification.notice');
        }

        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'signed', 'throttle:'.$verificationLimiter])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'throttle:verify-email'])
            ->name('verification.send');


    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
            ->name('user-profile-information.update');
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/user/password', [PasswordController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
            ->name('user-password.update');
    }

    // Password Confirmation...
    if ($enableViews) {
        Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')]);
    }

    Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
        ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
        ->name('password.confirmation');

    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
        ->name('password.confirm');

    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        if ($enableViews) {
            Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('two-factor.login');
        }

        Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:'.config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
            ]));

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'password.confirm']
            : [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')];

        Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');

        Route::post('/user/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.confirm');

        Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.disable');

        Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');

        Route::get('/user/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.secret-key');

        Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.recovery-codes');

        Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
            ->middleware($twoFactorMiddleware);
    }
});
Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    $authMiddleware = config('jetstream.guard')
            ? 'auth:'.config('jetstream.guard')
            : 'auth';

    $authSessionMiddleware = config('jetstream.auth_session', false)
            ? config('jetstream.auth_session')
            : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
        // User & Profile...
        Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');

        Route::group(['middleware' => 'verified'], function () {
            // API...
            if (Jetstream::hasApiFeatures()) {
                Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            }

            // Accounts...
            if (Jetstream::hasAccountFeatures()) {

                Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
                Route::get('/accounts/{account}', [AccountController::class, 'show'])->name('accounts.show');
                Route::put('/current-account', [CurrentAccountController::class, 'update'])->name('current-account.update');

                Route::get('/account-invitations/{invitation}', [AccountInvitationController::class, 'accept'])
                            ->middleware(['signed'])
                            ->name('account-invitations.accept');
            }
        });
    });
});
// auth


Route::middleware('guest')->group(function () {


    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                // ->middleware('throttle:1,3')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// admin
Route::group(['prefix'=>'admin-center','middleware'=>['admin:admin']],function(){
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');


   });



Route::group(['prefix'=>'admin-center','middleware'=>['auth:admin']],function(){

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
    Route::get('/invoices', [AdminController::class, 'invoices'])->name('admin.invoices');
    Route::get('/kiosks', [AdminController::class, 'kiosks'])->name('admin.kiosks');
    Route::get('/forms', [AdminController::class, 'forms'])->name('admin.forms');
    Route::get('/printinvoice/{id}', [AdminController::class, 'printInvoice'])->name('admin.print');
    Route::post('/changestatus', [AdminController::class, 'changestatus'])->name('admin.changestatus');
    Route::get('/supporttickets', [AdminController::class, 'supportTickets'])->name('admin.supportTickets');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/changeorderstatus', [AdminController::class, 'changeorderstatus'])->name('admin.changeorderstatus');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');

    Route::get('/deletedaccounts', [AdminController::class, 'deletedaccounts'])->name('admin.deletedaccounts');
    Route::get('/canceledplans', [AdminController::class, 'canceledplans'])->name('admin.canceledplans');
    Route::post('/updateinfo',[AdminController::class, 'updateAdminInfo'] )->name('admin.info.update');
    Route::post('/saveplan',[AdminController::class, 'saveplan'] )->name('admin.saveplan');
    Route::post('/changeaccountstatus',[AdminController::class, 'changeaccountstatus'] )->name('admin.changeaccountstatus');
    Route::post('/saveresponsescategories',[AdminController::class, 'saveresponsescategories'])->name('admin.saveresponsescategories');
    Route::post('/logout',[AdminController::class, 'destroy'])->name('admin.logout');
    Route::post('/adminlogoutsession/{id}',[AdminController::class, 'adminLogout'])->name('admin.adminLogout');
});
//    Route::middleware(['auth:admin'])->get('/admin-center/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// end admin


Route::get('/', function () {
    return view('welcome');
});


//   form of kiosk
Route::get('/devices/{device_name}/{device_id}',[FormController::class, 'index']);

Route::get('/loader',function()
{

    return view('loader');
}
);

// end unsubscribe

//external urls
//terms and conditions
Route::get('/terms_conditions',function()
{

    $externalUrl = env('WEBSITE_URL').'/termsandconditions'; // Replace this with your external URL
    return redirect()->away($externalUrl);
}
)->name('terms_conditions');
// privacy policy
Route::get('/privacypolicy',function()
{

    $externalUrl = env('WEBSITE_URL').'/privacypolicy'; // Replace this with your external URL
    return redirect()->away($externalUrl);
}
)->name('privacypolicy');


Route::middleware([
    'auth:sanctum',
    'language',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    //payments

    Route::get('/payment/{id}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/{id}/stripe/payment-intent', [PaymentController::class, 'createStripePaymentIntent'])->name('payment.paymentIntent.create');
    Route::get('/payment/{id}/stripe/callback', [PaymentController::class, 'confirm'])->name('stripe.return');



    // change language
    Route::get('setlocale/{locale}',[LocaleController::class, 'setLocale'])->name('setLocale');
    // statistics
    Route::get('/statistics/overview/{id}',[StatisticsController::class, 'overview'])->name('statisticform');
Route::get('/statistics/questions-statistics/{id}',[StatisticsController::class, 'questionsStatistics'] )->name('questions-statistics');
Route::get('/statistics/all-responses/{id}',[StatisticsController::class, 'allResponses'])->name('all-responses');


Route::get('/signpdf',[SignPdfController::class, 'signPdfIndex'])->name('signpdf.index');
Route::get('/addsignpdf',[SignPdfController::class, 'addSignPdf'])->name('signpdf.add');


// view pdf
Route::get('/view-pdf/{id}', [PdfController::class, 'viewPdf'])->name('view.pdf');
Route::get('/download-pdf/{id}', [PdfController::class, 'downloadPdf'])->name('download.pdf');



 // statistics of form
//  Route::get('/statistics/{id}', function ($id) {

//     return view('statistics');
// })->name('statisticform');
    // unsubscribe create view
Route::get('/unsubscribe/{type}/{token}/{userid}',[UnsubscribeController::class, 'create'])->name('unsubscribe');

Route::post('/confirm_unsubscribe/{type}/{token}/{userid}',[UnsubscribeController::class, 'store'])->name('confirm_unsubscribe');
Route::post('/save_question',[QuestionController::class, 'save'])->name('save_question');

    // pdf controller
//  Route::get('preview', 'App\Http\Controllers\PDFController@preview')->name('preview');
//  Route::post('/convert-excel-to-pdf', 'App\Http\Controllers\ReportController@convert');
// Route::post('/subscriptions', [SubscriptionController::class, 'create'])->name('subscriptions.create');
// Route::get('/',         [SubscriptionController::class, 'index']);

// langauges of forms
Route::get('/langugages/add/{form_id}/{code}', [LanguagesController::class, 'addLang'])->name('addlang');

    // dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


Route::post('/payment', [SubscriptionController::class, 'payment']);
    // dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/invoices/{id}', function ($id) {
        $invoices = Invoice::whereid($id)->get();

        return view('pdf.invoice',compact('invoices'));
    })->name('invoicepdf');

    // edit form route
    Route::get('/forms/{id}/{lastLocal?}', function ($id,$lastLocal = null) {
        $form=Form::find($id);
        if($form){
        if(Auth::user()->current_account_id==$form->account_id)
          {  $type_id=FormType::whereid(Form::whereid($id)->first()->form_type_id)->first()->id;
            return view('edit_form',compact('id','type_id','lastLocal'));}
        else
        abort(403, 'Unauthorized action.');}
        else  return redirect('/forms');
    })->name('editform');



    Route::post('/upload',function(){})->name('crop');
    // dashboard route
    Route::get('/statistics', function () {
        return view('statistics');
    })->name('statistics');

    // Route::get('/devices/{device_name}/{device_code}',FormTemplate::class);
    // kiosks route
    Route::get('/kiosks', function () {


        return view('kiosks');

    })->name('kiosks');
    // form route
    Route::get('/forms', function () {

        return view('forms' );

    })->name('forms');
    // billing route
    Route::get('/payment_billing', function () {

        return view('accounts.billings' );

    })->name('billings');
    // subscriptions route
    Route::get('/subscriptions', function () {

        return view('accounts.subscriptions' );

    })->name('subscriptions');
    // subscription to plan  route
      // subscriptions route
      Route::get('/subscribe/{type?}/{id?}', function ($type=null,$id=null) {

        $account = Jetstream::newAccountModel()->findOrFail(Auth::user()->currentAccount->id);
        $accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->currentAccount->id);

        if($account->user_id==Auth::user()->id)
        {
            if(($accountStatus['status']=='Locked'||$accountStatus['status']=='Grace')&&$type=="buyresponses")
            return redirect('/subscriptions')->with('error','check on your subscription status');
            else
            return view('subscribe',compact('type','id') );


        }
        elseif($accountuser=AccountUser::whereaccount_id($account->id)->whereuser_id(Auth::user()->id)->first())
        {
            if($accountuser->role=="admin")
            {
                if(($accountStatus['status']=='Locked'||$accountStatus['status']=='Grace')&&$type=="buyresponses")
                    return redirect('/subscriptions')->with('error','check on your subscription status');
                else
                    return view('subscribe',compact('type','id') );


            }
            else
            {
                return redirect('/subscriptions')->with('error','check on your role in this account');




            }

        }


    })->name('subscribe');
    Route::get('/todo', function () {

        return view('todolist' );

    })->name('todolist');

    // preview form
    Route::get('/preview/{id}', function ($id) {

        return view('preview',compact('id'));

    })->name('preview');


    Route::get('/previewform/{id}',[FormController::class,'preview'] )->name('previewform');



    Route::get('/support', function () {

        return view('support');

    })->name('support');



    // print response
    Route::get('/printresponse/{id}/{lang}', [PDFController::class, 'response'])->name('printresponse');

    // unlinkkiosks
    Route::get('unlinkkiosks', [DeviceController::class, 'unlink'])->name('unlinkkiosks');
});

Route::get('/login/{user}', function ($user) {
    $user=User::whereid($user)->first();
    // Auth::logout($user);
     return redirect()->route('login');
})->name('loginfromregister');

Route::get('setlocale/{locale}',[LocaleController::class, 'setLocale'])->name('setLocale');

// require_once __DIR__ .'/jetstream.php';
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


