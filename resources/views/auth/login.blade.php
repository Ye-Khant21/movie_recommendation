<x-layouts.app title="Login">
    <div class="mx-auto flex max-w-6xl justify-center px-4 py-16 sm:px-6">
        <x-auth-card title="Welcome back" subtitle="UI only for now — no account is created yet.">
            <form data-ui-form class="flex flex-col gap-4">
                <x-ui.input name="email" type="email" label="Email" placeholder="you@email.com" required />
                <x-ui.input name="password" type="password" label="Password" required />
                <x-ui.button type="submit">Log in</x-ui.button>
                <p data-form-success hidden class="text-sm text-gold">Login form is visual only. Backend comes next.</p>
            </form>
            <p class="mt-6 text-sm text-mist/80">
                New here?
                <a href="{{ route('register') }}" class="text-gold hover:underline">Create an account</a>
            </p>
        </x-auth-card>
    </div>
</x-layouts.app>
