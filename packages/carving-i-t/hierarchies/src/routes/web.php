<?php

    use CarvingIT\Hierarchies\Controllers\HierarchiesController;

        Route::get('/', [HierarchiesController::class, 'index'])->name('hierarchies');
        Route::post('/add_position',[HierarchiesController::class, 'addPosition'])->name('add_position');
        Route::post('/remove_position', [HierarchiesController::class, 'removePosition'])->name('remove_position');
        Route::post('/fill_position', [HierarchiesController::class, 'fillPosition'])->name('fill_position');
        Route::get('/suggest_user', [HierarchiesController::class, 'suggestUser'])->name('suggest_user');
        Route::post('/remove_position_user', [HierarchiesController::class, 'removePositionUser'])->name('remove_position_user');
?>
