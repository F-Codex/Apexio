<div class="d-flex flex-column h-100 bg-white">
    {{-- Header --}}
    <div class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between flex-shrink-0 bg-white">
        <div class="d-flex align-items-center gap-3 overflow-hidden">
            <div class="d-flex align-items-center justify-content-center rounded bg-light text-secondary flex-shrink-0" style="width: 32px; height: 32px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 400px;">{{ $task->title }}</h6>
                <small class="text-muted">in {{ $task->status }}</small>
            </div>
        </div>
        
        <button type="button" class="btn-close" wire:click="$dispatch('close-modal')" aria-label="Close"></button>
    </div>

    {{-- Chat List --}}
    <div class="flex-grow-1 overflow-y-auto p-4" style="background-color: #f8fafc;">
        @forelse($comments as $comment)
            <div class="d-flex gap-3 mb-4 animate-fade-in">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    <img src="{{ $comment->user->avatar_url }}" 
                         class="rounded-circle border border-white shadow-sm" 
                         width="32" height="32" style="object-fit: cover;">
                </div>
                
                <div class="flex-grow-1">
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <span class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $comment->user->name }}</span>
                        <span class="text-muted" style="font-size: 0.75rem;">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="bg-white p-3 rounded-3 border shadow-sm text-dark" style="font-size: 0.95rem; line-height: 1.5;">
                        {!! nl2br(e($comment->body)) !!}
                    </div>
                </div>
            </div>
        @empty
            <div class="h-100 d-flex flex-column align-items-center justify-content-center text-muted opacity-75">
                <div class="bg-light rounded-circle p-3 mb-3">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <p class="mb-0 fw-medium">No comments yet</p>
                <small>Start the discussion!</small>
            </div>
        @endforelse
    </div>

    {{-- Input Form --}}
    <div class="p-3 bg-white border-top">
        <form wire:submit.prevent="saveComment">
            <div class="input-group">
                <textarea 
                    class="form-control bg-light border-0 focus-ring" 
                    rows="1" 
                    placeholder="Write a comment..."
                    wire:model="newComment"
                    style="resize: none; min-height: 48px; padding-top: 12px; border-radius: 8px 0 0 8px;"
                    required
                ></textarea>
                
                <button type="submit" class="btn btn-primary px-4 d-flex align-items-center" style="border-radius: 0 8px 8px 0;">
                    <span wire:loading.remove>Send</span>
                    <span wire:loading><div class="spinner-border spinner-border-sm"></div></span>
                </button>
            </div>
            @error('newComment') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
        </form>
    </div>
</div>