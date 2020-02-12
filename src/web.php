<?php

Route::group(['middleware' => 'web'], function () {
    Route::post('uniben/cms/update', 'UniBen\CMS\Controllers\EditableController@update');
});
