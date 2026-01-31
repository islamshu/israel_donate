@if($media->count())
<div class="media-grid">
    @foreach($media as $m)
    <div class="media-item" data-media-id="{{ $m->id }}">
        <div class="media-thumb js-media-preview"
             data-bs-toggle="modal" 
             data-bs-target="#editModal"
             data-id="{{ $m->id }}"
             data-url="{{ $m->url }}"
             data-alt="{{ $m->alt ?? '' }}"
             data-title="{{ $m->title ?? '' }}"
             data-caption="{{ $m->caption ?? '' }}"
             data-description="{{ $m->description ?? '' }}"
             data-filename="{{ $m->file_name }}"
             data-size="{{ $m->human_size }}"
             data-type="{{ $m->mime_type }}"
             data-date="{{ $m->created_at->format('Y/m/d') }}">
            <img src="{{ $m->url }}" alt="{{ $m->alt ?? '' }}" loading="lazy">
            <div class="media-thumb-overlay">
                <span class="text-white">
                    <i class="fas fa-search-plus fa-2x"></i>
                </span>
            </div>
        </div>
        
        <div class="media-info">
            <div class="media-filename" title="{{ $m->file_name }}">
                {{ Str::limit($m->file_name, 25) }}
            </div>
            <div class="media-meta">
                <span>{{ $m->human_size }}</span>
                <span>{{ $m->created_at->format('Y/m/d') }}</span>
            </div>
        </div>

        <div class="media-actions">
            @if($selectMode)
            <button type="button"
                    class="btn btn-primary btn-sm js-select-media"
                    data-id="{{ $m->id }}"
                    data-url="{{ $m->url }}"
                    data-alt="{{ $m->alt ?? '' }}">
                <i class="fas fa-check me-1"></i> اختيار
            </button>
            @endif
            
            <button type="button"
                    class="btn-action js-media-edit"
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal"
                    data-id="{{ $m->id }}"
                    data-url="{{ $m->url }}"
                    data-alt="{{ $m->alt ?? '' }}"
                    data-title="{{ $m->title ?? '' }}"
                    data-caption="{{ $m->caption ?? '' }}"
                    data-description="{{ $m->description ?? '' }}"
                    data-filename="{{ $m->file_name }}"
                    data-size="{{ $m->human_size }}"
                    data-type="{{ $m->mime_type }}"
                    data-date="{{ $m->created_at->format('Y/m/d') }}"
                    title="تعديل">
                <i class="fas fa-edit"></i>
            </button>
            
            <button type="button" 
                    class="btn-action delete js-media-delete" 
                    data-id="{{ $m->id }}"
                    title="حذف">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="empty-state-icon">
        <i class="far fa-images"></i>
    </div>
    <h5>لا توجد وسائط بعد</h5>
    <p class="text-muted">ابدأ برفع الوسائط الأولى بالنقر على زر "رفع وسائط جديدة"</p>
</div>
@endif