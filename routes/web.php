<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityNightController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RoosterController;
use App\Http\Controllers\SponsorController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//AboutUsController
Route::prefix('/about-us')->group(function () {
    Route::get('/', [AboutUsController::class, 'index'])->name('about-us.index');

    Route::prefix('/board-members')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/create', [AboutUsController::class, 'create_board_member'])->name('board-members.create');
        Route::post('/store', [AboutUsController::class, 'store_board_member'])->name('board-members.store');
        Route::get('/{boardMember}/edit', [AboutUsController::class, 'edit_board_member'])->name('board-members.edit');
        Route::put('/{boardMember}', [AboutUsController::class, 'update_board_member'])->name('board-members.update');
        Route::delete('/{boardMember}', [AboutUsController::class, 'destroy_board_member'])->name('board-members.destroy');
    });

    Route::prefix('/previous-boards')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/{previousBoard}/edit', [AboutUsController::class, 'edit_previous_board'])->name('previous-boards.edit');
        Route::put('/{previousBoard}', [AboutUsController::class, 'update_previous_board'])->name('previous-boards.update');
    });
});

//AccountController
Route::prefix('/account')->middleware(['auth', 'verified', 'role:student,admin'])->group(function () {
    Route::get('/', [AccountController::class, 'show'])->name('account.show');
    Route::get('/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/update', [AccountController::class, 'update'])->name('account.update');
    Route::post('{user}/update-user-role', [AccountController::class, 'updateUserRole'])->middleware(['role:admin'])->name('account.updateUserRole');
});

//CommunityNightController
Route::prefix('/community-nights')->group(function () {
    Route::get('/', [CommunityNightController::class, 'index'])->name('community-nights.index');

    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/create', [CommunityNightController::class, 'create'])->name('community-nights.create');
        Route::post('/store', [CommunityNightController::class, 'store'])->name('community-nights.store');
        Route::get('/{communityNight}/edit', [CommunityNightController::class, 'edit'])->name('community-nights.edit');
        Route::put('/{communityNight}', [CommunityNightController::class, 'update'])->name('community-nights.update');
        Route::delete('/{communityNight}', [CommunityNightController::class, 'destroy'])->name('community-nights.destroy');
    });

    Route::get('/{communityNight}', [CommunityNightController::class, 'show'])->name('community-nights.show');
});

//AnnouncementController
Route::prefix('/announcements')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('announcements.index');

    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });
});

//AssignmentController
Route::prefix('/assignments')->group(function () {
    Route::get('/', [AssignmentController::class, 'index'])->name('assignments.index');

    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
        Route::put('/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    });
});

//AuthController
Route::prefix('/auth')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
    Route::post('/register', [AuthController::class, 'Register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
    Route::post('/login', [AuthController::class, 'login'])->middleware(['throttle:6,1'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth'])->name('logout');
});

//EventController
Route::prefix('/email')->group(function () {
    Route::get('/verify', function () {
        return view('auth.verify');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.notice');

    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Er is een nieuwe verificatielink is gestuurd!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

//EventController
Route::prefix('/events')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/download-all-ics', [EventController::class, 'DownloadAllICS'])->name('events.download-ics');
    Route::get('/{event}/download-ics', [EventController::class, 'downloadIcs'])->name('events.ics');

    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/store', [EventController::class, 'store'])->name('events.store');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });
});

//GalleryController
Route::prefix('/gallery')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');

    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/create', [GalleryController::class, 'create'])->name('gallery.create');
        Route::post('/', [GalleryController::class, 'store'])->name('gallery.store');
        Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    });
});

//HomeController
Route::get('/', [HomeController::class, 'index'])->name('home');

//NewsletterController
//TODO: Commented out because of request from student association
//Route::prefix('/newsletters')->group(function () {
//    Route::get('/', [NewsletterController::class, 'index'])->name('newsletter.index');
//    Route::get('/create', [NewsletterController::class, 'create'])->name('newsletter.create');
//    Route::post('/', [NewsletterController::class, 'store'])->name('newsletter.store');
//    Route::get('/{newsletter}/edit', [NewsletterController::class, 'edit'])->name('newsletter.edit');
//    Route::put('/{newsletter}', [NewsletterController::class, 'update'])->name('newsletter.update');
//});

//RegistrationController
Route::prefix('/registrations')->middleware(['auth', 'verified', 'throttle:6,1', 'role:admin,student'])->group(function () {
    Route::post('/', [RegistrationController::class, 'store'])->name('registrations.store');
});

//RoosterController
Route::prefix('/rosters')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/', [RoosterController::class, 'index'])->name('roosters.index');
    Route::post('/', [RoosterController::class, 'store'])->name('roosters.store');
    Route::delete('/{rooster}', [RoosterController::class, 'destroy'])->name('roosters.destroy');
});

//SponsorController
Route::prefix('/sponsors')->group(function () {
    Route::get('/', [SponsorController::class, 'index'])->name('sponsors.index');

    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/create', [SponsorController::class, 'create'])->name('sponsors.create');
        Route::post('/', [SponsorController::class, 'store'])->name('sponsors.store');
        Route::get('/{sponsor}/edit', [SponsorController::class, 'edit'])->name('sponsors.edit');
        Route::put('/{sponsor}', [SponsorController::class, 'update'])->name('sponsors.update');
        Route::post('/{sponsor}', [SponsorController::class, 'destroy'])->name('sponsors.destroy');
        Route::get('/{sponsor}/restore', [SponsorController::class, 'restore'])->name('sponsors.restore');
        Route::delete('/{sponsor}/force-delete', [SponsorController::class, 'forceDelete'])->name('sponsors.force-delete');
    });
});
