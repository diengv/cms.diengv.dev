<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Asset Category
    Route::delete('asset-categories/destroy', 'AssetCategoryController@massDestroy')->name('asset-categories.massDestroy');
    Route::resource('asset-categories', 'AssetCategoryController');

    // Asset Location
    Route::delete('asset-locations/destroy', 'AssetLocationController@massDestroy')->name('asset-locations.massDestroy');
    Route::resource('asset-locations', 'AssetLocationController');

    // Asset Status
    Route::delete('asset-statuses/destroy', 'AssetStatusController@massDestroy')->name('asset-statuses.massDestroy');
    Route::resource('asset-statuses', 'AssetStatusController');

    // Asset
    Route::delete('assets/destroy', 'AssetController@massDestroy')->name('assets.massDestroy');
    Route::post('assets/media', 'AssetController@storeMedia')->name('assets.storeMedia');
    Route::post('assets/ckmedia', 'AssetController@storeCKEditorImages')->name('assets.storeCKEditorImages');
    Route::resource('assets', 'AssetController');

    // Assets History
    Route::resource('assets-histories', 'AssetsHistoryController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Task Status
    Route::delete('task-statuses/destroy', 'TaskStatusController@massDestroy')->name('task-statuses.massDestroy');
    Route::resource('task-statuses', 'TaskStatusController');

    // Task Tag
    Route::delete('task-tags/destroy', 'TaskTagController@massDestroy')->name('task-tags.massDestroy');
    Route::resource('task-tags', 'TaskTagController');

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    Route::post('tasks/ckmedia', 'TaskController@storeCKEditorImages')->name('tasks.storeCKEditorImages');
    Route::resource('tasks', 'TaskController');

    // Tasks Calendar
    Route::resource('tasks-calendars', 'TasksCalendarController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Cms Taxonomy
    Route::delete('cms-taxonomies/destroy', 'CmsTaxonomyController@massDestroy')->name('cms-taxonomies.massDestroy');
    Route::resource('cms-taxonomies', 'CmsTaxonomyController');

    // Cms Term
    Route::delete('cms-terms/destroy', 'CmsTermController@massDestroy')->name('cms-terms.massDestroy');
    Route::post('cms-terms/parse-csv-import', 'CmsTermController@parseCsvImport')->name('cms-terms.parseCsvImport');
    Route::post('cms-terms/process-csv-import', 'CmsTermController@processCsvImport')->name('cms-terms.processCsvImport');
    Route::resource('cms-terms', 'CmsTermController');

    // Cms Term Taxonomy
    Route::delete('cms-term-taxonomies/destroy', 'CmsTermTaxonomyController@massDestroy')->name('cms-term-taxonomies.massDestroy');
    Route::post('cms-term-taxonomies/media', 'CmsTermTaxonomyController@storeMedia')->name('cms-term-taxonomies.storeMedia');
    Route::post('cms-term-taxonomies/ckmedia', 'CmsTermTaxonomyController@storeCKEditorImages')->name('cms-term-taxonomies.storeCKEditorImages');
    Route::resource('cms-term-taxonomies', 'CmsTermTaxonomyController');

    // Cms Term Relationships
    Route::delete('cms-term-relationships/destroy', 'CmsTermRelationshipsController@massDestroy')->name('cms-term-relationships.massDestroy');
    Route::resource('cms-term-relationships', 'CmsTermRelationshipsController');

    // Cms Post
    Route::delete('cms-posts/destroy', 'CmsPostController@massDestroy')->name('cms-posts.massDestroy');
    Route::post('cms-posts/media', 'CmsPostController@storeMedia')->name('cms-posts.storeMedia');
    Route::post('cms-posts/ckmedia', 'CmsPostController@storeCKEditorImages')->name('cms-posts.storeCKEditorImages');
    Route::post('cms-posts/parse-csv-import', 'CmsPostController@parseCsvImport')->name('cms-posts.parseCsvImport');
    Route::post('cms-posts/process-csv-import', 'CmsPostController@processCsvImport')->name('cms-posts.processCsvImport');
    Route::resource('cms-posts', 'CmsPostController');

    // Cms Conten Type
    Route::delete('cms-conten-types/destroy', 'CmsContenTypeController@massDestroy')->name('cms-conten-types.massDestroy');
    Route::resource('cms-conten-types', 'CmsContenTypeController');

    // Cms Content Meta
    Route::delete('cms-content-meta/destroy', 'CmsContentMetaController@massDestroy')->name('cms-content-meta.massDestroy');
    Route::post('cms-content-meta/parse-csv-import', 'CmsContentMetaController@parseCsvImport')->name('cms-content-meta.parseCsvImport');
    Route::post('cms-content-meta/process-csv-import', 'CmsContentMetaController@processCsvImport')->name('cms-content-meta.processCsvImport');
    Route::resource('cms-content-meta', 'CmsContentMetaController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});
