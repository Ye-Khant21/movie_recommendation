<x-layouts.app title="Register">
    <div class="mx-auto flex max-w-6xl justify-center px-4 py-16 sm:px-6">
        <x-auth-card title="Join CineMatch" subtitle="Set up a profile later — this screen is the UI first.">
            <form data-ui-form class="flex flex-col gap-4">
                <x-ui.input name="name" label="Name" placeholder="Alex Rivera" required />
                <x-ui.input name="email" type="email" label="Email" placeholder="you@email.com" required />
                <x-ui.input name="password" type="password" label="Password" required />
                <x-ui.input name="password_confirmation" type="password" label="Confirm password" required />
                <x-ui.button type="submit">Create account</x-ui.button>
                <p data-form-success hidden class="text-sm text-gold">Register form is visual only. Backend comes next.</p>
            </form>
            <p class="mt-6 text-sm text-mist/80">
                Already have an account?
                <a href="{{ route('login') }}" class="text-gold hover:underline">Log in</a>
            </p>
        </x-auth-card>
    </div>
</x-layouts.app>
