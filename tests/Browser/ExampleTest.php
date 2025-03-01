<?php

use App\Models\User;
use Laravel\Dusk\Browser;

it('can open a modal and close it', function () {
    $this->browse(function (Browser $browser) {
        $user = User::orderBy('name')->first();

        $browser
            ->loginAs(1)
            ->visit(route('users.index'))
            ->waitFor('table')
            ->press('@edit-user-'.$user->id)
            ->waitFor('@modal-content')
            ->assertUrlIs(route('users.edit', $user))
            ->within('@modal-content', function (Browser $browser) {
                $browser->press('CANCEL');
            })
            ->waitUntilMissing('@modal-wrapper')
            ->assertUrlIs(route('users.index'));
    });
});

it('can update a user', function () {
    $this->browse(function (Browser $browser) {
        $user = User::orderBy('name')->firstOrFail();

        $newName = fake()->name;
        $newEmail = fake()->safeEmail;

        $browser
            ->loginAs(1)
            ->visit(route('users.index'))
            ->waitFor('table')
            ->press('@edit-user-'.$user->id)
            ->waitFor('@modal-content')
            ->within('@modal-content', function (Browser $browser) use ($newName, $newEmail) {
                $browser
                    ->type('name', $newName)
                    ->type('email', $newEmail)
                    ->press('UPDATE');
            })
            ->waitForText('User updated successfully');

        $user->refresh();

        expect($user->name)
            ->toBe($newName)
            ->and($user->email)
            ->toBe($newEmail);
    });
});

it('can show a validation error within the modal', function () {
    $this->browse(function (Browser $browser) {
        $user = User::orderBy('name')->firstOrFail();

        $browser
            ->loginAs(1)
            ->visit(route('users.index'))
            ->waitFor('table')
            ->press('@edit-user-'.$user->id)
            ->waitFor('@modal-content')
            ->within('@modal-content', function (Browser $browser) {
                $browser->type('email', 'not-valid-email')
                    ->press('UPDATE')
                    ->waitForText('The email field must be a valid email address');
            });

        expect($user->fresh()->email)
            ->not->toBe('not-valid-email');
    });
});
