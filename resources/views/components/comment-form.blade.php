<form data-ui-form class="flex flex-col gap-4 rounded-xl border border-line/70 bg-panel p-5">
    <h3 class="text-lg font-semibold text-white">Leave a comment</h3>
    <x-ui.input name="name" label="Your name" placeholder="Alex" required />
    <x-ui.textarea name="comment" label="Comment" placeholder="What did you think?" required />
    <x-ui.button type="submit">Post comment</x-ui.button>
    <p data-form-success hidden class="text-sm text-gold">Comment posted on the page only — backend comes later.</p>
</form>
