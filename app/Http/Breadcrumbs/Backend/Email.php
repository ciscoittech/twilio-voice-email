<?php

Breadcrumbs::register('admin.emails.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.emails.management'), route('admin.emails.index'));
});

Breadcrumbs::register('admin.emails.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.emails.index');
    $breadcrumbs->push(trans('menus.backend.emails.create'), route('admin.emails.create'));
});

Breadcrumbs::register('admin.emails.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.emails.index');
    $breadcrumbs->push(trans('menus.backend.emails.edit'), route('admin.emails.edit', $id));
});
