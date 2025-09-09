<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\newsletterController;
use App\Http\Controllers\WeeztixController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StatueController;
use App\Http\Controllers\OldBoardsController;
use App\Http\Controllers\CommissionController;
use \App\Http\Controllers\AboutUsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::get('/announcements', [AnnouncementController::class, 'publicIndex'])->name('public.announcements.index');
Route::get('/announcement/{id}', [AnnouncementController::class, 'show'])->name('user.announcement.show');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::prefix('gallery')->name('admin.gallery.')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::post('/store/{modelname}', [GalleryController::class, 'storeGallery'])->name('store');
            Route::prefix('{model}/{id}')->group(function () {
                Route::post('/upload', [GalleryController::class, 'uploadGallery'])->name('upload');
                Route::get('/fetch', [GalleryController::class, 'fetchGallery'])->name('fetch');
                Route::delete('/delete', [GalleryController::class, 'deleteGallery'])->name('delete');
                Route::post('/update-metadata', [GalleryController::class, 'updateMetadata'])->name('update-metadata');
            });
        });

        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        // Announcements
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements.index');
        Route::prefix('announcement')->name('admin.announcements.')->group(function () {
            Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
            Route::post('/store', [AnnouncementController::class, 'store'])->name('store');
            Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
            Route::put('/update/{announcement}', [AnnouncementController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [AnnouncementController::class, 'delete'])->name('delete');
        });

        Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
        Route::prefix('/event')->group(function () {
            Route::get('/create', [EventController::class, 'create'])->name('admin.event.create');
            Route::post('/store', [EventController::class, 'store'])->name('admin.event.store');
            Route::get('/{id}', [EventController::class, 'show'])->name('admin.event.show');
            Route::put('/update/{id}', [EventController::class, 'update'])->name('admin.event.update');
            Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('admin.event.delete');
        });

        Route::get('/sponsors', [SponsorController::class, 'index'])->name('admin.sponsors.index');
        Route::prefix('/sponsor')->group(function () {
            Route::get('/create', [SponsorController::class, 'create'])->name('admin.sponsor.create');
            Route::post('/store', [SponsorController::class, 'store'])->name('admin.sponsor.store');
            Route::get('/{id}', [SponsorController::class, 'show'])->name('admin.sponsor.show');
            Route::put('/update/{id}', [SponsorController::class, 'update'])->name('admin.sponsor.update');
            Route::delete('/delete/{id}', [SponsorController::class, 'delete'])->name('admin.sponsor.delete');
        });

        Route::get('/boards', [BoardController::class, 'index'])->name('admin.board.index');
        Route::prefix('/board')->group(function () {
            Route::get('/create', [BoardController::class, 'create'])->name('admin.board.create');
            Route::post('/store', [BoardController::class, 'store'])->name('admin.board.store');
            Route::get('/{id}', [BoardController::class, 'show'])->name('admin.board.show');
            Route::put('/update/{id}', [BoardController::class, 'update'])->name('admin.board.update');
            Route::delete('/delete/{id}', [BoardController::class, 'delete'])->name('admin.board.delete');
        });

        Route::get('/statues', [StatueController::class, 'index'])->name('admin.statues.index');
        Route::prefix('statue')->group(function () {
            Route::post('/store', [StatueController::class, 'store'])->name('admin.statue.store');
            Route::put('/update', [StatueController::class, 'update'])->name('admin.statue.update');
        });

        Route::get('/old_boards', [OldBoardsController::class, 'index'])->name('admin.old_boards.index');
        Route::prefix('/old_boards')->group(function () {
            Route::get('/create', [OldBoardsController::class, 'create'])->name('admin.old_boards.create');
            Route::post('/store', [OldBoardsController::class, 'store'])->name('admin.old_boards.store');
            Route::get('/{id}', [OldBoardsController::class, 'show'])->name('admin.old_boards.show');
            Route::put('/update/{id}', [OldBoardsController::class, 'update'])->name('admin.old_boards.update');
            Route::delete('/delete/{id}', [OldBoardsController::class, 'delete'])->name('admin.old_boards.delete');
        });

        Route::get('/commissions', [CommissionController::class, 'index'])->name('admin.commission.index');
        Route::prefix('/commission')->group(function () {
            Route::get('/create', [CommissionController::class, 'create'])->name('admin.commission.create');
            Route::post('/store', [CommissionController::class, 'store'])->name('admin.commission.store');
            Route::get('/{id}', [CommissionController::class, 'show'])->name('admin.commission.show');
            Route::put('/update/{id}', [CommissionController::class, 'update'])->name('admin.commission.update');
            Route::delete('/delete/{id}', [CommissionController::class, 'delete'])->name('admin.commission.delete');
        });

        Route::get('/assignments', [AssignmentController::class, 'index'])->name('admin.assignments.index');
        Route::prefix('/assignment')->group(function () {
            Route::get('/create', [AssignmentController::class, 'create'])->name('admin.assignment.create');
            Route::post('/store', [AssignmentController::class, 'store'])->name('admin.assignment.store');
            Route::get('/{id}', [AssignmentController::class, 'show'])->name('admin.assignment.show');
            Route::put('/update/{id}', [AssignmentController::class, 'update'])->name('admin.assignment.update');
            Route::delete('/delete/{id}', [AssignmentController::class, 'delete'])->name('admin.assignment.delete');
        });

        Route::prefix('/weeztix')->name('admin.weeztix.')->group(function () {
            Route::get('/', [WeeztixController::class, 'index'])->name('index');
            Route::get('/callback', [WeeztixController::class, 'callback'])->name('callback');
            Route::get("/create-token", [WeeztixController::class, "createToken"])->name("create-token");
            Route::post('/refresh-token', [WeeztixController::class, 'refreshToken'])->name('refresh-token');
        });

        Route::prefix('/newsletter')->group(function () {
            route::get('/index', [NewsletterController::class, 'index'])->name('admin.newsletter.index');
            route::post('/send', [NewsletterController::class, 'sendNewsletter'])->name('newsletter.send');
        });
    });
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::get('/events', [EventController::class, 'index'])->name('user.events.index');
Route::prefix('/event')->group(function () {
    Route::get('/{id}', [EventController::class, 'show'])->name('user.event.show');
    Route::middleware(['auth'])->group(function () {
        Route::post('/register/{id}', [EventController::class, 'register'])->name('user.event.register');
        Route::delete('/unregister/{id}', [EventController::class, 'unregister'])->name('user.event.unregister');
    });
});

Route::get('/about-us',[AboutUsController::class,'index'])->name('user.about-us.index');

Route::get('/gallery', [GalleryController::class, 'index'])->name('user.galleries.index');
Route::get('/sponsors', [SponsorController::class, 'index'])->name('user.sponsors.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'index'])->name('user.profile.index');
    Route::post('/profile/update', [UserController::class, 'update'])->name('user.profile.update');
    Route::post('/profile/password', [UserController::class, 'password'])->name('user.password.update');
});

Route::get('/assignments', [AssignmentController::class, 'index'])->name('user.assignments.index');
Route::get('/assignment/{id}', [AssignmentController::class, 'show'])->name('user.assignment.show');

Route::get('/calender', [CalenderController::class, 'index'])->name('user.calender.index');
Route::get('/calendar.ics', [CalenderController::class, 'generateICS'])->name('calendar.ics.default');
Route::get('/calendar/{id?}.ics', [CalenderController::class, 'generateICS'])->name('calendar.ics');

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])
    ->middleware(['signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


