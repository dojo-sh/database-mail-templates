<?php

use DojoSh\DatabaseMailTemplates\Http\Controllers\DatabaseMailTemplateController;

if (config('database-mail-templates.show_admin')) {
    Route::resource('database-mail-templates', DatabaseMailTemplateController::class, [
        'except' => ['create', 'show'],
    ]);
    Route::get('database-mail-templates/{database_mail_template}/preview', [DatabaseMailTemplateController::class, 'preview'])->name('database-mail-templates.preview');
}
