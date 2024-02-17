<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Assets History
    Route::apiResource('assets-histories', 'AssetsHistoryApiController', ['except' => ['store', 'show', 'update', 'destroy']]);

    // Cms Taxonomy
    Route::apiResource('cms-taxonomies', 'CmsTaxonomyApiController');

    // Cms Term
    Route::apiResource('cms-terms', 'CmsTermApiController');

    // Cms Term Taxonomy
    Route::post('cms-term-taxonomies/media', 'CmsTermTaxonomyApiController@storeMedia')->name('cms-term-taxonomies.storeMedia');
    Route::apiResource('cms-term-taxonomies', 'CmsTermTaxonomyApiController');

    // Cms Term Relationships
    Route::apiResource('cms-term-relationships', 'CmsTermRelationshipsApiController');

    // Cms Post
    Route::post('cms-posts/media', 'CmsPostApiController@storeMedia')->name('cms-posts.storeMedia');
    Route::apiResource('cms-posts', 'CmsPostApiController');

    // Cms Conten Type
    Route::apiResource('cms-conten-types', 'CmsContenTypeApiController');

    // Cms Content Meta
    Route::apiResource('cms-content-meta', 'CmsContentMetaApiController');
});
