<form wire:submit.prevent="submit" class="flex gap-3 items-start">

    <textarea wire:model.defer="form.body" x-data x-ref="textarea"
        x-on:input="
            $refs.textarea.style.height = 'auto';
            const max = 30 * 24;
            $refs.textarea.style.height = Math.min($refs.textarea.scrollHeight, max) + 'px';"
        placeholder="Add a comment..."
        class="flex-1 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 mt-1 text-gray-200 placeholder-gray-500 focus:ring focus:ring-blue-500 resize-none overflow-hidden"
        rows="1" onkeydown="if(event.key === 'Enter' && !event.shiftKey){ event.preventDefault(); }"></textarea>

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 mt-1 rounded-lg font-semibold">
        Send
    </button>

</form>
