<?php

use App\User;
use App\Entity\Region;
use App\Entity\Adverts\Category;
use App\Entity\Adverts\Attribute;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > Login
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('home');
    $trail->push('Login', route('login'));
});

// Home > Login > Reset Password
Breadcrumbs::for('password.request', function ($trail) {
    $trail->parent('login');
    $trail->push('Reset Password', route('password.request'));
});

// Home > Register
Breadcrumbs::for('register', function ($trail) {
    $trail->parent('home');
    $trail->push('Register', route('register'));
});

// Home > Cabinet
Breadcrumbs::for('cabinet.home', function ($trail) {
    $trail->parent('home');
    $trail->push('Cabinet', route('cabinet.home'));
});

// Home > Cabinet > Profile
Breadcrumbs::for('cabinet.profile.home', function ($trail) {
    $trail->parent('cabinet.home');
    $trail->push('Profile', route('cabinet.profile.home'));
});

// Home > Cabinet > Profile > Edit
Breadcrumbs::for('cabinet.profile.edit', function ($trail) {
    $trail->parent('cabinet.profile.home');
    $trail->push('Edit', route('cabinet.profile.edit'));
});

// Home > Admin
Breadcrumbs::for('admin.home', function ($trail) {
    $trail->parent('home');
    $trail->push('Admin', route('admin.home'));
});

Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Users', route('admin.users.index'));
});
Breadcrumbs::for('admin.users.create', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push('Create', route('admin.users.create'));
});
Breadcrumbs::for('admin.users.show', function ($trail, User $user) {
    $trail->parent('admin.users.index');
    $trail->push($user->name, route('admin.users.show', $user));
});
Breadcrumbs::for('admin.users.edit', function ($trail, User $user) {
    $trail->parent('admin.users.show', $user);
    $trail->push('Edit', route('admin.users.edit', $user));
});

Breadcrumbs::for('admin.regions.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Regions', route('admin.regions.index'));
});
Breadcrumbs::for('admin.regions.create', function ($trail) {
    $trail->parent('admin.regions.index');
    $trail->push('Create', route('admin.regions.create'));
});
Breadcrumbs::for('admin.regions.show', function ($trail, Region $region) {
    if ($parent = $region->parent) {
        $trail->parent('admin.regions.show', $parent); // laralearn рекурсия
    } else {
        $trail->parent('admin.regions.index');
    }
    $trail->push($region->name, route('admin.regions.show', $region));
});
Breadcrumbs::for('admin.regions.edit', function ($trail, Region $region) {
    $trail->parent('admin.regions.show', $region);
    $trail->push('Edit', route('admin.regions.edit', $region));
});

Breadcrumbs::for('admin.adverts.categories.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Categories', route('admin.adverts.categories.index'));
});
Breadcrumbs::for('admin.adverts.categories.create', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push('Create', route('admin.adverts.categories.create'));
});
Breadcrumbs::for('admin.adverts.categories.show', function ($trail, Category $category) {
    if ($parent = $category->parent) {
        $trail->parent('admin.adverts.categories.show', $parent);
    } else {
        $trail->parent('admin.adverts.categories.index');
    }
    $trail->push($category->name, route('admin.adverts.categories.show', $category));
});
Breadcrumbs::for('admin.adverts.categories.edit', function ($trail, Category $category) {
    $trail->parent('admin.adverts.categories.show', $category);
    $trail->push('Edit', route('admin.adverts.categories.edit', $category));
});

// Advert Category Attributes

Breadcrumbs::register('admin.adverts.categories.attributes.create', function ($trail, Category $category) {
    $trail->parent('admin.adverts.categories.show', $category);
    $trail->push('Create attribute', route('admin.adverts.categories.attributes.create', $category));
});

Breadcrumbs::register('admin.adverts.categories.attributes.show', function ($trail, Category $category, Attribute $attribute) {
    $trail->parent('admin.adverts.categories.show', $category);
    $trail->push($attribute->name, route('admin.adverts.categories.attributes.show', [$category, $attribute]));
});

Breadcrumbs::register('admin.adverts.categories.attributes.edit', function ($trail, Category $category, Attribute $attribute) {
    $trail->parent('admin.adverts.categories.attributes.show', $category, $attribute);
    $trail->push('Edit', route('admin.adverts.categories.attributes.edit', [$category, $attribute]));
});

// Home > Blog > [Category]
//Breadcrumbs::for('category', function ($trail, $category) {
//    if ($category->parent) {
//        $trail->parent('category', $category->parent);
//    }
//    $trail->push($category->title, route('category', $category->id));
//});

// Home > Blog > [Category] > [Post]
//Breadcrumbs::for('post', function ($trail, $post) {
//    $trail->parent('category', $post->category);
//    $trail->push($post->title, route('post', $post->id));
//});
