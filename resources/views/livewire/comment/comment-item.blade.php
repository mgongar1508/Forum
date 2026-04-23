@php $user = $comment->user; @endphp
<div class="flex gap-3 mt-6">
    <img src="{{ Storage::url($comment->user->profile_photo_path) }}" class="w-8 h-8 rounded-full" />
    <div class="flex-1">
        <div class="flex items-center gap-2 text-sm text-gray-400" wire:click="toggleCollapse">
            <span class="font-semibold text-gray-300">{{ $comment->user->name }}</span>
            <span>•</span>
            <span>{{ $comment->created_at->diffForHumans() }}</span>
            @if (auth()->check() &&
                    (auth()->user()->hasRole(['admin', 'moderator']) ||
                        auth()->id() === $comment->user_id))
                <button wire:click.stop="deleteComment" class="text-red-500 hover:text-red-700 ml-2">
                    <i class="fa-solid fa-trash"></i>
                </button>
            @endif
            @if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->id() === $comment->user_id))
                <button wire:click.stop="startEditComment" class="text-gray-400 hover:text-gray-200 mr-2">
                    <i class="fa-solid fa-pen"></i>
                </button>
            @endif
        </div>
        @if (!$collapsed)
            @if ($editing)
                <div class="flex flex-col gap-2">
                    <textarea wire:model.defer="editBody"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-gray-200 resize-none"></textarea>

                    <div class="flex gap-2">
                        <button wire:click="updateComment"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                            Save
                        </button>

                        <button wire:click="$set('editing', false)"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded">
                            Cancel
                        </button>
                    </div>
                </div>
            @else
                <p class="text-gray-300 break-words break-all">{{ $comment->body }}</p>

                <button wire:click="startReply" class="text-gray-400 hover:text-gray-200">
                    <i class="fa-solid fa-reply"></i> Reply
                </button>

                @if ($replying)
                    <livewire:comment.create-comment :post="$comment->commentable" :parentId="$comment->id" :key="'reply-' . $comment->id" />
                @endif
            @endif

            @if ($comment->children->count())
                <div class="mt-4 ml-4 border-l border-gray-700 pl-3">
                    @foreach ($comment->children as $child)
                        <livewire:comment.comment-item :comment="$child" :key="'child-' . $child->id" />
                    @endforeach
                </div>
            @endif
        @else
            <!-- COLLAPSED PREVIEW -->
            <p class="text-xs text-gray-500 italic ml-2">
                Comment collapsed
            </p>
        @endif
    </div>
</div>
