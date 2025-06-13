<div class="ms-lg-5 me-lg-5">
    <h3>
        Reviews &nbsp;&nbsp;
        <i class="bi bi-star-fill title-color fs-4"></i>
        @if ($reviews->count() > 0 && $reviews->avg('rate') !== null)
            {{ number_format($reviews->avg('rate'), 1) }}
        @else
            No rating yet.
        @endif
        <div class="mt-2">
            @php
                $userReview = $book->reviews->where('user_id', auth()->id())->first();
            @endphp

            @if (auth()->user()->can('create', App\Models\Review::class) && !$userReview)
                <x-button data-bs-toggle="modal" data-bs-target="#addReviewModal">
                    <i class="bi bi-plus-circle"></i> Add Review
                </x-button>
            @endif
        </div>
    </h3>
    <div class="row mt-3">
        @forelse($reviews as $review)
            <x-card class="col-lg-6 mb-3" style="height: 200px">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex gap-3">
                        <div class="rounded-circle overflow-hidden" style="width: 40px; height: 40px">
                          <img
                            src="{{ $review->user->member->photo ?? asset('images/default.png') }}"
                            alt="User Avatar"
                            class="img-fluid"
                            style="width: 40px"
                          />
                        </div>
                        <div class="text-start">
                            <h5 class="mb-0">{{ $review->user->name ?? 'Anonymous' }}</h5>
                            @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star-fill fs-7 {{ $i <= $review->rate ? 'title-color' : 'text-secondary' }}"></i>
                            @endfor
                        </div>
                    </div>
                    @can('delete', $review)
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="text-start">
                      @csrf
                      @method('DELETE')
                      <button
                          type="submit"
                          class="btn ms-1"
                          style="background-color: #7b3b3b; color: #e2ba76"
                      >
                          <i class="bi bi-trash"></i>
                      </button>
                    </form>
                    @endcan
                </div>
                <div class="overflow-auto scroll mt-2" style="max-height: 90px;">
                    {{ $review->comment }}
                </div>
            </x-card>
        @empty
            <x-card>No reviews yet.</x-card>
        @endforelse
    </div>
</div>

<div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('reviews.store') }}">
      @csrf
      <input type="hidden" name="book_id" value="{{ $book->id ?? request()->route('book') }}">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addReviewModalLabel">Add Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <x-input-option
            type="select"
            name="rate"
            label="Rating"
            :options="[
                '' => 'Select rating',
                1 => '1 Star',
                2 => '2 Stars',
                3 => '3 Stars',
                4 => '4 Stars',
                5 => '5 Stars',
            ]"
            required="true"
          />
          <x-input-text-area 
            name="comment" 
            label="Comment" 
            placeholder="Write your review..." 
            rows="3"
          />
        </div>
        <div class="modal-footer">
          <x-dark-button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</x-dark-button>
          <x-button type="submit" class="btn btn-dark-gold">Submit Review</x-button>
        </div>
      </div>
    </form>
  </div>
</div>
