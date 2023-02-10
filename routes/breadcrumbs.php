<?php

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\User;
use App\Entity\Region;
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

// Home > Login
Breadcrumbs::for('login.phone', function ($trail) {
    $trail->parent('home');
    $trail->push('Login', route('login.phone'));
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

// Adverts

Breadcrumbs::register('adverts.inner_region', function ($trail, Region $region = null, Category $category = null) {
    if ($region && $parent = $region->parent) {
        $trail->parent('adverts.inner_region', $parent, $category);
    } else {
        $trail->parent('home');
        $trail->push('Adverts', route('adverts.index'));
    }
    if ($region) {
        $trail->push($region->name, route('adverts.index', $region, $category));
    }
});

Breadcrumbs::register('adverts.inner_category', function ($trail, Region $region = NULL, Category $category = NULL) {
    if ($category && $parent = $category->parent) {
        $trail->parent('adverts.inner_category', $region, $parent);
    } else {
        $trail->parent('adverts.inner_region', $region, $category);
    }
    if ($category) {
        $trail->push($category->name, route('adverts.index', $region, $category));
    }
});

Breadcrumbs::register('adverts.index', function ($trail, Region $region = NULL, Category $category = NULL) {
    $trail->parent('adverts.inner_category', $region, $category);
});

Breadcrumbs::register('adverts.show', function ($trail, Advert $advert) {
    $trail->parent('adverts.index', $advert->region, $advert->category);
    $trail->push($advert->title, route('adverts.show', $advert));
});

// Home > Cabinet
Breadcrumbs::for('cabinet.home', function ($trail) {
    $trail->parent('home');
    $trail->push('Cabinet', route('cabinet.home'));
});

// Home > Cabinet > Adverts
Breadcrumbs::for('cabinet.adverts.index', function ($trail) {
    $trail->parent('cabinet.home');
    $trail->push('Adverts', route('cabinet.adverts.index'));
});

Breadcrumbs::for('cabinet.adverts.create', function ($trail) {
    $trail->parent('adverts.index');
    $trail->push('Create', route('cabinet.adverts.create'));
});

Breadcrumbs::for('cabinet.adverts.create.region', function ($trail, Category $category, Region $region = NULL) {
    $trail->parent('cabinet.adverts.create');
    $trail->push($category->name, route('cabinet.adverts.create.region', [$category, $region]));
});

Breadcrumbs::for('cabinet.adverts.create.advert', function ($trail, Category $category, Region $region = NULL) {
    $trail->parent('cabinet.adverts.create.region', $category, $region);
    $trail->push($region ? $region->name : 'All', route('cabinet.adverts.create.advert', [$category, $region]));
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

Breadcrumbs::register('cabinet.profile.phone', function ($trail) {
    $trail->parent('cabinet.profile.home');
    $trail->push('Phone', route('cabinet.profile.phone'));
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
